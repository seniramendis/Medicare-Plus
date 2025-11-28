<?php
// chat_engine.php
session_start();
include 'db_connect.php';

define('ENCRYPTION_KEY', 'MedicarePlus_Secret_Key_2025_Secure!');
define('CIPHER_METHOD', 'AES-256-CBC');

function encrypt_msg($message)
{
    $key = hash('sha256', ENCRYPTION_KEY);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(CIPHER_METHOD));
    $encrypted = openssl_encrypt($message, CIPHER_METHOD, $key, 0, $iv);
    return ['msg' => base64_encode($encrypted), 'iv' => base64_encode($iv)];
}

function decrypt_msg($encrypted_msg, $iv_encoded)
{
    if (empty($iv_encoded)) return $encrypted_msg;
    $key = hash('sha256', ENCRYPTION_KEY);
    $iv = base64_decode($iv_encoded);
    return openssl_decrypt(base64_decode($encrypted_msg), CIPHER_METHOD, $key, 0, $iv);
}

// --- USER IDENTIFICATION ---
$user_identifier = "";
$user_name = "Guest";
$user_type = "guest";

if (isset($_SESSION['doctor_id']) || (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'doctor' && isset($_SESSION['user_id']))) {
    $id = isset($_SESSION['doctor_id']) ? $_SESSION['doctor_id'] : $_SESSION['user_id'];
    $user_identifier = "doctor_" . $id;
    $user_type = 'doctor';
    $stmt = $conn->prepare("SELECT name FROM doctors WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $user_name = ($row = $res->fetch_assoc()) ? "Dr. " . $row['name'] : "Doctor";
} elseif (isset($_SESSION['user_id']) || isset($_SESSION['patient_id'])) {
    $id = isset($_SESSION['patient_id']) ? $_SESSION['patient_id'] : $_SESSION['user_id'];
    $user_identifier = "user_" . $id;
    $user_type = 'patient';
    $stmt = $conn->prepare("SELECT full_name FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $user_name = ($row = $res->fetch_assoc()) ? $row['full_name'] : "Registered User";
} else {
    if (!isset($_SESSION['guest_chat_id'])) $_SESSION['guest_chat_id'] = "guest_" . uniqid();
    $user_identifier = $_SESSION['guest_chat_id'];
    $user_name = "Guest Visitor";
    $user_type = 'guest';
}

$action = $_POST['action'] ?? '';

// --- ACTIONS ---

if ($action == 'get_unread_count') {
    $stmt = $conn->prepare("SELECT id FROM conversations WHERE user_identifier = ?");
    $stmt->bind_param("s", $user_identifier);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $countStmt = $conn->prepare("SELECT COUNT(*) as unread FROM messages_chat WHERE conversation_id = ? AND sender_type = 'admin' AND is_read = 0");
        $countStmt->bind_param("i", $row['id']);
        $countStmt->execute();
        echo $countStmt->get_result()->fetch_assoc()['unread'];
    } else {
        echo "0";
    }
    exit;
}

if ($action == 'send_msg_user' || $action == 'send_msg_admin') {
    $sender = ($action == 'send_msg_user') ? 'user' : 'admin';
    $raw_msg = trim($_POST['message'] ?? '');
    $attachment = NULL;

    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
        $ext = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            if (!is_dir('uploads')) mkdir('uploads');
            $newName = uniqid() . "." . $ext;
            $target = "uploads/" . $newName;
            move_uploaded_file($_FILES['attachment']['tmp_name'], $target);
            $attachment = $target;
        }
    }

    if (!empty($raw_msg) || $attachment) {
        $enc_data = encrypt_msg($raw_msg);
        $encrypted_text = $enc_data['msg'];
        $iv_text = $enc_data['iv'];

        if ($sender == 'user') {
            $stmt = $conn->prepare("SELECT id FROM conversations WHERE user_identifier = ?");
            $stmt->bind_param("s", $user_identifier);
            $stmt->execute();
            $res = $stmt->get_result();
            $preview = $attachment ? "Sent an attachment" : "🔒 Encrypted Message";

            if ($row = $res->fetch_assoc()) {
                $conv_id = $row['id'];
                $upd = $conn->prepare("UPDATE conversations SET user_name = ?, user_type = ?, last_message = ?, last_activity = NOW() WHERE id = ?");
                $upd->bind_param("sssi", $user_name, $user_type, $preview, $conv_id);
                $upd->execute();
            } else {
                $stmt = $conn->prepare("INSERT INTO conversations (user_identifier, user_name, user_type, last_message, last_activity) VALUES (?, ?, ?, ?, NOW())");
                $stmt->bind_param("ssss", $user_identifier, $user_name, $user_type, $preview);
                $stmt->execute();
                $conv_id = $stmt->insert_id;
            }
        } else {
            $conv_id = $_POST['conversation_id'];
            $preview = "Admin: " . ($attachment ? "Attachment" : "🔒 Message");
            $upd = $conn->prepare("UPDATE conversations SET last_message = ?, last_activity = NOW() WHERE id = ?");
            $upd->bind_param("si", $preview, $conv_id);
            $upd->execute();
        }

        $stmt = $conn->prepare("INSERT INTO messages_chat (conversation_id, sender_type, message_text, iv, attachment_path, is_read) VALUES (?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("issss", $conv_id, $sender, $encrypted_text, $iv_text, $attachment);
        $stmt->execute();
        echo "sent";
    }
}

if ($action == 'delete_message') {
    // Admin Deleting
    $stmt = $conn->prepare("DELETE FROM messages_chat WHERE id = ?");
    $stmt->bind_param("i", $_POST['message_id']);
    $stmt->execute();
}

