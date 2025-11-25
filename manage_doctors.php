<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

// *** 1. SET ACTIVE PAGE ***
$current_page = 'manage_doctors.php';

$doctors_query = "SELECT id, full_name, email, phone, specialty, rating, profile_image FROM users WHERE role = 'doctor' ORDER BY full_name ASC";
$doctors_result = mysqli_query($conn, $doctors_query);
$total_doctors_count = mysqli_num_rows($doctors_result);

$message = '';
if (isset($_GET['status'])) {
    $icon = '<i class="fas fa-check-circle"></i>';
    if ($_GET['status'] == 'added') $message = "<div class='alert success'>$icon New Doctor added successfully.</div>";
    elseif ($_GET['status'] == 'updated') $message = "<div class='alert success'>$icon Doctor details updated.</div>";
    elseif ($_GET['status'] == 'deleted') $message = "<div class='alert success'>$icon Doctor removed successfully.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Medical Staff | MEDICARE PLUS</title>
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

        /* Main Content (Margin matches sidebar width) */
        .main-content {
            margin-left: 260px;
            padding: 40px;
            width: calc(100% - 260px);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .page-header p {
            color: var(--text-light);
            font-size: 14px;
            margin-top: 5px;
        }

        .btn-add {
            background: var(--primary);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .table-card {
            background: var(--surface);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            text-align: left;
            padding: 16px 24px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-light);
            border-bottom: 1px solid var(--border);
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #f8fafc;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
        }

        .user-info span {
            font-size: 12px;
            color: var(--text-light);
        }

        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-purple {
            background: #f3e8ff;
            color: #7e22ce;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 600;
            color: #0f172a;
        }

        .rating i {
            color: #f59e0b;
            font-size: 12px;
        }

        .actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid var(--border);
            color: var(--text-light);
            transition: 0.2s;
            text-decoration: none;
        }

        .btn-icon:hover {
            background: #f1f5f9;
            color: var(--text);
        }

        .btn-icon.delete:hover {
            background: #fef2f2;
            color: var(--danger);
            border-color: #fecaca;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.3s ease;
        }

        .alert.success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <div>
                <h1>Medical Staff</h1>
                <p>Manage doctors, specialists, and their profiles.</p>
            </div>
            <a href="add_doctor.php" class="btn-add"><i class="fas fa-plus"></i> Add New Doctor</a>
        </div>

        <?php echo $message; ?>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Doctor Name</th>
                        <th>Specialty</th>
                        <th>Contact Info</th>
                        <th>Rating</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($total_doctors_count > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($doctors_result)): ?>
                            <?php $img = !empty($row['profile_image']) ? $row['profile_image'] : 'images/placeholder_doctor.png'; ?>
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <img src="<?php echo htmlspecialchars($img); ?>" alt="Avatar" class="avatar">
                                        <div class="user-info">
                                            <h4><?php echo htmlspecialchars($row['full_name']); ?></h4>
                                            <span>ID: #<?php echo $row['id']; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-purple"><?php echo htmlspecialchars($row['specialty']); ?></span></td>
                                <td>
                                    <div style="display:flex; flex-direction:column; gap:4px;">
                                        <span style="font-size:13px;"><i class="fas fa-envelope" style="color:#94a3b8; width:15px;"></i> <?php echo htmlspecialchars($row['email']); ?></span>
                                        <span style="font-size:13px;"><i class="fas fa-phone" style="color:#94a3b8; width:15px;"></i> <?php echo htmlspecialchars($row['phone']); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="rating">
                                        <i class="fas fa-star"></i> <?php echo htmlspecialchars($row['rating']); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="edit_doctor.php?id=<?php echo $row['id']; ?>" class="btn-icon" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="delete_doctor.php?id=<?php echo $row['id']; ?>" class="btn-icon delete" title="Delete User" onclick="return confirm('Are you sure you want to remove this doctor? This action is irreversible.')"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center; color:#94a3b8; padding: 40px;">No doctors found in the system.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>