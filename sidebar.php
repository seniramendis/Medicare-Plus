<style>
    /* Sidebar CSS - Centralized here */
    .sidebar {
        width: 260px;
        background-color: #1e293b;
        color: white;
        position: fixed;
        height: 100%;
        display: flex;
        flex-direction: column;
        z-index: 100;
        top: 0;
        /* Ensure it sticks to top */
        left: 0;
    }

    .brand {
        padding: 25px;
        font-size: 20px;
        font-weight: 700;
        border-bottom: 1px solid #334155;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: white;
    }

    .brand span {
        color: #ef4444;
    }

    /* Red accent */

    .menu {
        padding: 20px 0;
        flex: 1;
    }

    .menu a {
        display: flex;
        align-items: center;
        padding: 14px 25px;
        color: #94a3b8;
        text-decoration: none;
        transition: 0.3s;
        font-weight: 500;
        font-size: 14px;
        border-left: 4px solid transparent;
        font-family: 'Inter', sans-serif;
    }

    .menu a:hover,
    .menu a.active {
        background: #334155;
        color: white;
        border-left: 4px solid #ef4444;
        /* The Active Red Border */
    }

    .menu a i {
        margin-right: 12px;
        width: 20px;
        text-align: center;
        font-size: 16px;
    }

    .logout-link {
        margin-top: auto;
        border-top: 1px solid #334155;
    }

    .logout-link a {
        color: #ef4444;
    }

    .logout-link a:hover {
        background: rgba(239, 68, 68, 0.1);
        border-left: 4px solid #ef4444;
        color: #ef4444;
    }
</style>

<div class="sidebar">
    <div class="brand">MEDICARE<span>PLUS</span></div>
    <div class="menu">
        <a href="dashboard_admin.php" class="<?php echo ($current_page == 'dashboard_admin.php') ? 'active' : ''; ?>">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>

        <a href="manage_doctors.php" class="<?php echo ($current_page == 'manage_doctors.php') ? 'active' : ''; ?>">
            <i class="fas fa-user-md"></i> Doctors
        </a>

        <a href="manage_patients.php" class="<?php echo ($current_page == 'manage_patients.php') ? 'active' : ''; ?>">
            <i class="fas fa-users"></i> Patients
        </a>

        <a href="appointments.php" class="<?php echo ($current_page == 'view_appointments.php') ? 'active' : ''; ?>">
            <i class="fas fa-calendar-alt"></i> Appointments
        </a>

        <a href="admin-inbox.php" class="<?php echo ($current_page == 'messages.php') ? 'active' : ''; ?>">
            <i class="fas fa-envelope"></i> Inbox
        </a>
        <a href="admin_financials.php" class="<?php echo ($current_page == 'payments.php') ? 'active' : ''; ?>">
            <i class="fas fa-file-invoice-dollar"></i> Payments
        </a>

        <div class="logout-link">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</div>