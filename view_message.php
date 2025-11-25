<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$message_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// FIX: Query updated to match database schema (no subject/title)
$sql = "SELECT m.id, m.message, m.timestamp, m.is_read, u.full_name, u.role 
        FROM messages m 
        JOIN users u ON m.sender_id = u.id 
        WHERE m.id = $message_id AND m.receiver_id = $admin_id";

$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    // Mark as read
    if ($row['is_read'] == 0) {
        mysqli_query($conn, "UPDATE messages SET is_read = 1 WHERE id = $message_id");
    }
} else {
    die("Message not found or access denied.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Message</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --primary: #1e1e2d;
            --secondary: #2b2b40;
            --accent: #ff4d4d;
            --bg-light: #f5f6fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 260px;
            background-color: var(--primary);
            color: #fff;
            position: fixed;
            height: 100%;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
            width: 100%;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #aab0c6;
            text-decoration: none;
        }

        .menu-item:hover {
            background-color: var(--secondary);
            color: #fff;
            border-left: 4px solid var(--accent);
        }

        .brand {
            padding: 30px 20px;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .msg-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .msg-meta {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
            color: #555;
        }

        .msg-body {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            white-space: pre-line;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            background: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="brand">MEDICARE PLUS</div>
        <a href="dashboard_admin.php" class="menu-item">Dashboard</a>
        <a href="admin-inbox.php" class="menu-item" style="color:white; background:var(--secondary); border-left:4px solid var(--accent);">Inbox</a>
        <a href="manage_doctors.php" class="menu-item">Doctors</a>
    </div>

    <div class="main-content">
        <h1>Read Message</h1>
        <div class="msg-box">
            <div class="msg-meta">
                <strong>From:</strong> <?php echo htmlspecialchars($row['full_name']); ?> (<?php echo ucfirst($row['role']); ?>)<br>
                <strong>Received:</strong> <?php echo date('F j, Y, g:i a', strtotime($row['timestamp'])); ?>
            </div>
            <div class="msg-body">
                <?php echo nl2br(htmlspecialchars($row['message'])); ?>
            </div>
            <a href="admin-inbox.php" class="btn-back">Back to Inbox</a>
        </div>
    </div>
</body>

</html>