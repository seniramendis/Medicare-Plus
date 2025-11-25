<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, full_name, email, password FROM users WHERE email = '$email' AND role = 'admin'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {

            // *** CRITICAL CHANGE: Use Admin-specific session keys for isolation ***
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['role'] = 'admin'; // Keep the role for dashboard security
            $_SESSION['username'] = $row['full_name']; // Use full_name for better display

            // Clear any existing generic user session to prevent conflicts on the public site
            unset($_SESSION['user_id']);

            header("Location: dashboard_admin.php");
            exit();
        } else {
            $error = "Invalid Admin Credentials.";
        }
    } else {
        $error = "Access Denied: You are not an Admin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Portal | MEDICARE PLUS</title>

    <link rel="icon" href="images/Favicon.png" type="image/png">

    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #0f0f0f;
            color: #e0e0e0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        .admin-box {
            background-color: #1f1f1f;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
            width: 350px;
            border: 1px solid #333;
            position: relative;
        }

        .logo-area {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-area i {
            font-size: 40px;
            color: #ff4d4d;
            margin-bottom: 10px;
        }

        .logo-area h3 {
            margin: 0;
            color: #fff;
            letter-spacing: 1px;
            font-weight: 400;
        }

        h2 {
            text-align: center;
            color: #ff4d4d;
            letter-spacing: 3px;
            font-size: 14px;
            text-transform: uppercase;
            margin-top: 10px;
            opacity: 0.8;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            background: #2b2b2b;
            border: 1px solid #444;
            color: white;
            box-sizing: border-box;
            border-radius: 4px;
            transition: 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #ff4d4d;
            background: #333;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #ff4d4d;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 15px;
            transition: 0.3s;
        }

        button:hover {
            background: #e60000;
            box-shadow: 0 0 10px rgba(255, 77, 77, 0.4);
        }

        .error {
            color: #ff4d4d;
            text-align: center;
            font-size: 0.85em;
            margin-top: 15px;
            background: rgba(255, 77, 77, 0.1);
            padding: 10px;
            border-radius: 4px;
        }

        .return-link {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
        }

        .return-link a {
            color: #777;
            text-decoration: none;
            transition: 0.3s;
        }

        .return-link a:hover {
            color: #fff;
        }

        .security-notice {
            margin-top: 30px;
            color: #444;
            font-size: 0.75em;
            text-align: center;
            max-width: 300px;
        }
    </style>
</head>

<body>

    <div class="admin-box">
        <div class="logo-area">
            <i class="fas fa-shield-alt"></i>
            <h3>MEDICARE PLUS</h3>
        </div>

        <h2>System Login</h2>

        <form method="POST" action="">
            <input type="email" name="email" placeholder="Admin Email" required autocomplete="off">
            <input type="password" name="password" placeholder="Access Key" required>
            <button type="submit">AUTHENTICATE</button>
        </form>

        <?php if (isset($error)) {
            echo "<p class='error'><i class='fas fa-exclamation-circle'></i> $error</p>";
        } ?>

        <div class="return-link">
            <a href="Home.php"><i class="fas fa-arrow-left"></i> Return to Public Site</a>
        </div>
    </div>

    <div class="security-notice">
        Authorized Personnel Only. All login attempts are monitored and IP addresses are logged.
    </div>

</body>

</html>