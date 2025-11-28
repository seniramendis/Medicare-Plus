<?php
// header.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 0. CONNECT TO DB
if (!isset($conn)) {
    include 'db_connect.php';
}

// --- SEPARATION LOGIC ---
// We ONLY check for Patients or Doctors (user_id).
$isUserLoggedIn = (isset($_SESSION['user_id']) && ($_SESSION['role'] === 'patient' || $_SESSION['role'] === 'doctor'));


// --- DATA PREP (Only for Patients/Doctors) ---
$displayName = 'Guest';
$notif_count = 0;

if ($isUserLoggedIn) {
    $session_username = $_SESSION['username'] ?? '';
    $parts = explode(' ', $session_username);
    $displayName = $parts[0];

    // Example notification logic
    // $notif_count = ... 
}

// Active Tab Logic
$current_page = basename($_SERVER['PHP_SELF']);
$active = [
    'Home.php' => '',
    'services.php' => '',
    'find_a_doctor.php' => '',
    'blog.php' => '',
    'location.php' => '',
    'contact.php' => ''
];
if (array_key_exists($current_page, $active)) $active[$current_page] = 'active-link';
?>

<script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    /* CSS Variables */
    :root {
        --primary-blue: #1e3a8a;
        --primary-light: #2563eb;
        --accent-green: #57c95a;
        --text-white: #ffffff;
        --glass-bg: rgba(255, 255, 255, 0.15);
        --header-height: 70px;
    }

    body {
        margin-top: var(--header-height) !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Header Container */
    .site-header {
        background: linear-gradient(90deg, #1e3a8a 0%, #2563eb 100%);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: var(--header-height);
        z-index: 9999;
        display: flex;
        align-items: center;
        padding: 0 15px;
        box-sizing: border-box;
    }

    .header-wrapper {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Hamburger Toggle (Mobile Only) */
    .mobile-toggle {
        display: none;
        /* Hidden by default */
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 5px;
        z-index: 10002;
    }

    /* Logo */
    .logo-section {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        flex-shrink: 0;
    }

    .logo-img {
        height: 40px;
        width: auto;
    }

    .logo-text {
        font-family: 'Segoe UI', sans-serif;
        font-size: 20px;
        font-weight: 800;
        color: #ffffff;
        text-transform: uppercase;
    }

    .logo-text span {
        color: var(--accent-green);
    }

    /* Nav Menu (Desktop) */
    .nav-menu {
        display: flex;
        align-items: center;
        gap: 2px;
        margin: 0 15px;
    }

    .nav-item {
        text-decoration: none;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
        font-size: 13px;
        padding: 8px 10px;
        border-radius: 20px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .nav-item:hover {
        background-color: var(--glass-bg);
        color: #fff;
    }

    .nav-item.active-link {
        background-color: var(--accent-green);
        color: #fff;
    }

    /* Right Actions */
    .right-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .btn-login {
        background: white;
        color: var(--primary-blue);
        padding: 6px 16px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        transition: 0.3s;
    }

    .btn-login:hover {
        background: var(--accent-green);
        color: white;
    }

    .icon-btn {
        position: relative;
        color: white;
        font-size: 16px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-decoration: none;
    }

    .icon-btn:hover {
        background: var(--glass-bg);
    }

    .badge {
        position: absolute;
        top: 2px;
        right: 2px;
        background: #ff4757;
        color: white;
        font-size: 9px;
        font-weight: bold;
        padding: 1px 4px;
        border-radius: 10px;
    }

    .user-profile-wrapper {
        position: relative;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--glass-bg);
        padding: 4px 12px 4px 4px;
        border-radius: 30px;
        cursor: pointer;
    }

    .avatar-circle {
        width: 28px;
        height: 28px;
        background: #fff;
        border-radius: 50%;
        overflow: hidden;
    }

    .avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-name {
        color: white;
        font-size: 13px;
        font-weight: 600;
    }

    .dropdown-menu {
        position: absolute;
        top: 130%;
        right: 0;
        background: white;
        width: 220px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        display: none;
        flex-direction: column;
        z-index: 10000;
        overflow: hidden;
    }

    .dropdown-menu.show {
        display: flex;
    }

    .dropdown-item {
        padding: 12px 20px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #f1f1f1;
    }

    .dropdown-item:last-child {
        border-bottom: none;
    }

    .dropdown-item:hover {
        background: #f4f7f6;
    }

    /* --- RESPONSIVE CSS --- */
    @media (max-width: 1080px) {

        .mobile-toggle {
            display: block;
            /* Show hamburger on mobile */
            margin-right: 10px;
        }

        /* Adjust Navigation to be a Slide-out Drawer */
        .nav-menu {
            position: fixed;
            top: var(--header-height);
            left: -100%;
            /* Hide off-screen */
            width: 100%;
            height: calc(100vh - var(--header-height));
            background: #1e3a8a;
            /* Solid blue */
            flex-direction: column;
            align-items: flex-start;
            margin: 0;
            padding: 20px 0;
            transition: left 0.3s ease-in-out;
            z-index: 9998;
            overflow-y: auto;
        }

        .nav-menu.active {
            left: 0;
            /* Slide in */
        }

        .nav-item {
            width: 100%;
            padding: 15px 30px;
            font-size: 16px;
            border-radius: 0;
            box-sizing: border-box;
        }

        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Hide Username on Mobile to save space */
        .user-name {
            display: none;
        }

        .user-profile {
            padding: 4px;
            background: transparent;
        }

        .header-wrapper {
            justify-content: flex-start;
            /* Align items to left */
        }

        .right-actions {
            margin-left: auto;
            /* Push actions to the far right */
        }
    }
</style>

<header class="site-header">
    <div class="header-wrapper">

        <div class="mobile-toggle" id="mobile-menu-btn">
            <i class="fa-solid fa-bars"></i>
        </div>

        <a href="Home.php" class="logo-section">
            <img src="images/Logo4.png" alt="Logo" class="logo-img">
            <div class="logo-text">MEDICARE<span>PLUS</span></div>
        </a>

        <nav class="nav-menu" id="nav-menu">
            <a href="Home.php" class="nav-item <?php echo $active['Home.php']; ?>"><i class="fa-solid fa-house"></i> <span>Home</span></a>
            <a href="services.php" class="nav-item <?php echo $active['services.php']; ?>"><i class="fa-solid fa-heart-pulse"></i> <span>Services</span></a>

            <?php if ($isUserLoggedIn): ?>
                <?php
                $dashboardLink = ($_SESSION['role'] === 'doctor') ? 'dashboard_doctor.php' : 'dashboard_patient.php';
                ?>
                <a href="<?php echo $dashboardLink; ?>" class="nav-item"><i class="fa-solid fa-laptop-medical"></i> <span>Portal</span></a>
            <?php endif; ?>

            <a href="find_a_doctor.php" class="nav-item <?php echo $active['find_a_doctor.php']; ?>"><i class="fa-solid fa-user-doctor"></i> <span>Doctors</span></a>
            <a href="blog.php" class="nav-item <?php echo $active['blog.php']; ?>"><i class="fa-solid fa-book-medical"></i> <span>Blog</span></a>
            <a href="location.php" class="nav-item <?php echo $active['location.php']; ?>"><i class="fa-solid fa-location-dot"></i> <span>Location</span></a>
            <a href="contact.php" class="nav-item <?php echo $active['contact.php']; ?>"><i class="fa-solid fa-envelope"></i> <span>Contact</span></a>
        </nav>

        <div class="right-actions">

            <?php if ($isUserLoggedIn): ?>

                <a href="messages.php" class="icon-btn" title="Messages">
                    <i class="fa-regular fa-envelope"></i>
                    <span class="badge" id="msg-header-count" style="display:none;"></span>
                </a>

                <div class="icon-btn">
                    <i class="fa-regular fa-bell"></i>
                    <?php if ($notif_count > 0): ?><span class="badge"><?php echo $notif_count; ?></span><?php endif; ?>
                </div>

                <div class="user-profile-wrapper">
                    <div class="user-profile" id="user-profile-btn">
                        <div class="avatar-circle">
                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="User">
                        </div>
                        <span class="user-name">Hi, <?php echo htmlspecialchars($displayName); ?></span>
                        <i class="fa-solid fa-chevron-down" style="font-size: 11px; color: white;"></i>
                    </div>

                    <div class="dropdown-menu" id="userMenu">
                        <a href="<?php echo $dashboardLink; ?>" class="dropdown-item"><i class="fa-solid fa-table-columns"></i> Dashboard</a>
                        <a href="edit_profile.php" class="dropdown-item"><i class="fa-solid fa-user-pen"></i> Edit Profile</a>
                        <a href="logout.php" class="dropdown-item" style="color:red;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                    </div>
                </div>

            <?php else: ?>
                <a href="login.php" class="btn-login"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
            <?php endif; ?>

        </div>
    </div>
</header>

<script>
    // Pure JavaScript for functionality (No jQuery required for the menu)
    document.addEventListener('DOMContentLoaded', function() {

        // --- 1. Mobile Menu Toggle ---
        const menuBtn = document.getElementById('mobile-menu-btn');
        const navMenu = document.getElementById('nav-menu');
        const menuIcon = menuBtn ? menuBtn.querySelector('i') : null;

        if (menuBtn && navMenu) {
            menuBtn.addEventListener('click', function(e) {
                e.stopPropagation(); // Stop click from closing immediately
                navMenu.classList.toggle('active');

                // Toggle Icon
                if (menuIcon) {
                    if (navMenu.classList.contains('active')) {
                        menuIcon.classList.remove('fa-bars');
                        menuIcon.classList.add('fa-xmark');
                    } else {
                        menuIcon.classList.remove('fa-xmark');
                        menuIcon.classList.add('fa-bars');
                    }
                }
            });

            // Close menu if clicking outside
            document.addEventListener('click', function(e) {
                if (!navMenu.contains(e.target) && !menuBtn.contains(e.target)) {
                    navMenu.classList.remove('active');
                    if (menuIcon) {
                        menuIcon.classList.remove('fa-xmark');
                        menuIcon.classList.add('fa-bars');
                    }
                }
            });
        }

        // --- 2. User Dropdown Toggle ---
        const userBtn = document.getElementById('user-profile-btn');
        const userMenu = document.getElementById('userMenu');

        if (userBtn && userMenu) {
            userBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userMenu.classList.toggle('show');
            });

            // Close dropdown if clicking outside
            document.addEventListener('click', function(e) {
                if (!userBtn.contains(e.target) && !userMenu.contains(e.target)) {
                    userMenu.classList.remove('show');
                }
            });
        }
    });
</script>