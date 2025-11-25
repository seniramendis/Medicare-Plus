<?php
session_start();
include 'db_connect.php';

// Security Check
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

// *** SET CURRENT PAGE FOR SIDEBAR HIGHLIGHTING ***
$current_page = 'dashboard_admin.php';

$admin_display_name = $_SESSION['username'];

// --- DATA FETCHING ---
// 1. Patients
$patient_query = "SELECT id FROM users WHERE role = 'patient'";
$total_patients = mysqli_num_rows(mysqli_query($conn, $patient_query));

// 2. Doctors
$doctor_query = "SELECT id FROM users WHERE role = 'doctor'";
$total_doctors = mysqli_num_rows(mysqli_query($conn, $doctor_query));

// 3. Admins
$admin_query = "SELECT id FROM users WHERE role = 'admin'";
$total_admins = mysqli_num_rows(mysqli_query($conn, $admin_query));

// 4. Pending Messages
$admin_id = $_SESSION['admin_id'];
$pending_query = "SELECT COUNT(*) as total FROM messages WHERE receiver_id = $admin_id AND is_read = 0";
$pending_result = mysqli_query($conn, $pending_query);
$total_pending = mysqli_fetch_assoc($pending_result)['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | MEDICARE PLUS</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
    <style>
        /* CSS Variables */
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --bg: #f1f5f9;
            --surface: #ffffff;
            --text: #334155;
            --text-light: #64748b;
            --border: #e2e8f0;
            --danger: #ef4444;
            --success: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg);
            display: flex;
            min-height: 100vh;
            color: var(--text);
        }

        /* Sidebar styles removed from here - they are now in sidebar.php */

        /* Main Content */
        .main-content {
            margin-left: 260px;
            /* Keeps space for the fixed sidebar */
            padding: 40px;
            width: calc(100% - 260px);
        }

        /* Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .welcome-text h1 {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .welcome-text p {
            color: var(--text-light);
            font-size: 14px;
            margin-top: 5px;
        }

        .admin-badge {
            background: white;
            padding: 8px 16px;
            border-radius: 50px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--border);
        }

        .admin-avatar {
            width: 32px;
            height: 32px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--surface);
            padding: 25px;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .stat-info h3 {
            font-size: 36px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1;
            margin-bottom: 5px;
        }

        .stat-info p {
            color: var(--text-light);
            font-size: 14px;
            font-weight: 500;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .icon-blue {
            background: #eff6ff;
            color: var(--primary);
        }

        .icon-green {
            background: #ecfdf5;
            color: var(--success);
        }

        .icon-purple {
            background: #f3e8ff;
            color: #7e22ce;
        }

        .icon-orange {
            background: #fff7ed;
            color: #f97316;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        .card {
            background: var(--surface);
            padding: 25px;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .status-title {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 5px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-outline {
            background: white;
            border: 1px solid var(--border);
            color: var(--text);
        }

        .btn-outline:hover {
            background: #f8fafc;
        }

        .server-list li {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }

        .server-list li:last-child {
            border-bottom: none;
        }

        .server-label {
            color: var(--text-light);
        }

        .server-val {
            font-weight: 600;
            color: #0f172a;
        }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">

        <div class="page-header">
            <div class="welcome-text">
                <h1>Overview</h1>
                <p>Welcome back, <?php echo htmlspecialchars($admin_display_name); ?>. Here's what's happening today.</p>
            </div>
            <div class="admin-badge">
                <div class="admin-avatar"><i class="fas fa-user"></i></div>
                <span style="font-size:13px; font-weight:600;">Super Admin</span>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3><?php echo $total_patients; ?></h3>
                    <p>Total Patients</p>
                </div>
                <div class="icon-box icon-blue"><i class="fas fa-users"></i></div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3><?php echo $total_doctors; ?></h3>
                    <p>Active Doctors</p>
                </div>
                <div class="icon-box icon-green"><i class="fas fa-user-md"></i></div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3><?php echo $total_admins; ?></h3>
                    <p>System Admins</p>
                </div>
                <div class="icon-box icon-orange"><i class="fas fa-user-shield"></i></div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3><?php echo $total_pending; ?></h3>
                    <p>Unread Messages</p>
                </div>
                <div class="icon-box icon-purple"><i class="fas fa-envelope"></i></div>
            </div>
        </div>

        <div class="dashboard-grid">

            <div class="card">
                <div class="card-title">
                    <span>System Status</span>
                    <button class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;"><i class="fas fa-sync-alt"></i> Refresh</button>
                </div>

                <div class="status-box">
                    <div class="status-title"><i class="fas fa-check-circle"></i> Operational</div>
                    <p style="font-size: 13px; opacity: 0.9;">Database connection is stable. All services are running smoothly.</p>
                </div>

                <p style="font-size: 14px; font-weight: 600; margin-bottom: 15px;">Quick Actions</p>
                <div class="action-buttons">
                    <a href="add_doctor.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Doctor</a>
                    <a href="add_patient.php" class="btn btn-outline"><i class="fas fa-user-plus"></i> Register Patient</a>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Server Information</div>
                <ul class="server-list">
                    <li><span class="server-label">Server IP</span> <span class="server-val"><?php echo $_SERVER['SERVER_ADDR'] ?? '127.0.0.1'; ?></span></li>
                    <li><span class="server-label">PHP Version</span> <span class="server-val"><?php echo phpversion(); ?></span></li>
                    <li><span class="server-label">Database</span> <span class="server-val" style="color: var(--success);">Connected</span></li>
                    <li><span class="server-label">Time</span> <span class="server-val"><?php echo date('H:i'); ?></span></li>
                </ul>
            </div>

        </div>

    </div>

</body>

</html>