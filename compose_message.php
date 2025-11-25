<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$msg_status = '';

$recipient_query = "SELECT id, full_name, role FROM users WHERE id != $admin_id ORDER BY role, full_name";
$recipients_result = mysqli_query($conn, $recipient_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipient_id = mysqli_real_escape_string($conn, $_POST['recipient_id']);
    $body = mysqli_real_escape_string($conn, $_POST['body']);

    if (empty($recipient_id) || empty($body)) {
        $msg_status = '<p style="color:red;">Recipient and Message are required.</p>';
    } else {
        // FIX: Insert only into existing columns: sender_id, receiver_id, message
        $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$admin_id', '$recipient_id', '$body')";

        if (mysqli_query($conn, $sql)) {
            $msg_status = '<p style="color:green;">Message sent successfully!</p>';
        } else {
            $msg_status = '<p style="color:red;">Error: ' . mysqli_error($conn) . '</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compose Message</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
    <style>
        /* Minimal styling for brevity, matches previous files */
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

        .compose-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            max-width: 800px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        label {
            font-weight: 500;
            color: #333;
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
        <h1>Compose Message</h1>
        <div class="compose-box">
            <?php echo $msg_status; ?>
            <form method="POST">
                <label>To:</label>
                <select name="recipient_id" required>
                    <option value="">Select User</option>
                    <?php while ($row = mysqli_fetch_assoc($recipients_result)): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?> (<?php echo $row['role']; ?>)</option>
                    <?php endwhile; ?>
                </select>

                <label>Message:</label>
                <textarea name="body" rows="10" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>
</body>

</html>