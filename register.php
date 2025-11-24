<?php
session_start();
include 'db_connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitize & Collect Inputs
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name'])); // This matches your form input name
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'patient';

    // 2. Validations
    if ($password !== $confirm_password) {
        $message = "<div class='alert error'>Passwords do not match!</div>";
    } else {
        // Check if email exists
        $check = "SELECT id FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $check);

        if (mysqli_num_rows($result) > 0) {
            $message = "<div class='alert error'>Email already exists!</div>";
        } else {
            // 3. SECURE HASHING 
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 4. Insert Data (FIXED: changed 'username' to 'full_name')
            $sql = "INSERT INTO users (full_name, email, phone, dob, gender, password, role) 
                    VALUES ('$full_name', '$email', '$phone', '$dob', '$gender', '$hashed_password', '$role')";

            if (mysqli_query($conn, $sql)) {
                $message = "<div class='alert success'>Registration successful! <a href='login.php'>Login here</a></div>";
            } else {
                $message = "<div class='alert error'>Error: " . mysqli_error($conn) . "</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Medicare Plus</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <style>
        /* Styles tailored for Medicare Plus */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-reg-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .reg-container {
            background-color: #fff;
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border-top: 5px solid #1e3a8a;
        }

        h2 {
            color: #1e3a8a;
            text-align: center;
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-size: 0.9em;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1em;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #1e3a8a;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .btn:hover {
            background-color: #152c69;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 0.9em;
            text-align: center;
        }

        .error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #666;
        }

        .login-link a {
            color: #1e3a8a;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <?php if (file_exists('header.php')) {
        include 'header.php';
    } ?>

    <main class="main-reg-wrapper">
        <div class="reg-container">
            <h2>Create Patient Account</h2>
            <?php echo $message; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" required placeholder="John Doe">
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="john@example.com">
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" required placeholder="071 123 4567">
                </div>

                <div style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Gender</label>
                        <select name="gender" required>
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" required>
                </div>

                <button type="submit" class="btn">Register</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        </div>
    </main>

    <?php if (file_exists('footer.php')) {
        include 'footer.php';
    } ?>

</body>

</html>