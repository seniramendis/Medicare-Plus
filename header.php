<?php
// This variable will be an array to hold 'active' status
$active = [
    'home' => '',
    'services' => '',
    'find_doctor' => '',
    'blog' => '',
    'location' => '',
    'about' => '',
    'contact' => '',
    'login' => ''
];

// This logic sets the active page.
if (isset($pageKey) && array_key_exists($pageKey, $active)) {
    $active[$pageKey] = 'active';
}

// This is for the 'Services' link, which has many sub-pages.
if (isset($parentPageKey) && $parentPageKey == 'services') {
    $active['services'] = 'active';
}

// Standardize all page links
$links = [
    'home' => 'index.php',
    'services' => 'services.php',
    'find_doctor' => 'find_a_doctor.php',
    'blog' => 'blog.php',
    'location' => 'location.php',
    'about' => 'index.php#AboutUs',
    'contact' => 'contact.php',
    'login' => 'login.php' // Assuming you have/will create a login.php
];
?>
<style>
    /* --- HEADER & NAVIGATION STYLES --- */
    header {
        background: linear-gradient(90deg, #1e3a8a, #2563eb, #1e3a8a);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);

        /* NEW LAYOUT: Use Grid for 3 columns */
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        /* Left (flexible) | Center (auto-width) | Right (flexible) */

        align-items: center;
        padding: 15px 40px;
        color: white;
    }

    /* 1st Column: Logo */
    header>a {
        justify-self: start;
        /* Aligns logo to the far left */
    }

    .logo {
        width: 120px;
        height: 95px;
    }

    /* 2nd Column: Brand Text */
    .brand-container {
        text-align: center;
        /* This centers the H1 and P */
    }

    .brandName {
        margin: 0;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }

    header p {
        margin: 0;
        font-size: 16px;
        text-align: center;
        opacity: 0.9;
    }

    /* 3rd Column: Search Bar */
    .search-bar {
        justify-self: end;
        /* Aligns search bar to the far right */
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


    /* --- NAVIGATION BAR --- */
    /* **FIX:** Renamed .pagination to .main-nav for semantic clarity */
    .main-nav {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
        background-color: #f8f9fa;
        padding: 10px 40px;
        border-bottom: 1px solid #e0e0e0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);

    }

    /* **FIX:** Renamed .pagination-center to .main-nav-center */
    .main-nav-center {
        flex-grow: 1;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .main-nav a {
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

    .main-nav a.active {
        background-color: #57c95a;
        color: white;
        font-weight: bold;
    }

    .main-nav a:hover:not(.active):not(.login-button) {
        background-color: #e9e9e9;
    }

    .main-nav a.login-button {
        margin-left: auto;
        background-color: #1e3a8a;
        color: white;
        font-weight: bold;
    }

    .main-nav a.login-button:hover {
        background-color: #2563eb;
    }

    /* Active state for login button */
    .main-nav a.login-button.active {
        background-color: #57c95a;
    }

    .main-nav a.login-button.active:hover {
        background-color: #45a049;
    }


    /* --- RESPONSIVE STYLES (Header & Nav) --- */
    @media screen and (max-width: 768px) {
        header {
            display: grid;
            grid-template-columns: 1fr;
            /* Switch to a single column */
            justify-items: center;
            /* Center all items */
            padding: 15px;
            gap: 15px;
        }

        /* 1st Column: Logo (now first row) */
        header>a {
            justify-self: center;
            /* Center the logo */
            order: 2;
            /* Set order: Brand, Logo, Search */
        }

        .logo {
            margin-left: 0;
        }

        /* 2nd Column: Brand (now second row) */
        .brand-container {
            order: 1;
            /* Brand text comes first */
            text-align: center;
        }

        header p {
            text-align: center;
        }

        /* 3rd Column: Search (now third row) */
        .search-bar {
            justify-self: stretch;
            /* Make search bar full width */
            width: 100%;
            order: 3;
        }

        .search-control {
            width: 100%;
        }

        /* Navigation on Mobile */
        .main-nav {
            flex-direction: column;
            padding: 5px;
        }

        .main-nav-center {
            flex-direction: column;
            width: 100%;
        }

        .main-nav a {
            margin: 5px 0;
            text-align: center;
            justify-content: center;
            width: 100%;
        }

        .main-nav a.login-button {
            margin-left: 0;
            width: 100%;
        }
    }
</style>

<header>
    <a href="<?php echo $links['home']; ?>"><img class="logo" src="images/Logo4.png" alt="Logo" height="95" width="120"></a>

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

<nav class="main-nav">
    <div class="main-nav-center">
        <a href="<?php echo $links['home']; ?>" class="<?php echo $active['home']; ?>"><i class="fa-solid fa-house"></i> HOME</a>
        <a href="<?php echo $links['services']; ?>" class="<?php echo $active['services']; ?>"><i class="fa-solid fa-heart"></i> SERVICES</a>
        <a href="<?php echo $links['find_doctor']; ?>" class="<?php echo $active['find_doctor']; ?>"><i class="fa-solid fa-user-doctor"></i> FIND A DOCTOR</a>
        <a href="<?php echo $links['blog']; ?>" class="<?php echo $active['blog']; ?>"><i class="fa-solid fa-blog"></i> HEALTH BLOG & TIPS</a>
        <a href="<?php echo $links['location']; ?>" class="<?php echo $active['location']; ?>"><i class="fa-solid fa-location-dot"></i> LOCATION</a>
        <a href="<?php echo $links['about']; ?>" class="<?php echo $active['about']; ?>"><i class="fa-solid fa-address-card"></i> ABOUT US</a>
        <a href="<?php echo $links['contact']; ?>" class="<?php echo $active['contact']; ?>"><i class="fa-solid fa-phone"></i> CONTACT</a>
    </div>

    <a href="<?php echo $links['login']; ?>" class="login-button <?php echo $active['login']; ?>"><i class="fa-solid fa-user"></i> LOGIN / SIGNUP</a>
</nav>