<?php
// header.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 0. CONNECT TO DB (If not already connected)
if (!isset($conn)) {
    include 'db_connect.php';
}

// --- GLOBAL SECURITY CHECK ---
// This ensures that if a user is deleted from the DB, they are logged out from ANY page they visit.
if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
    $sec_id = $_SESSION['user_id'] ?? $_SESSION['admin_id'];
    $sec_role = $_SESSION['role'] ?? 'guest';

    // Fast query to check existence
    $sec_check = $conn->query("SELECT id FROM users WHERE id = '$sec_id'");

    if ($sec_check->num_rows == 0) {
        // User does not exist in DB anymore (Deleted)
        session_unset();
        session_destroy();

        // Force redirect using JavaScript (Safe to use inside included files)
        echo "<script>
            alert('Your account no longer exists or your session expired.');
            window.location.href = 'login.php';
        </script>";
        exit();
    }
}
// -----------------------------

// 1. GET USER INFO - UPDATED FOR SESSION ISOLATION
$isAdminLoggedIn = (isset($_SESSION['admin_id']) && ($_SESSION['role'] === 'admin'));
$isGenericUserLoggedIn = (isset($_SESSION['user_id']) && ($_SESSION['role'] === 'patient' || $_SESSION['role'] === 'doctor'));

// $isLoggedIn is true if *any* recognized user type is logged in (used for portal links, dropdown visibility, etc.)
$isLoggedIn = $isGenericUserLoggedIn || $isAdminLoggedIn;

$role = $_SESSION['role'] ?? '';
$isDoctor = ($role === 'doctor');

$displayName = 'Guest';
$session_username = $_SESSION['username'] ?? ''; // Uses the username set by the login script (admin or generic)

// Set displayName for the public header: Only show the name if it's a generic user (Patient/Doctor)
if ($isGenericUserLoggedIn) {
    $parts = explode(' ', $session_username);
    $displayName = $parts[0];
}

// 2. PORTAL LOGIC
$portal_url = '#';
if ($role === 'doctor' && isset($_SESSION['user_id'])) {
    $portal_url = 'dashboard_doctor.php';
} elseif ($role === 'patient' && isset($_SESSION['user_id'])) {
    $portal_url = 'dashboard_patient.php';
} elseif ($role === 'admin' && isset($_SESSION['admin_id'])) {
    $portal_url = 'dashboard_admin.php'; // Admin uses their isolated key check
}

// 3. ACTIVE TAB LOGIC
$current_page = basename($_SERVER['PHP_SELF']);
$active = [
    'Home.php' => '',
    'services.php' => '',
    'dashboard_patient.php' => '',
    'dashboard_doctor.php' => '',
    'dashboard_admin.php' => '',
    'find_a_doctor.php' => '',
    'blog.php' => '',
    'location.php' => '',
    'contact.php' => '',
    'login.php' => '',
    'messages.php' => '',
    'edit_profile.php' => ''
];

// Check if any dashboard is active to highlight the 'Portal' link
$portal_pages = ['dashboard_patient.php', 'dashboard_doctor.php', 'dashboard_admin.php'];
$portal_is_active = (in_array($current_page, $portal_pages)) ? 'active-link' : '';

if (array_key_exists($current_page, $active)) $active[$current_page] = 'active-link';


$notif_count = 3;
?>

