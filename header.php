<?php
// header.php

// --- CRITICAL FIX: SESSION START CHECK ---
// This ensures the header can access the user's login data
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. CHECK LOGIN STATUS
$isLoggedIn = isset($_SESSION['user_id']);
$user_name_display = 'Account';

if ($isLoggedIn && isset($_SESSION['user_name'])) {
    // Get just the first name
    $parts = explode(' ', $_SESSION['user_name']);
    $user_name_display = $parts[0];
}

// 2. ACTIVE PAGE LOGIC
// This prevents "Undefined index" errors
$active = [
    'home' => '',
    'services' => '',
    'find_doctor' => '',
    'blog' => '',
    'location' => '',
    'about' => '',
    'contact' => '',
    'patient_portal' => '',
    'login' => ''
];

if (isset($pageKey) && array_key_exists($pageKey, $active)) {
    $active[$pageKey] = 'active';
}

// 3. DEFINE LINKS
$links = [
    'home' => 'Home.php',
    'services' => 'services.php',
    'find_doctor' => 'find_a_doctor.php',
    'blog' => 'blog.php',
    'location' => 'location.php',
    'about' => 'Home.php#AboutUs',
    'contact' => 'contact.php',
    'login' => 'login.php',
    'patient_portal' => 'Home.php',
    'view_profile' => 'profile.php',
    'edit_profile' => 'edit_profile.php',
    'logout' => 'logout.php'
];
?>

