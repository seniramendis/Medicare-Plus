<?php
// login.php
session_start();
$pageTitle = 'Login / Signup';
$pageKey = 'login';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Medicare Plus' : 'Medicare Plus'; ?></title>
    <link rel="icon" href="images/Favicon.png" type="image/png">

    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- 1. GLOBAL RESET --- */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- 2. CARD CONTAINER --- */
        .page-container {
            width: 92%;
            max-width: 700px;
            margin: 40px auto;
            padding: 40px 50px;
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 30, 90, 0.1);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* --- 3. TABS --- */
        .login-tabs {
            display: flex;
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 30px;
        }

        .tab-link {
            flex: 1;
            padding: 15px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: 600;
            color: #a0a0a0;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .tab-link.active {
            color: #1e3a8a;
            border-bottom: 3px solid #1e3a8a;
        }

        .tab-link:hover:not(.active) {
            color: #555;
        }

        /* --- 4. FORMS --- */
        .login-form-content {
            display: none;
        }

        .login-form-content.active {
            display: block;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        h2 {
            text-align: center;
            color: #1e3a8a;
            margin: 0 0 10px 0;
        }

        p.subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 0.95em;
        }

        /* --- 5. GRID SYSTEM --- */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full-width {
            grid-column: span 2;
        }

        /* --- 6. INPUT STYLING --- */
        .input-group label {
            display: block;
            font-size: 0.85em;
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        input,
        select {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            font-size: 0.95em;
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
            transition: 0.3s;
        }

        input[type="date"] {
            padding-right: 15px;
        }

        input:focus,
        select:focus {
            background: #fff;
            border-color: #1e3a8a;
            outline: none;
            box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.1);
        }

        /* --- 7. ICONS --- */
        .left-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 1em;
            pointer-events: none;
            transition: 0.3s;
        }

        input:focus+.left-icon,
        select:focus+.left-icon {
            color: #1e3a8a;
        }

        /* --- 8. EYE ICON --- */
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            cursor: pointer;
            font-size: 1em;
            transition: 0.2s;
            z-index: 10;
        }

        .toggle-password:hover {
            color: #1e3a8a;
        }

        /* --- 9. BUTTONS --- */
        .submit-btn {
            width: 100%;
            padding: 14px;
            margin-top: 10px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            font-family: 'Poppins', sans-serif;
        }

        .btn-login {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
        }

        .btn-signup {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* --- 10. ALERTS --- */
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 0.9em;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 600px) {
            .page-container {
                padding: 25px;
                width: 95%;
                margin: 20px auto;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .full-width {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <main class="page-container">

        <?php
        if (isset($_GET['error'])) {
            $msg = "An error occurred.";
            if ($_GET['error'] == "password_mismatch") $msg = "Passwords do not match.";
            if ($_GET['error'] == "email_taken") $msg = "Email already registered.";
            if ($_GET['error'] == "wrong_password") $msg = "Invalid email or password.";
            if ($_GET['error'] == "no_user") $msg = "Account not found.";
            if ($_GET['error'] == "empty_fields") $msg = "Please fill in all required fields.";
            echo '<div class="alert alert-error">' . $msg . '</div>';
        }
        if (isset($_GET['success'])) {
            echo '<div class="alert alert-success">Account created! Please login.</div>';
        }
        ?>

        <div class="login-tabs">
            <button class="tab-link <?php echo (!isset($_GET['tab']) || $_GET['tab'] != 'signup') ? 'active' : ''; ?>" onclick="openTab('login')">Login</button>
            <button class="tab-link <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'signup') ? 'active' : ''; ?>" onclick="openTab('signup')">Create Account</button>
        </div>

        <div id="login" class="login-form-content <?php echo (!isset($_GET['tab']) || $_GET['tab'] != 'signup') ? 'active' : ''; ?>">
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="images/Logo4.png" alt="Logo" style="width: 120px;">
            </div>
            <h2>Welcome Back</h2>
            <p class="subtitle">Enter your credentials to access your account.</p>

            <form action="login_process.php" method="POST">
                <div class="input-group" style="margin-bottom: 20px;">
                    <label>Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" required placeholder="you@example.com">
                        <i class="fa-solid fa-envelope left-icon"></i>
                    </div>
                </div>

                <div class="input-group" style="margin-bottom: 20px;">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="login-pass" required placeholder="Enter password">
                        <i class="fa-solid fa-lock left-icon"></i>
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePass('login-pass', this)"></i>
                    </div>
                </div>

                <button type="submit" class="submit-btn btn-login">Login</button>

                <div style="text-align: center; margin-top: 20px;">
                    <a href="#" style="color: #666; font-size: 0.9em; text-decoration: none;">Forgot Password?</a>
                </div>
            </form>
        </div>

        <div id="signup" class="login-form-content <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'signup') ? 'active' : ''; ?>">
            <h2>Create Account</h2>
            <p class="subtitle">Fill in your details to join Medicare Plus.</p>

            <form action="signup_process.php" method="POST" class="form-grid">
                <div class="input-group full-width">
                    <label>Full Name</label>
                    <div class="input-wrapper">
                        <input type="text" name="full_name" required placeholder="John Doe">
                        <i class="fa-solid fa-user left-icon"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label>Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" required placeholder="you@email.com">
                        <i class="fa-solid fa-envelope left-icon"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label>Phone Number</label>
                    <div class="input-wrapper">
                        <input type="tel" name="phone" placeholder="07X XXX XXXX">
                        <i class="fa-solid fa-phone left-icon"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label>Date of Birth</label>
                    <div class="input-wrapper">
                        <input type="date" name="dob" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Gender</label>
                    <div class="input-wrapper">
                        <select name="gender" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <i class="fa-solid fa-venus-mars left-icon"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="reg-pass" required placeholder="Create password">
                        <i class="fa-solid fa-lock left-icon"></i>
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePass('reg-pass', this)"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label>Confirm Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="confirm_password" id="reg-pass-conf" required placeholder="Confirm password">
                        <i class="fa-solid fa-check-double left-icon"></i>
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePass('reg-pass-conf', this)"></i>
                    </div>
                </div>

                <div class="full-width">
                    <button type="submit" class="submit-btn btn-signup">Create Account</button>
                </div>
            </form>
        </div>

    </main>

    <?php include 'footer.php'; ?>

    <script>
        // Tab Switching Logic
        function openTab(tabName) {
            document.querySelectorAll('.login-form-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-link').forEach(el => el.classList.remove('active'));

            document.getElementById(tabName).classList.add('active');

            const buttons = document.querySelectorAll('.tab-link');
            if (tabName === 'login') buttons[0].classList.add('active');
            else buttons[1].classList.add('active');
        }

        // Password Toggle Logic
        function togglePass(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>

</html>