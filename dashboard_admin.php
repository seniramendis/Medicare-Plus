<?php
session_start();
include 'db_connect.php';

// Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

// --- FETCH REAL DATA FOR THE DASHBOARD ---
// (We use simple queries to count rows for the stats cards)

// 1. Count Patients
$patient_query = "SELECT * FROM users WHERE role = 'patient'";
$patient_result = mysqli_query($conn, $patient_query);
$total_patients = mysqli_num_rows($patient_result);

// 2. Count Doctors
$doctor_query = "SELECT * FROM users WHERE role = 'doctor'";
$doctor_result = mysqli_query($conn, $doctor_query);
$total_doctors = mysqli_num_rows($doctor_result);

// 3. Count Admins (Optional)
$admin_query = "SELECT * FROM users WHERE role = 'admin'";
$admin_result = mysqli_query($conn, $admin_query);
$total_admins = mysqli_num_rows($admin_result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | MEDICARE PLUS</title>

    <link rel="icon" href="images/Favicon.png" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>

    <style>
        :root {
            --primary: #1e1e2d;
            /* Dark Sidebar */
            --secondary: #2b2b40;
            /* Lighter Dark for Hover */
            --accent: #ff4d4d;
            /* Red Brand Color */
            --bg-light: #f5f6fa;
            /* Light Grey Background */
            --text-dark: #333;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            list-style: none;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background-color: var(--primary);
            color: #fff;
            position: fixed;
            height: 100%;
            transition: 0.3s;
            z-index: 100;
        }

        .brand {
            padding: 30px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand h2 {
            font-size: 18px;
            letter-spacing: 1px;
            color: #fff;
        }

        .brand span {
            color: var(--accent);
            font-weight: 700;
        }

        .menu {
            padding: 20px 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #aab0c6;
            transition: 0.3s;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .menu-item:hover,
        .menu-item.active {
            background-color: var(--secondary);
            color: #fff;
            border-left: 4px solid var(--accent);
        }

        .menu-item i {
            width: 30px;
            font-size: 1.1rem;
        }

        .logout-btn {
            position: absolute;
            bottom: 20px;
            width: 100%;
            padding: 0 20px;
        }

        .logout-btn a {
            display: block;
            background: rgba(255, 77, 77, 0.15);
            color: var(--accent);
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
        }

        .logout-btn a:hover {
            background: var(--accent);
            color: white;
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 30px;
        }

        /* Header */
        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .header-title h1 {
            font-size: 24px;
            color: var(--text-dark);
            font-weight: 600;
        }

        .header-title p {
            color: #888;
            font-size: 14px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
            background: white;
            padding: 8px 15px;
            border-radius: 30px;
            box-shadow: var(--shadow);
        }

        .user-img {
            width: 40px;
            height: 40px;
            background: var(--secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-info h3 {
            font-size: 32px;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .stat-info p {
            color: #888;
            font-size: 14px;
            font-weight: 500;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        /* Card Colors */
        .blue-card .stat-icon {
            background: #e3f2fd;
            color: #2196f3;
        }

        .green-card .stat-icon {
            background: #e8f5e9;
            color: #4caf50;
        }

        .orange-card .stat-icon {
            background: #fff3e0;
            color: #ff9800;
        }

        .purple-card .stat-icon {
            background: #f3e5f5;
            color: #9c27b0;
        }

        /* Action Section */
        .action-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        .card-container {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .card-header h3 {
            font-size: 18px;
            color: var(--text-dark);
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #2196f3;
            color: white;
        }

        .btn-primary:hover {
            background: #1976d2;
        }

        .btn-outline {
            border: 1px solid #ddd;
            background: transparent;
            color: #555;
        }

        .btn-outline:hover {
            border-color: #999;
            color: #333;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="brand">
            <i class="fas fa-heartbeat fa-lg" style="color: var(--accent);"></i>
            <h2>MEDICARE<span>PLUS</span></h2>
        </div>

        <div class="menu">
            <div class="menu-item active">
                <i class="fas fa-th-large"></i> <span>Dashboard</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-user-md"></i> <span>Doctors</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-wheelchair"></i> <span>Patients</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-calendar-check"></i> <span>Appointments</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-cog"></i> <span>Settings</span>
            </div>
        </div>

        <div class="logout-btn">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div class="main-content">

        <div class="header-bar">
            <div class="header-title">
                <h1>Overview</h1>
                <p>Welcome back, Admin. Here's what's happening today.</p>
            </div>
            <div class="user-profile">
                <div class="user-details" style="text-align: right;">
                    <h4 style="font-size: 14px; margin: 0;"><?php echo $_SESSION['username']; ?></h4>
                    <span style="font-size: 12px; color: #888;">Super Admin</span>
                </div>
                <div class="user-img">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>

        <div class="stats-grid">

            <div class="stat-card blue-card">
                <div class="stat-info">
                    <h3><?php echo $total_patients; ?></h3>
                    <p>Total Patients</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>

            <div class="stat-card green-card">
                <div class="stat-info">
                    <h3><?php echo $total_doctors; ?></h3>
                    <p>Active Doctors</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>

            <div class="stat-card orange-card">
                <div class="stat-info">
                    <h3><?php echo $total_admins; ?></h3>
                    <p>System Admins</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>

            <div class="stat-card purple-card">
                <div class="stat-info">
                    <h3>5</h3>
                    <p>Pending Requests</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>

        </div>

        <div class="action-section">

            <div class="card-container">
                <div class="card-header">
                    <h3>System Status</h3>
                    <button class="btn btn-outline"><i class="fas fa-sync-alt"></i> Refresh</button>
                </div>
                <div style="padding: 20px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #4caf50;">
                    <h4 style="color: #2e7d32; margin-bottom: 5px;"><i class="fas fa-check-circle"></i> Operational</h4>
                    <p style="color: #666; font-size: 14px;">Database connection is stable. All services are running.</p>
                </div>
                <br>
                <p><strong>Quick Actions:</strong></p>
                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button class="btn btn-primary"><i class="fas fa-plus"></i> Add New Doctor</button>
                    <button class="btn btn-primary" style="background-color: #6c757d;"><i class="fas fa-file-export"></i> Export Reports</button>
                </div>
            </div>

            <div class="card-container">
                <div class="card-header">
                    <h3>Server Info</h3>
                </div>
                <ul style="font-size: 14px; color: #555;">
                    <li style="margin-bottom: 15px; display: flex; justify-content: space-between;">
                        <span>Server IP:</span> <strong>192.168.1.10</strong>
                    </li>
                    <li style="margin-bottom: 15px; display: flex; justify-content: space-between;">
                        <span>PHP Version:</span> <strong><?php echo phpversion(); ?></strong>
                    </li>
                    <li style="margin-bottom: 15px; display: flex; justify-content: space-between;">
                        <span>DB Status:</span> <strong style="color: green;">Connected</strong>
                    </li>
                </ul>
            </div>

        </div>

    </div>

</body>

</html>