if ($action == 'delete_msg_user') {
    // User Deleting (Soft Delete)
    $stmt = $conn->prepare("UPDATE messages_chat SET is_deleted_by_user = 1 WHERE id = ? AND sender_type = 'user'");
    $stmt->bind_param("i", $_POST['message_id']);
    $stmt->execute();
}

// --- FETCH MESSAGES ---
if ($action == 'fetch_chat_admin' || $action == 'fetch_chat_user') {
    $is_admin_view = ($action == 'fetch_chat_admin');

    if ($is_admin_view) {
        $conv_id = $_POST['conversation_id'];
        $stmt = $conn->prepare("SELECT * FROM messages_chat WHERE conversation_id = ? ORDER BY created_at ASC");
        $stmt->bind_param("i", $conv_id);
    } else {
        $stmt = $conn->prepare("
            SELECT m.*, c.id as conv_id FROM messages_chat m 
            JOIN conversations c ON m.conversation_id = c.id 
            WHERE c.user_identifier = ? 
            AND m.is_deleted_by_user = 0
            ORDER BY m.created_at ASC
        ");
        $stmt->bind_param("s", $user_identifier);
    }

    $stmt->execute();
    $res = $stmt->get_result();

    // Mark as Read Logic
    if (!$is_admin_view && $res->num_rows > 0) {
        $updateRead = $conn->prepare("UPDATE messages_chat SET is_read = 1 WHERE sender_type = 'admin' AND is_read = 0 AND conversation_id = (SELECT id FROM conversations WHERE user_identifier = ?)");
        $updateRead->bind_param("s", $user_identifier);
        $updateRead->execute();
    }
    if ($is_admin_view && $res->num_rows > 0) {
        $updateRead = $conn->prepare("UPDATE messages_chat SET is_read = 1 WHERE sender_type = 'user' AND is_read = 0 AND conversation_id = ?");
        $updateRead->bind_param("i", $conv_id);
        $updateRead->execute();
    }

    while ($row = $res->fetch_assoc()) {
        $sender = $row['sender_type'];
        $decrypted_text = decrypt_msg($row['message_text'], $row['iv']);

        // Determine classes based on VIEW (Admin vs User)
        if ($is_admin_view) {
            $cls = ($sender == 'admin') ? 'admin-msg' : 'user-msg';
        } else {
            $cls = ($sender == 'user') ? 'user-msg' : 'admin-msg';
        }

        // Attachment
        $attach_html = "";
        if ($row['attachment_path']) {
            $ext = pathinfo($row['attachment_path'], PATHINFO_EXTENSION);
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                $attach_html = "<img src='{$row['attachment_path']}' class='chat-img' onclick='window.open(this.src)'>";
            } else {
                $attach_html = "<a href='{$row['attachment_path']}' target='_blank' class='chat-file'><i class='fa fa-paperclip'></i> Attachment</a>";
            }
        }

        // Delete Button Logic (Only show for 'My' messages)
        $action_btn = "";
        if ($is_admin_view && $sender == 'admin') {
            $action_btn = "<i class='fas fa-trash delete-btn' onclick='deleteMessage({$row['id']})' title='Delete'></i>";
        }
        if (!$is_admin_view && $sender == 'user') {
            $action_btn = "<i class='fas fa-trash delete-btn' onclick='deleteMyMessage({$row['id']})' title='Delete'></i>";
        }

        echo "<div class='message-wrapper $cls'>
                $action_btn
                <div class='message-bubble'>
                    {$attach_html}
                    <div>" . htmlspecialchars($decrypted_text) . "</div>
                    <div class='msg-time'>" . date('h:i A', strtotime($row['created_at'])) . "</div>
                </div>
              </div>";
    }
}

// --- FETCH LIST (ADMIN) ---
// UPDATED FOR PROFESSIONAL NOTIFICATIONS
if ($action == 'fetch_conversations_admin') {
    $res = $conn->query("SELECT * FROM conversations ORDER BY last_activity DESC");
    if ($res->num_rows == 0) echo "<div style='padding:20px; text-align:center; color:#999;'>No active conversations</div>";

    while ($row = $res->fetch_assoc()) {
        $active = (isset($_POST['active_id']) && $_POST['active_id'] == $row['id']) ? 'active-chat' : '';
        $initials = strtoupper(substr($row['user_name'], 0, 1));

        // Count unread
        $unreadStmt = $conn->prepare("SELECT COUNT(*) as cnt FROM messages_chat WHERE conversation_id = ? AND sender_type = 'user' AND is_read = 0");
        $unreadStmt->bind_param("i", $row['id']);
        $unreadStmt->execute();
        $uCount = $unreadStmt->get_result()->fetch_assoc()['cnt'];

        // NEW BADGE HTML using 'unread-badge' class
        $notify = ($uCount > 0) ? "<div class='unread-badge'>$uCount</div>" : "";

        // Smart Time Formatting (Time for today, Date for older)
        $timeRaw = strtotime($row['last_activity']);
        $timeDisplay = (date('Y-m-d') == date('Y-m-d', $timeRaw)) ? date('h:i A', $timeRaw) : date('M d', $timeRaw);

        // HTML Structure Update: Badge moved to bottom right
        echo "<div class='conv-item $active' onclick='loadAdminChat({$row['id']})' 
                   data-name='" . htmlspecialchars($row['user_name']) . "' 
                   data-initial='$initials'>
                <div class='conv-avatar'>$initials</div>
                <div class='conv-info'>
                    <div class='conv-top'>
                        <span class='conv-name'>{$row['user_name']}</span>
                        <span class='time-ago'>$timeDisplay</span>
                    </div>
                    <div class='conv-bottom'>
                        <span class='conv-preview'>" . htmlspecialchars($row['last_message']) . "</span>
                        $notify
                    </div>
                </div>
              </div>";
    }
}