<script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    /* --- 1. GLOBAL FIXES --- */
    :root {
        --primary-blue: #1e3a8a;
        --primary-light: #2563eb;
        --accent-green: #57c95a;
        --text-white: #ffffff;
        --glass-bg: rgba(255, 255, 255, 0.15);
        --glass-border: rgba(255, 255, 255, 0.2);
        --header-height: 70px;
    }

    body {
        margin-top: var(--header-height) !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* --- 2. HEADER CONTAINER --- */
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
        max-width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* --- 3. LOGO --- */
    .logo-section {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        padding: 0;
        flex-shrink: 0;
    }

    .logo-img {
        height: 40px;
        width: auto;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
    }

    .logo-text {
        font-family: 'Segoe UI', sans-serif;
        font-size: 20px;
        font-weight: 800;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .logo-text span {
        color: var(--accent-green);
    }

    /* --- 4. NAVIGATION --- */
    .nav-menu {
        display: flex;
        align-items: center;
        gap: 2px;
        margin: 0 15px;
        flex-wrap: nowrap;
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
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    /* --- 5. SEARCH BAR --- */
    .search-container {
        margin-right: 10px;
    }

    .search-box {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-box input {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 6px 15px 6px 30px;
        color: white;
        outline: none;
        width: 140px;
        font-size: 13px;
        transition: width 0.3s ease, background 0.3s;
    }

    .search-box input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .search-box input:focus {
        background: rgba(255, 255, 255, 0.25);
        width: 180px;
    }

    .search-box i {
        position: absolute;
        left: 10px;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.8);
        pointer-events: none;
    }

    /* --- 6. RIGHT ACTIONS --- */
    .right-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
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
        transition: 0.2s;
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
        border: 1px solid var(--primary-blue);
        animation: popIn 0.3s ease;
    }

    @keyframes popIn {
        from {
            transform: scale(0);
        }

        to {
            transform: scale(1);
        }
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
        border: 1px solid transparent;
        transition: 0.3s;
    }

    .user-profile:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    .avatar-circle {
        width: 28px;
        height: 28px;
        background: #fff;
        color: var(--primary-blue);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
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
        white-space: nowrap;
    }

    .btn-login {
        background: white;
        color: var(--primary-blue);
        padding: 6px 16px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        white-space: nowrap;
        transition: 0.3s;
    }

    .btn-login:hover {
        background: var(--accent-green);
        color: white;
    }

    .dropdown-menu,
    .notif-dropdown {
        position: absolute;
        top: 120%;
        right: 0;
        background: white;
        width: 220px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        display: none;
        flex-direction: column;
        overflow: hidden;
        z-index: 10000;
        animation: slideDown 0.2s ease;
    }

    .dropdown-menu.show,
    .notif-dropdown.show {
        display: flex;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-item {
        padding: 12px 20px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: 0.2s;
    }

    .dropdown-item:hover {
        background: #f4f7f6;
        color: var(--primary-blue);
    }

    .dropdown-item.logout {
        color: #ff4757;
        border-top: 1px solid #eee;
    }

    .dropdown-item.logout:hover {
        background: #fff0f1;
    }

    .notif-dropdown {
        width: 300px;
    }

    .notif-header {
        padding: 15px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        color: #333;
    }

    .notif-item {
        display: flex;
        padding: 15px;
        gap: 15px;
        text-decoration: none;
        border-bottom: 1px solid #f9f9f9;
        transition: 0.2s;
    }

    .notif-item:hover {
        background: #f9fbff;
    }

    .notif-icon {
        width: 35px;
        height: 35px;
        background: #e8f5e9;
        color: var(--accent-green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .notif-details {
        display: flex;
        flex-direction: column;
    }

    .notif-text {
        font-size: 13px;
        color: #444;
        line-height: 1.4;
    }

    .notif-time {
        font-size: 11px;
        color: #999;
        margin-top: 4px;
    }

    @media screen and (max-width: 1200px) {
        .nav-item {
            padding: 8px 6px;
        }
    }
</style>

<header class="site-header">
    <div class="header-wrapper">

        <a href="Home.php" class="logo-section">
            <img src="images/Logo4.png" alt="Logo" class="logo-img">
            <div class="logo-text">MEDICARE<span>PLUS</span></div>
        </a>

        <nav class="nav-menu">
            <a href="Home.php" class="nav-item <?php echo $active['Home.php']; ?>"><i class="fa-solid fa-house"></i> <span>Home</span></a>
            <?php if (!$isDoctor): ?>
                <a href="services.php" class="nav-item <?php echo $active['services.php']; ?>"><i class="fa-solid fa-heart-pulse"></i> <span>Services</span></a>
            <?php endif; ?>

            <?php if ($isLoggedIn): ?>
                <a href="<?php echo $portal_url; ?>" class="nav-item portal-btn <?php echo $portal_is_active; ?>"><i class="fa-solid fa-laptop-medical"></i> <span>Portal</span></a>
            <?php endif; ?>

            <?php if (!$isDoctor): ?>
                <a href="find_a_doctor.php" class="nav-item <?php echo $active['find_a_doctor.php']; ?>"><i class="fa-solid fa-user-doctor"></i> <span>Doctors</span></a>
            <?php endif; ?>
            <a href="blog.php" class="nav-item <?php echo $active['blog.php']; ?>"><i class="fa-solid fa-book-medical"></i> <span>Blog</span></a>
            <?php if (!$isDoctor): ?>
                <a href="location.php" class="nav-item <?php echo $active['location.php']; ?>"><i class="fa-solid fa-location-dot"></i> <span>Location</span></a>
                <a href="Home.php#AboutUs" class="nav-item"><i class="fa-solid fa-address-card"></i> <span>About</span></a>
            <?php endif; ?>
            <a href="contact.php" class="nav-item <?php echo $active['contact.php']; ?>"><i class="fa-solid fa-envelope"></i> <span>Contact</span></a>
        </nav>

        <div class="right-actions">
            <div class="search-container">
                <form action="#" method="GET" class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search...">
                </form>
            </div>

            <?php if ($isGenericUserLoggedIn): ?>
                <a href="messages.php" class="icon-btn" title="Messages">
                    <i class="fa-regular fa-envelope"></i>
                    <span class="badge" id="msg-header-count" style="display:none;"></span>
                </a>

                <div style="position:relative;">
                    <div class="icon-btn" onclick="toggleNotif(event)">
                        <i class="fa-regular fa-bell"></i>
                        <?php if ($notif_count > 0): ?><span class="badge"><?php echo $notif_count; ?></span><?php endif; ?>
                    </div>
                    <div class="notif-dropdown" id="notifDropdown">
                        <div class="notif-header">
                            <span>Notifications</span>
                            <span style="font-size:11px; color:#2563eb; cursor:pointer;">Mark all read</span>
                        </div>
                        <a href="#" class="notif-item">
                            <div class="notif-icon"><i class="fa-solid fa-check"></i></div>
                            <div class="notif-details">
                                <span class="notif-text">Your appointment has been confirmed.</span>
                                <span class="notif-time">2 mins ago</span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="user-profile-wrapper">
                    <div class="user-profile" onclick="toggleUserMenu(event)">
                        <div class="avatar-circle">
                            <?php
                            $h_pic = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png";
                            // Check DB for custom pic
                            $h_id = $_SESSION['user_id'];
                            $h_sql = $conn->query("SELECT profile_pic FROM users WHERE id='$h_id'");
                            if ($h_row = $h_sql->fetch_assoc()) {
                                if (!empty($h_row['profile_pic']) && file_exists("uploads/" . $h_row['profile_pic'])) {
                                    $h_pic = "uploads/" . $h_row['profile_pic'];
                                }
                            }
                            ?>
                            <img src="<?php echo $h_pic; ?>" alt="User">
                        </div>
                        <span class="user-name">Hi, <?php echo htmlspecialchars($displayName); ?></span>
                        <i class="fa-solid fa-chevron-down" style="font-size: 11px; opacity: 0.8; color: white;"></i>
                    </div>

                    <div class="dropdown-menu" id="userMenu">
                        <div style="padding: 15px; border-bottom: 1px solid #eee; font-size: 12px; color: #888;">
                            Signed in as <br> <strong style="color: #333; font-size: 14px;"><?php echo htmlspecialchars($session_username); ?></strong>
                        </div>
                        <a href="<?php echo $portal_url; ?>" class="dropdown-item"><i class="fa-solid fa-table-columns"></i> Dashboard</a>
                        <a href="edit_profile.php" class="dropdown-item"><i class="fa-solid fa-user-pen"></i> Edit Profile</a>

                        <a href="logout.php" class="dropdown-item logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="btn-login"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
            <?php endif; ?>
        </div>

    </div>
</header>

<script>
    $(document).ready(function() {
        updateHeaderBadge();
        setInterval(updateHeaderBadge, 3000);
    });

    function updateHeaderBadge() {
        <?php if ($isGenericUserLoggedIn): ?> // Only run AJAX for generic users
            $.ajax({
                url: 'message_api.php',
                type: 'POST',
                data: {
                    action: 'get_unread_count'
                },
                dataType: 'json',
                success: function(response) {
                    const count = response.count;
                    const badgeElement = $('#msg-header-count');
                    if (count > 0) {
                        badgeElement.text(count);
                        badgeElement.show();
                    } else {
                        badgeElement.hide();
                    }
                },
                error: function(xhr, status, error) {}
            });
        <?php endif; ?>
    }

    function toggleUserMenu(e) {
        e.stopPropagation();
        document.getElementById('userMenu').classList.toggle('show');
        document.getElementById('notifDropdown').classList.remove('show');
    }

    function toggleNotif(e) {
        e.stopPropagation();
        document.getElementById('notifDropdown').classList.toggle('show');
        document.getElementById('userMenu').classList.remove('show');
    }

    window.addEventListener('click', function(e) {
        if (!e.target.closest('.user-profile-wrapper') && !e.target.closest('.icon-btn')) {
            const userMenu = document.getElementById('userMenu');
            const notifDropdown = document.getElementById('notifDropdown');
            if (userMenu) userMenu.classList.remove('show');
            if (notifDropdown) notifDropdown.classList.remove('show');
        }
    });
</script>