<style>
    /* HEADER STYLES */
    header {
        background: linear-gradient(90deg, #1e3a8a, #2563eb, #1e3a8a);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        padding: 15px 40px;
        color: white;
        z-index: 998;
        position: relative;
    }

    header>a {
        justify-self: start;
    }

    .logo {
        width: 120px;
        height: 95px;
        object-fit: contain;
    }

    .brand-container {
        text-align: center;
    }

    .brandName {
        margin: 0;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        font-size: 2em;
        font-weight: 700;
    }

    header p {
        margin: 0;
        font-size: 16px;
        text-align: center;
        opacity: 0.9;
        letter-spacing: 1px;
    }

    .search-bar {
        justify-self: end;
    }

    .search-bar-box {
        display: inline-flex;
        align-items: center;
        position: relative;
    }

    .search-bar-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #555;
    }

    .search-control {
        height: 42px;
        width: 250px;
        padding: 3px 20px 3px 45px;
        border-radius: 1.9rem;
        border: none;
        font-size: 15px;
    }

    .search-control:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.4);
    }

    .main-nav {
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
        padding: 10px 40px;
        border-bottom: 1px solid #e0e0e0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        z-index: 999;
        justify-content: space-between;
        transition: all 0.3s ease-in-out;
    }

    .main-nav.sticky {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        z-index: 1000;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    #main-nav-placeholder {
        display: block;
        height: 0;
    }

    .main-nav-center {
        flex-grow: 1;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .main-nav a.nav-link {
        color: #333;
        padding: 8px 14px;
        text-decoration: none;
        font-size: 15px;
        border-radius: 20px;
        transition: all 0.3s ease;
        font-weight: 500;
        margin: 0 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .main-nav a.nav-link.active {
        background-color: #57c95a;
        color: white;
        font-weight: bold;
    }

    .main-nav a.nav-link:hover:not(.active) {
        background-color: #e9e9e9;
    }

    .login-button {
        margin-left: auto;
        background-color: #1e3a8a !important;
        color: white !important;
        font-weight: bold;
        padding: 8px 20px !important;
    }

    .login-button:hover {
        background-color: #2563eb !important;
    }

    .portal-link {
        color: #1e3a8a !important;
        font-weight: 700 !important;
        border: 1px solid #e0e0e0;
    }

    .profile-container {
        position: relative;
        margin-left: auto;
    }

    .profile-btn {
        background: #fff;
        border: 1px solid #d1d5db;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 15px 5px 5px;
        border-radius: 30px;
        transition: 0.3s;
    }

    .profile-btn:hover {
        background-color: #f3f4f6;
        border-color: #1e3a8a;
    }

    .profile-icon-circle {
        width: 35px;
        height: 35px;
        background-color: #1e3a8a;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .profile-text {
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .profile-dropdown {
        display: none;
        position: absolute;
        right: 0;
        top: 55px;
        background-color: white;
        min-width: 200px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border-radius: 12px;
        z-index: 1001;
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }

    .profile-dropdown.show {
        display: block;
        animation: fadeDown 0.2s ease-in-out;
    }

    .profile-dropdown a {
        color: #333;
        padding: 12px 20px;
        text-decoration: none;
        display: block;
        font-size: 14px;
        transition: 0.2s;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .profile-dropdown a:hover {
        background-color: #f5f7fa;
        color: #1e3a8a;
    }

    .profile-dropdown a.sign-out {
        border-top: 1px solid #eee;
        color: #dc2626;
    }

    .profile-dropdown a.sign-out:hover {
        background-color: #fef2f2;
    }

    @keyframes fadeDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media screen and (max-width: 900px) {
        header {
            grid-template-columns: 1fr;
            gap: 15px;
            padding: 15px;
            text-align: center;
        }

        header>a {
            order: 2;
            justify-self: center;
        }

        .brand-container {
            order: 1;
        }

        .search-bar {
            order: 3;
            width: 100%;
            justify-self: center;
        }

        .search-control {
            width: 100%;
        }

        .main-nav {
            flex-direction: column;
            gap: 10px;
            padding: 15px;
            height: auto;
        }

        .main-nav-center {
            flex-direction: column;
            width: 100%;
        }

        .main-nav a.nav-link {
            width: 100%;
            justify-content: center;
            margin: 5px 0;
        }

        .login-button {
            margin-left: 0;
            width: 100%;
        }

        .profile-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .profile-dropdown {
            position: relative;
            top: 5px;
            width: 100%;
            text-align: center;
            box-shadow: none;
            border: 1px solid #eee;
        }

        .profile-dropdown a {
            justify-content: center;
        }
    }
</style>

<div id="header-container">
    <header>
        <a href="<?php echo $links['home']; ?>"><img class="logo" src="images/Logo4.png" alt="Logo"></a>
        <div class="brand-container">
            <h1 class="brandName"> MEDICARE PLUS</h1>
            <p>YOUR PARTNER FOR A LIFETIME OF HEALTH</p>
        </div>
        <div class="search-bar">
            <form>
                <div class="search-bar-box flex">
                    <i class="fa-solid fa-magnifying-glass fa-1x"></i>
                    <input type="search" class="search-control" placeholder="Search here">
                </div>
            </form>
        </div>
    </header>

    <div id="main-nav-placeholder"></div>

    <nav class="main-nav" id="main-nav">
        <div class="main-nav-center">
            <a href="<?php echo $links['home']; ?>" class="nav-link <?php echo $active['home']; ?>"><i class="fa-solid fa-house"></i> HOME</a>
            <a href="<?php echo $links['services']; ?>" class="nav-link <?php echo $active['services']; ?>"><i class="fa-solid fa-heart"></i> SERVICES</a>

            <?php if ($isLoggedIn): ?>
                <a href="<?php echo $links['patient_portal']; ?>" class="nav-link portal-link <?php echo $active['patient_portal']; ?>">
                    <i class="fa-solid fa-laptop-medical"></i> PATIENT PORTAL
                </a>
            <?php endif; ?>

            <a href="<?php echo $links['find_doctor']; ?>" class="nav-link <?php echo $active['find_doctor']; ?>"><i class="fa-solid fa-user-doctor"></i> FIND A DOCTOR</a>
            <a href="<?php echo $links['blog']; ?>" class="nav-link <?php echo $active['blog']; ?>"><i class="fa-solid fa-blog"></i> HEALTH BLOG</a>
            <a href="<?php echo $links['location']; ?>" class="nav-link <?php echo $active['location']; ?>"><i class="fa-solid fa-location-dot"></i> LOCATION</a>
            <a href="<?php echo $links['about']; ?>" class="nav-link <?php echo $active['about']; ?>"><i class="fa-solid fa-address-card"></i> ABOUT US</a>
            <a href="<?php echo $links['contact']; ?>" class="nav-link <?php echo $active['contact']; ?>"><i class="fa-solid fa-phone"></i> CONTACT</a>
        </div>

        <?php if ($isLoggedIn): ?>
            <div class="profile-container">
                <div class="profile-btn" onclick="toggleProfileMenu()">
                    <div class="profile-icon-circle">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span class="profile-text">Hi, <?php echo htmlspecialchars($user_name_display); ?> <i class="fa-solid fa-caret-down"></i></span>
                </div>
                <div id="profileDropdown" class="profile-dropdown">
                    <a href="<?php echo $links['view_profile']; ?>"><i class="fa-regular fa-id-card"></i> View Profile</a>
                    <a href="<?php echo $links['edit_profile']; ?>"><i class="fa-solid fa-user-pen"></i> Edit Profile</a>
                    <a href="<?php echo $links['logout']; ?>" class="sign-out"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
                </div>
            </div>
        <?php else: ?>
            <a href="<?php echo $links['login']; ?>" class="nav-link login-button <?php echo $active['login']; ?>">
                <i class="fa-solid fa-user"></i> LOGIN / SIGNUP
            </a>
        <?php endif; ?>
    </nav>
</div>

<script>
    function stickyNavOnScroll() {
        const nav = document.getElementById('main-nav');
        const placeholder = document.getElementById('main-nav-placeholder');
        const headerContainer = document.getElementById('header-container');
        const headerElement = headerContainer.querySelector('header');
        if (!headerElement) return;
        const stickyPoint = headerElement.offsetHeight;
        if (window.scrollY >= stickyPoint) {
            nav.classList.add('sticky');
            placeholder.style.height = nav.offsetHeight + 'px';
        } else {
            nav.classList.remove('sticky');
            placeholder.style.height = '0';
        }
    }

    function toggleProfileMenu() {
        const dropdown = document.getElementById("profileDropdown");
        if (dropdown) dropdown.classList.toggle("show");
    }
    window.onclick = function(event) {
        if (!event.target.closest('.profile-container')) {
            const dropdowns = document.getElementsByClassName("profile-dropdown");
            for (let i = 0; i < dropdowns.length; i++) {
                if (dropdowns[i].classList.contains('show')) {
                    dropdowns[i].classList.remove('show');
                }
            }
        }
    }
    window.addEventListener('scroll', stickyNavOnScroll);
    window.addEventListener('load', stickyNavOnScroll);
</script>