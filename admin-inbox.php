<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Using correct 'message' column based on previous fix
$inbox_query = "
    SELECT 
        m.id, 
        m.message, 
        m.timestamp as sent_at, 
        m.is_read,
        u.full_name AS sender_name,
        u.role AS sender_role
    FROM 
        messages m
    JOIN 
        users u ON m.sender_id = u.id
    WHERE 
        m.receiver_id = $admin_id 
    ORDER BY 
        m.timestamp DESC";

$inbox_result = mysqli_query($conn, $inbox_query);

// *** 1. SET ACTIVE PAGE ***
$current_page = 'messages.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inbox - Admin | MEDICARE PLUS</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --bg: #f1f5f9;
            --surface: #ffffff;
            --text: #334155;
            --text-light: #64748b;
            --border: #e2e8f0;
            --danger: #ef4444;
            --success: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg);
            display: flex;
            min-height: 100vh;
            color: var(--text);
        }

        .main-content {
            margin-left: 260px;
            padding: 40px;
            width: calc(100% - 260px);
        }

        .header-title h1 {
            font-size: 28px;
            color: #0f172a;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .inbox-container {
            background: var(--surface);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
        }

        .inbox-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
        }

        .inbox-header h2 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
            margin: 0;
        }

        .btn-compose {
            background: var(--primary);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: 0.2s;
            font-size: 13px;
        }

        .btn-compose:hover {
            background: var(--primary-dark);
        }

        .message-item {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            cursor: pointer;
            transition: 0.2s;
        }

        .message-item:hover {
            background-color: #f8fafc;
        }

        .message-item.unread {
            background-color: #eff6ff;
        }

        .message-item.unread .message-sender {
            font-weight: 700;
            color: var(--primary);
        }

        .message-sender {
            width: 200px;
            color: var(--text);
            font-size: 14px;
            font-weight: 500;
        }

        .message-preview {
            flex-grow: 1;
            padding: 0 20px;
            color: var(--text-light);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 14px;
        }

        .message-time {
            width: 120px;
            text-align: right;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h1 class="header-title">Admin Inbox</h1>
        <div class="inbox-container">
            <div class="inbox-header">
                <h2>Messages</h2>
                <button class="btn-compose" onclick="window.location.href='compose_message.php'"><i class="fas fa-pen"></i> New Message</button>
            </div>
            <div class="message-list">
                <?php
                if (mysqli_num_rows($inbox_result) > 0) {
                    while ($row = mysqli_fetch_assoc($inbox_result)) {
                        $is_unread = ($row['is_read'] == 0) ? 'unread' : '';
                        $preview = substr(strip_tags($row['message']), 0, 60) . '...';
                        $sender = htmlspecialchars($row['sender_name']) . ' (' . ucfirst($row['sender_role']) . ')';

                        echo '<div class="message-item ' . $is_unread . '" onclick="window.location.href=\'view_message.php?id=' . $row['id'] . '\'">';
                        echo '<div class="message-sender">' . $sender . '</div>';
                        echo '<div class="message-preview">' . htmlspecialchars($preview) . '</div>';
                        echo '<div class="message-time">' . date('M j, H:i', strtotime($row['sent_at'])) . '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div style="padding:30px; text-align:center; color:#94a3b8;">No messages found.</div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>