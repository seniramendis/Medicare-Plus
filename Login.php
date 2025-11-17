<?php
// STEP 1: Define page-specific variables
// header.php will USE these variables, so they must come FIRST.
$pageTitle = 'Login / Signup';
$pageKey = 'login'; // Sets the "Login" button to active
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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- 1. GLOBAL BODY STYLES (Keep this here) --- */
        * {
            box-sizing: border-box;
        }

        /* --- UPDATED: Body Font & Background --- */
        body {
            margin: 0;
            font-family: 'Poppins', 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            /* UPDATED: Soft, professional gradient background */
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            line-height: 1.6;
            color: #333;
            /* Ensures content fills at least the viewport height */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- NEW: Entrance Animation for the card --- */
        @keyframes slideUpFadeIn {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* --- 2. PAGE-SPECIFIC STYLES (Login) --- */
        .page-container {
            width: 90%;
            max-width: 550px;
            /* FIX 3: Reduced the top margin from 120px to 80px to close the gap
            */
            margin: 30px auto 50px auto;
            padding: 40px 50px;
            background-color: #ffffff;
            border-radius: 16px;
            /* UPDATED: Softer, more modern shadow */
            box-shadow: 0 16px 40px rgba(0, 40, 100, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.5);
            /* NEW: Apply the entrance animation */
            animation: slideUpFadeIn 0.7s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* --- NEW: Logo Placeholder Style --- */
        .login-logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-logo img {
            max-width: 180px;
            height: auto;
        }

        /* --- NEW: Simple SVG placeholder if no img is used --- */
        .login-logo-placeholder {
            display: inline-block;
            padding: 15px 30px;
            background-color: #1e3a8a;
            /* Use your brand color */
            color: #fff;
            font-size: 1.5em;
            font-weight: 700;
            border-radius: 10px;
            letter-spacing: 1px;
            line-height: 1;
        }

        .login-container {
            max-width: 100%;
            margin: 0;
        }

        .login-tabs {
            display: flex;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 35px;
            position: relative;
        }

        .login-tabs::after {
            content: '';
            position: absolute;
            left: var(--_underline-left, 0);
            bottom: -2px;
            width: var(--_underline-width, 0);
            height: 3px;
            background-color: #1e3a8a;
            transition: all 0.3s ease;
        }

        .tab-link {
            flex: 1;
            padding: 18px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 1.25em;
            font-weight: 600;
            color: #99aab5;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
            /* UPDATED: Use the new font */
            font-family: 'Poppins', sans-serif;
        }

        .tab-link i {
            margin-right: 10px;
        }

        .tab-link.active {
            color: #1e3a8a;
            font-weight: 700;
        }

        .tab-link:hover:not(.active) {
            background-color: #f6f9fc;
            color: #555;
        }

        .login-form-content {
            display: none;
        }

        .login-form-content.active {
            display: block;
            animation: fade-in 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .login-form h2 {
            text-align: center;
            color: #1e3a8a;
            margin-top: 0;
            margin-bottom: 12px;
            font-size: 2.2em;
            font-weight: 700;
            /* UPDATED: Bolder */
        }

        .login-form p {
            text-align: center;
            color: #777;
            margin-bottom: 40px;
            font-size: 1.15em;
            font-weight: 500;
            /* UPDATED: Slightly bolder */
        }

        .login-form label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #444;
            font-size: 0.95em;
        }

        .input-group {
            margin-bottom: 25px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0c2d6;
            transition: color 0.3s ease, transform 0.3s ease;
            font-size: 1.1em;
        }

        .login-form input[type="text"],
        .login-form input[type="email"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 14px 15px 14px 50px;
            border: 1px solid #dbe2e8;
            border-radius: 10px;
            font-size: 1.05em;
            transition: all 0.3s ease;
            background-color: #fdfdfd;
            /* UPDATED: Use the new font */
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

        .login-form input[type="text"]:focus,
        .login-form input[type="email"],
        .login-form input[type="password"]:focus {
            outline: none;
            border-color: #2563eb;
            /* UPDATED: Slightly softer focus shadow */
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            background-color: #fff;
        }

        .login-form .input-wrapper input:focus+.input-icon {
            color: #1e3a8a;
            transform: translateY(-50%) scale(1.1);
        }

        .forgot-password {
            display: block;
            text-align: right;
            margin-top: -10px;
            margin-bottom: 30px;
            color: #2563eb;
            text-decoration: none;
            font-size: 0.95em;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
            color: #1e3a8a;
        }

        .login-submit-btn,
        .signup-submit-btn {
            width: 100%;
            padding: 15px;
            font-size: 1.15em;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: bold;
            letter-spacing: 0.8px;
            border-radius: 10px;
            /* UPDATED: Use the new font */
            font-family: 'Poppins', sans-serif;
        }

        .login-submit-btn i,
        .signup-submit-btn i {
            margin-right: 10px;
        }

        .login-submit-btn {
            background: linear-gradient(45deg, #1e3a8a 0%, #2563eb 100%) !important;
            color: white !important;
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.3);
        }

        .login-submit-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(30, 58, 138, 0.4);
            background: linear-gradient(45deg, #2563eb 0%, #3b82f6 100%) !important;
        }

        .signup-submit-btn {
            background: linear-gradient(45deg, #57c95a 0%, #68d86f 100%) !important;
            color: white !important;
            box-shadow: 0 6px 20px rgba(87, 201, 90, 0.3);
        }

        .signup-submit-btn:hover {
            background: linear-gradient(45deg, #68d86f 0%, #7ee085 100%) !important;
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(87, 201, 90, 0.4);
        }

        .social-divider {
            text-align: center;
            color: #b0c2d6;
            margin: 35px 0 30px 0;
            display: flex;
            align-items: center;
            font-size: 0.95em;
        }

        .social-divider span {
            background: #fff;
            padding: 0 20px;
            font-weight: 600;
        }

        .social-divider::before,
        .social-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }

        .social-login-buttons {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .social-btn {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid #dbe2e8;
            background: #fff;
            cursor: pointer;
            font-size: 1.05em;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            /* UPDATED: Use the new font */
            font-family: 'Poppins', sans-serif;
        }

        .social-btn i {
            margin-right: 10px;
            font-size: 1.3em;
        }

        .social-btn.google-btn {
            color: #555;
            border-color: #dbe2e8;
        }

        .social-btn.google-btn:hover {
            background: #f6f9fc;
            border-color: #c0d0da;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .social-btn.facebook-btn {
            background: #1877F2;
            color: white;
            border-color: #1877F2;
        }

        .social-btn.facebook-btn:hover {
            background: #166eeb;
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.3);
            transform: translateY(-2px);
        }

        /* --- 3. PAGE-SPECIFIC RESPONSIVE STYLES --- */
        @media screen and (max-width: 600px) {

            /* UPDATED: Ensure body flexes correctly on mobile */
            body {
                display: block;
            }

            .page-container {
                width: 95%;
                padding: 25px 20px;
                margin: 30px auto;
                /* NEW: Remove animation on mobile if it feels janky */
                animation: none;
            }

            /* --- NEW: Responsive Logo --- */
            .login-logo {
                margin-bottom: 0px;
            }

            .login-logo-placeholder {
                font-size: 1.2em;
                padding: 12px 20px;
            }

            .login-tabs .tab-link {
                font-size: 1.1em;
                padding: 12px 5px;
            }

            .login-form h2 {
                font-size: 1.8em;
            }

            .login-form p {
                font-size: 1em;
                margin-bottom: 30px;
            }

            .login-form input[type="text"],
            .login-form input[type="email"],
            .login-form input[type="password"] {
                padding: 12px 15px 12px 45px;
            }

            .input-icon {
                left: 15px;
                font-size: 1em;
            }

            .login-submit-btn,
            .signup-submit-btn,
            .social-btn {
                padding: 12px;
                font-size: 1em;
            }
        }
    </style>
</head>

<body>

    <?php

    include 'header.php';
    ?>

    <main class="page-container">

        <div class="login-container">

            <div class="login-tabs">
                <button class="tab-link active" data-tab="login-form"><i class="fa-solid fa-right-to-bracket"></i> Login</button>
                <button class="tab-link" data-tab="signup-form"><i class="fa-solid fa-user-plus"></i> Sign Up</button>
            </div>

            <div id="login-form" class="login-form-content active">
                <form class="login-form" method="POST" action="login_process.php">

                    <div class="login-logo">
                        <img src="images/Logo4.png" alt="Medicare Plus Logo" height="100" width="105">
                        <h2 style="margin-top: -10px;">WELCOME !</h2>
                        <p style="margin-top: -20px;">Login to access your account.</p>
                    </div>
                    <div class="input-group">
                        <label for="login-email">Email</label>
                        <div class="input-wrapper">
                            <input type="email" id="login-email" name="email" required>
                            <i class="input-icon fa-solid fa-envelope"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="login-password">Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="login-password" name="password" required>
                            <i class="input-icon fa-solid fa-lock"></i>
                        </div>
                    </div>
                    <a href="#" class="forgot-password">Forgot Password?</a>

                    <button type="submit" class="login-submit-btn"><i class="fa-solid fa-right-to-bracket"></i> Login</button>

                    <div class="social-divider"><span>OR</span></div>

                    <div class="social-login-buttons">
                        <button type="button" class="social-btn google-btn"><i class="fa-brands fa-google"></i> Continue with Google</button>
                        <button type="button" class="social-btn facebook-btn"><i class="fa-brands fa-facebook-f"></i> Continue with Facebook</button>
                    </div>
                </form>
            </div>

            <div id="signup-form" class="login-form-content">
                <form class="login-form" method="POST" action="signup_process.php">
                    <h2>Create Account</h2>
                    <p>Get started with a free account.</p>

                    <div class="input-group">
                        <label for="signup-name">Full Name</label>
                        <div class="input-wrapper">
                            <input type="text" id="signup-name" name="full_name" required>
                            <i class="input-icon fa-solid fa-user"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="signup-email">Email</label>
                        <div class="input-wrapper">
                            <input type="email" id="signup-email" name="email" required>
                            <i class="input-icon fa-solid fa-envelope"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="signup-password">Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="signup-password" name="password" required>
                            <i class="input-icon fa-solid fa-lock"></i>
                        </div>
                    </div>

                    <button type="submit" class="signup-submit-btn"><i class="fa-solid fa-user-plus"></i> Create Account</button>
                </form>
            </div>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-link');
            const contents = document.querySelectorAll('.login-form-content');
            const loginTabsContainer = document.querySelector('.login-tabs');

            function updateTabUnderline(activeTab) {
                if (!activeTab || !loginTabsContainer) return;
                loginTabsContainer.style.setProperty('--_underline-width', `${activeTab.offsetWidth}px`);
                loginTabsContainer.style.setProperty('--_underline-left', `${activeTab.offsetLeft}px`);
            }

            function switchTab(targetId) {
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));

                const activeTab = document.querySelector(`.tab-link[data-tab="${targetId}"]`);
                const targetContent = document.getElementById(targetId);

                if (activeTab) {
                    activeTab.classList.add('active');
                    updateTabUnderline(activeTab);
                }
                if (targetContent) {
                    targetContent.classList.add('active');
                }
            }

            if (tabs.length > 0 && contents.length > 0) {
                tabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        const targetId = tab.getAttribute('data-tab');
                        switchTab(targetId);
                    });
                });

                const initialActiveTab = document.querySelector('.tab-link.active');
                if (initialActiveTab) {
                    // Use a small timeout to ensure layout is calculated after load
                    setTimeout(() => updateTabUnderline(initialActiveTab), 50);

                    // --- NEW: ResizeObserver to fix underline on window resize ---
                    new ResizeObserver(() => {
                        const activeTab = document.querySelector('.tab-link.active');
                        updateTabUnderline(activeTab);
                    }).observe(loginTabsContainer);
                }
            }
        });
    </script>
    <br><br>
    <?php
    // STEP 4: Include the footer at the end of the body
    // This pushes the footer to the bottom of the page
    include 'footer.php';
    ?>
</body>

</html>