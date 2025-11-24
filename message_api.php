<?php
// message_api.php
session_start();
ini_set('display_errors', 0);
error_reporting(E_ALL);

include 'db_connect.php';

header('Content-Type: application/json');

// --- SECURITY CONFIGURATION ---
// KEEP THIS KEY SECRET! If you change this, all previous messages will become unreadable.
define('ENCRYPTION_KEY', 'medicare_plus_secret_key_2025_secure_hash_xyz');
define('ENCRYPTION_METHOD', 'aes-256-cbc');

// --- HELPER FUNCTIONS ---

function encrypt_text($data)
{
    if (empty($data)) return $data;
    // Generate a random initialization vector (IV)
    $ivLength = openssl_cipher_iv_length(ENCRYPTION_METHOD);
    $iv = openssl_random_pseudo_bytes($ivLength);

    // Encrypt
    $encrypted = openssl_encrypt($data, ENCRYPTION_METHOD, ENCRYPTION_KEY, 0, $iv);

    // Return as Base64 (IV + :: + EncryptedData)
    return base64_encode($encrypted . '::' . $iv);
}

function decrypt_text($data)
{
    if (empty($data)) return $data;

    // Check if it looks like our encrypted format (Base64)
    // If not, it's probably an old plain-text message, so just return it.
    if (strpos(base64_decode($data), '::') === false) {
        return $data;
    }

    try {
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, ENCRYPTION_METHOD, ENCRYPTION_KEY, 0, $iv);
    } catch (Exception $e) {
        return "Error decrypting";
    }
}

// --- MAIN LOGIC ---

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

$my_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';

try {
    // --- 1. GET CONTACTS ---
    if ($action === 'get_contacts') {
        $my_role = $_SESSION['role'] ?? 'patient';

        $sql = "SELECT * FROM users WHERE id != ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $my_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while ($row = $result->fetch_assoc()) {

            // Name Logic
            $displayName = "User";
            if (!empty($row['full_name'])) {
                $displayName = $row['full_name'];
            } else if (!empty($row['first_name'])) {
                $displayName = trim($row['first_name'] . ' ' . ($row['last_name'] ?? ''));
            } else if (!empty($row['username'])) {
                $displayName = $row['username'];
            }
            if ($displayName === null || $displayName === "null") {
                $displayName = "User " . $row['id'];
            }

            $userRole = strtolower($row['role'] ?? 'user');
            $my_role_lower = strtolower($my_role);

            // Visibility Rules
            $showUser = false;
            if ($my_role_lower === 'patient' && $userRole === 'doctor') $showUser = true;
            if ($my_role_lower === 'doctor' && ($userRole === 'patient' || $userRole === 'admin')) $showUser = true;
            if ($my_role_lower === 'admin') $showUser = true;

            if ($showUser) {
                $cnt = 0;
                try {
                    $cntSql = "SELECT COUNT(*) as cnt FROM messages WHERE sender_id = ? AND receiver_id = ? AND is_read = 0";
                    $stmt2 = $conn->prepare($cntSql);
                    $stmt2->bind_param("ii", $row['id'], $my_id);
                    $stmt2->execute();
                    $cnt = $stmt2->get_result()->fetch_assoc()['cnt'];
                } catch (Exception $e) {
                    $cnt = 0;
                }

                $users[] = [
                    'id' => $row['id'],
                    'full_name' => $displayName,
                    'role' => ucfirst($userRole),
                    'unread_count' => $cnt
                ];
            }
        }
        echo json_encode($users);
        exit();
    }

    // --- 2. SEND MESSAGE (ENCRYPTED) ---
    if ($action === 'send') {
        $receiver_id = $_POST['receiver_id'] ?? 0;
        $raw_message = trim($_POST['message'] ?? '');
        $attachment = null;

        // 1. Handle Attachment
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
            $newName = uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadDir . $newName)) {
                $attachment = $newName;
            }
        }

        // 2. Encrypt the Message
        $encrypted_message = encrypt_text($raw_message);

        if ($raw_message || $attachment) {
            $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message, attachment, timestamp, is_read) VALUES (?, ?, ?, ?, NOW(), 0)");
            $stmt->bind_param("iiss", $my_id, $receiver_id, $encrypted_message, $attachment);
            $stmt->execute();
        }
        echo json_encode(['status' => 'success']);
        exit();
    }

    // --- 3. GET MESSAGES (DECRYPTED) ---
    if ($action === 'get_messages') {
        $other_id = $_POST['other_id'] ?? 0;

        $conn->query("UPDATE messages SET is_read = 1 WHERE sender_id = $other_id AND receiver_id = $my_id");

        $sql = "SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $my_id, $other_id, $other_id, $my_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $msgs = [];
        while ($row = $result->fetch_assoc()) {

            // DECRYPT HERE
            $decrypted_msg = decrypt_text($row['message']);

            $msgs[] = [
                'id' => $row['id'],
                'message' => htmlspecialchars($decrypted_msg), // Make safe for HTML
                'attachment' => $row['attachment'] ?? null,
                'timestamp' => $row['timestamp'],
                'is_me' => ($row['sender_id'] == $my_id)
            ];
        }
        echo json_encode($msgs);
        exit();
    }

    // --- 4. DELETE MESSAGE ---
    if ($action === 'delete_message') {
        $msg_id = $_POST['msg_id'];
        $conn->query("DELETE FROM messages WHERE id = $msg_id AND sender_id = $my_id");
        echo json_encode(['status' => 'success']);
        exit();
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit();
}
// --- 5. GET UNREAD COUNT (REAL-TIME BADGE) ---
if ($action === 'get_unread_count') {
    // Count messages sent TO me that I haven't read yet
    $sql = "SELECT COUNT(*) as count FROM messages WHERE receiver_id = ? AND is_read = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $my_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    echo json_encode(['count' => $data['count']]);
    exit();
}
