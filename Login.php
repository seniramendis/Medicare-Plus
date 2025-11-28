<?php
session_start();
include 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $login_type = $_POST['login_type'];

    // 1. Check if user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // 2. VERIFY PASSWORD
        if (password_verify($password, $user['password'])) {

            // 3. SECURITY CHECK: Block Admins from public login
            if ($user['role'] == 'admin') {
                $error = "Security Alert: Admins must use the <a href='admin_login.php'>Admin Portal</a>.";
            }
            // 4. LOGIC CHECK: Prevent Patients from using Doctor Login
            elseif ($login_type == 'doctor' && $user['role'] != 'doctor') {
                $error = "Access Denied. You are not authorized to access the Doctor Portal.";
            }
            // 5. LOGIC CHECK: Prevent Doctors from using Patient Login
            elseif ($login_type == 'patient' && $user['role'] == 'doctor') {
                $error = "You are a Doctor. Please switch to the Doctor Login tab.";
            } else {

                // --- SEPARATION LOGIC START ---
                // Set the User Session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];

                // CRITICAL: If an Admin was logged in, KILL the Admin session.
                // This ensures total separation. You cannot be Admin + Patient.
                if (isset($_SESSION['admin_id'])) {
                    unset($_SESSION['admin_id']);
                }
                // --- SEPARATION LOGIC END ---

                // 6. REDIRECT TO DASHBOARDS
                if ($user['role'] == 'doctor') {
                    header("Location: dashboard_doctor.php");
                    exit();
                } elseif ($user['role'] == 'patient') {
                    header("Location: dashboard_patient.php");
                    exit();
                }
            }
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Account not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Medicare Plus</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-login-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 20px;
        }

        .login-container {
            background-color: #fff;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #eee;
        }

        /* --- THEMES --- */
        .patient-theme {
            border-top: 5px solid #1e3a8a;
        }

        .patient-theme h2 {
            color: #1e3a8a;
        }

        .patient-theme button {
            background-color: #1e3a8a;
        }

        .patient-theme button:hover {
            background-color: #152c69;
        }

        .doctor-theme {
            border-top: 5px solid #57c95a;
        }

        .doctor-theme h2 {
            color: #0f5132;
        }

        .doctor-theme button {
            background-color: #57c95a;
        }

        .doctor-theme button:hover {
            background-color: #46a349;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            font-size: 0.9em;
            color: #666;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1em;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #888;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .switch-text {
            margin-top: 25px;
            font-size: 0.9em;
            color: #666;
        }

        .switch-text span {
            color: #1e3a8a;
            font-weight: bold;
            cursor: pointer;
            text-decoration: underline;
        }

        .register-link {
            margin-top: 15px;
            font-size: 0.95em;
        }

        .register-link a {
            color: #1e3a8a;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .error-msg {
            background-color: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 0.9em;
            border-left: 4px solid #c62828;
            text-align: left;
        }

        .error-msg a {
            color: #c62828;
            font-weight: bold;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>

    <?php if (file_exists('header.php')) {
        include 'header.php';
    } ?>

    <main class="main-login-wrapper">
        <div class="login-container patient-theme" id="loginCard">

            <?php if ($error): ?>
                <div class="error-msg"><i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="hidden" name="login_type" id="loginType" value="patient">

                <h2 id="formTitle">Patient Login</h2>
                <p style="color: #777; font-size: 0.9em; margin-bottom: 25px;" id="formDesc">
                    Access your medical history and appointments.
                </p>

                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="e.g., name@email.com">
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Enter your password">
                </div>

                <button type="submit" id="submitBtn">Login</button>
            </form>

            <div class="register-link" id="registerBox">
                New here? <a href="register.php">Create an Account</a>
            </div>

            <div class="switch-text" id="patientLinkBox">
                Medical Staff? <span onclick="switchToDoctor()">Doctor Login here</span>
            </div>

            <div class="switch-text hidden" id="doctorLinkBox">
                Not a doctor? <span onclick="switchToPatient()">Patient Login here</span>
            </div>
        </div>
    </main>

    <?php if (file_exists('footer.php')) {
        include 'footer.php';
    } ?>

    <script>
        function switchToDoctor() {
            const card = document.getElementById('loginCard');
            card.classList.remove('patient-theme');
            card.classList.add('doctor-theme');

            document.getElementById('formTitle').innerText = "Doctor Portal";
            document.getElementById('formDesc').innerText = "Authorized medical personnel only.";
            document.getElementById('submitBtn').innerText = "Access Dashboard";
            document.getElementById('registerBox').classList.add('hidden');
            document.getElementById('patientLinkBox').classList.add('hidden');
            document.getElementById('doctorLinkBox').classList.remove('hidden');
            document.getElementById('loginType').value = "doctor";
        }

        function switchToPatient() {
            const card = document.getElementById('loginCard');
            card.classList.remove('doctor-theme');
            card.classList.add('patient-theme');

            document.getElementById('formTitle').innerText = "Patient Login";
            document.getElementById('formDesc').innerText = "Access your medical history and appointments.";
            document.getElementById('submitBtn').innerText = "Login";
            document.getElementById('registerBox').classList.remove('hidden');
            document.getElementById('doctorLinkBox').classList.add('hidden');
            document.getElementById('patientLinkBox').classList.remove('hidden');
            document.getElementById('loginType').value = "patient";
        }

        <?php if (isset($_POST['login_type']) && $_POST['login_type'] == 'doctor'): ?>
            switchToDoctor();
        <?php endif; ?>
    </script>
</body>

</html>