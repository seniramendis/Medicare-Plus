<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

$doctor_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Doctor';

// 1. Get Doctor ID
$d_sql = "SELECT id FROM users WHERE full_name = '$doctor_name'";
$d_res = mysqli_query($conn, $d_sql);
$doc_data = mysqli_fetch_assoc($d_res);
$doc_id = $doc_data['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard | MEDICARE PLUS</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* (Your CSS remains exactly the same as you provided) */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
        }

        .dashboard-wrapper {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
            min-height: 80vh;
        }

        .doc-sidebar {
            background: white;
            border-radius: 16px;
            padding: 30px 20px;
            height: fit-content;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .doc-profile {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .doc-avatar {
            width: 90px;
            height: 90px;
            background: #e3f2fd;
            color: #0062cc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin: 0 auto 15px;
            border: 3px solid #fff;
            box-shadow: 0 5px 15px rgba(0, 98, 204, 0.15);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-menu li {
            width: 100%;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 20px;
            color: #666;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            transition: 0.2s;
        }

        .sidebar-menu a:hover {
            background-color: #f0f7ff;
            color: #0062cc;
            padding-left: 25px;
        }

        .sidebar-menu a.active {
            background-color: #0062cc;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 98, 204, 0.3);
        }

        .doc-content {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
        }

        .stat-item {
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s;
        }

        .stat-item:hover {
            transform: translateY(-5px);
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

        .table-section {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .invoice-form {
            display: flex;
            gap: 15px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .btn-send {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            height: 38px;
        }

        .btn-send:hover {
            background: #218838;
        }

        .doc-table {
            width: 100%;
            border-collapse: collapse;
        }

        .doc-table th {
            text-align: left;
            padding: 15px;
            color: #888;
            font-size: 13px;
            font-weight: 600;
            border-bottom: 2px solid #f5f5f5;
        }

        .doc-table td {
            padding: 15px;
            border-bottom: 1px solid #f5f5f5;
            color: #333;
            font-size: 14px;
            vertical-align: middle;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .st-Scheduled {
            background: #fff3e0;
            color: #ff9800;
        }

        .st-Confirmed {
            background: #e3f2fd;
            color: #0062cc;
        }

        .st-Completed {
            background: #dcfce7;
            color: #16a34a;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 5px;
        }

        .btn-check {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .btn-trash {
            background: #ffebee;
            color: #c62828;
        }

        .live-dot {
            height: 8px;
            width: 8px;
            background-color: #22c55e;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
</head>

<body>

    <?php if (isset($_SESSION['popup_message'])): ?>
        <script>
            alert("<?php echo $_SESSION['popup_message']; ?>");
        </script>
        <?php unset($_SESSION['popup_message']); ?>
    <?php endif; ?>

    <?php include 'header.php'; ?>

    <div class="dashboard-wrapper">
        <aside class="doc-sidebar">
            <div class="doc-profile">
                <div class="doc-avatar"><?php echo strtoupper(substr($doctor_name, 0, 1)); ?></div>
                <h3 style="margin:0; font-size:18px; color:#333;"><?php echo htmlspecialchars($doctor_name); ?></h3>
                <p style="color:#0062cc; font-size:13px; margin-top:5px;">Medical Specialist</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#" class="active"><i class="fas fa-th-large"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-calendar-alt"></i> My Schedule</a></li>
                <li><a href="#"><i class="fas fa-wallet"></i> Earnings</a></li>
                <li style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px;">
                    <a href="logout.php" style="color: #dc3545;"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </aside>

        <main class="doc-content">

            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon" style="background:#e3f2fd; color:#0062cc;"><i class="fas fa-user-injured"></i></div>
                    <div>
                        <h3 style="margin:0; font-size:28px; color:#333;" id="cnt-total">0</h3>
                        <p style="margin:0; font-size:14px; color:#888;">Total Patients</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon" style="background:#e8f5e9; color:#2e7d32;"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <h3 style="margin:0; font-size:28px; color:#333;" id="cnt-completed">0</h3>
                        <p style="margin:0; font-size:14px; color:#888;">Completed</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon" style="background:#fff3e0; color:#ff9800;"><i class="fas fa-clock"></i></div>
                    <div>
                        <h3 style="margin:0; font-size:28px; color:#333;" id="cnt-pending">0</h3>
                        <p style="margin:0; font-size:14px; color:#888;">Pending</p>
                    </div>
                </div>
                <div class="stat-item" style="border-left: 4px solid #ffc107;">
                    <div class="stat-icon" style="background:#fff3e0; color:#ff9800;"><i class="fas fa-coins"></i></div>
                    <div>
                        <h3 style="margin:0; font-size:24px; color:#333;">LKR <span id="live-revenue">0.00</span></h3>
                        <p style="margin:0; font-size:14px; color:#888;">Total Earnings</p>
                    </div>
                </div>
            </div>

            <div class="table-section" style="background: #f8f9fa; border: 1px solid #e9ecef;">
                <div class="section-title"><i class="fas fa-file-invoice-dollar" style="color: #28a745;"></i> Send Invoice</div>
                <form action="create_invoice.php" method="POST" class="invoice-form">
                    <div class="form-group">
                        <label>Select Confirmed Appointment</label>
                        <select name="appointment_id" required class="form-input">
                            <option value="">-- Select Appointment --</option>
                            <?php
                            $pat_sql = "SELECT appointments.id as appt_id, appointments.patient_name, appointments.appointment_time
                                        FROM appointments 
                                        WHERE appointments.doctor_id = '$doc_id' 
                                        AND appointments.status = 'Confirmed'";
                            $pat_res = mysqli_query($conn, $pat_sql);
                            if (mysqli_num_rows($pat_res) > 0) {
                                while ($row = mysqli_fetch_assoc($pat_res)) {
                                    echo "<option value='" . $row['appt_id'] . "'>" . $row['patient_name'] . " (" . $row['appointment_time'] . ")</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No confirmed appointments</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" style="flex: 2;">
                        <label>Service Description</label>
                        <input type="text" name="service" placeholder="e.g. MRI Scan" required class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Amount (LKR)</label>
                        <input type="number" name="amount" placeholder="0.00" step="0.01" required class="form-input">
                    </div>
                    <button type="submit" name="send_bill" class="btn-send">Send Bill</button>
                </form>
            </div>

            <div class="table-section" style="border-top: 4px solid #28a745;">
                <div class="section-title"><i class="fas fa-money-bill-wave" style="color: #28a745;"></i> Recent Received Payments</div>
                <table class="doc-table">
                    <thead>
                        <tr>
                            <th>DATE</th>
                            <th>PATIENT NAME</th>
                            <th>METHOD</th>
                            <th>AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // JOIN Query to find payments linked to invoices created by THIS doctor
                        $pay_query = "SELECT p.*, u.full_name as patient_name 
                                      FROM payments p 
                                      JOIN invoices i ON p.invoice_id = i.id 
                                      JOIN users u ON p.patient_id = u.id 
                                      WHERE i.doctor_id = '$doc_id' 
                                      ORDER BY p.paid_at DESC LIMIT 5";

                        $pay_res = mysqli_query($conn, $pay_query);

                        if (mysqli_num_rows($pay_res) > 0) {
                            while ($pay_row = mysqli_fetch_assoc($pay_res)) {
                                echo "<tr>
                                    <td>" . date('M d, Y', strtotime($pay_row['paid_at'])) . "</td>
                                    <td><i class='fas fa-user-circle' style='color:#ccc;'></i> " . htmlspecialchars($pay_row['patient_name']) . "</td>
                                    <td>" . htmlspecialchars($pay_row['method']) . "</td>
                                    <td style='color:#16a34a; font-weight:bold;'>+ LKR " . number_format($pay_row['amount'], 2) . "</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align:center; color:#999; padding:20px;'>No payments received yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="table-section" style="border-top: 4px solid #0062cc;">
                <div class="section-title"><i class="fas fa-list-alt" style="color: #0062cc;"></i> Sent Invoices History</div>
                <table class="doc-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>PATIENT</th>
                            <th>SERVICE</th>
                            <th>AMOUNT</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $inv_res = mysqli_query($conn, "SELECT invoices.*, users.full_name as patient_name FROM invoices JOIN users ON invoices.patient_id = users.id WHERE doctor_id = '$doc_id' ORDER BY id DESC LIMIT 5");
                        if (mysqli_num_rows($inv_res) > 0) {
                            while ($row = mysqli_fetch_assoc($inv_res)) {
                                $is_paid = ($row['status'] == 'paid');
                                $status_style = $is_paid ? "background:#dcfce7; color:#16a34a;" : "background:#fff3e0; color:#ff9800;";
                                echo "<tr><td>#{$row['id']}</td><td>{$row['patient_name']}</td><td>{$row['service_name']}</td><td>LKR {$row['amount']}</td><td><span style='padding:4px 8px; border-radius:12px; font-size:11px; font-weight:bold; $status_style'>" . strtoupper($row['status']) . "</span></td><td>";
                                if (!$is_paid) {
                                    echo "<a href='edit_invoice.php?id={$row['id']}' style='color:#0062cc; text-decoration:none; font-weight:bold; font-size:13px;'><i class='fas fa-edit'></i> Edit</a>";
                                } else {
                                    echo "<span style='color:#ccc; font-size:12px;'><i class='fas fa-lock'></i> Paid</span>";
                                }
                                echo "</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' style='text-align:center; color:#999;'>No invoices sent yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="table-section">
                <div class="section-title"><span class="live-dot"></span> Incoming Appointments</div>
                <table class="doc-table">
                    <thead>
                        <tr>
                            <th>TIME</th>
                            <th>PATIENT</th>
                            <th>REASON</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="upcomingTableBody"></tbody>
                </table>
            </div>

            <div class="table-section" style="opacity: 0.8;">
                <div class="section-title" style="color: #555;"><i class="fas fa-history" style="color:#888;"></i> Completed History</div>
                <table class="doc-table">
                    <thead>
                        <tr>
                            <th>TIME</th>
                            <th>PATIENT NAME</th>
                            <th>REASON</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody"></tbody>
                </table>
            </div>

        </main>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        $(document).ready(function() {
            fetchAppointments();
            fetchStats();
            setInterval(fetchAppointments, 3000);
            setInterval(fetchStats, 3000);
        });

        function fetchStats() {
            $.ajax({
                url: 'fetch_earnings.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#live-revenue').text(data.revenue);
                    $('#cnt-total').text(data.total);
                    $('#cnt-completed').text(data.completed);
                    $('#cnt-pending').text(data.pending);
                }
            });
        }

        function fetchAppointments() {
            $.ajax({
                url: 'doctor_api.php',
                type: 'POST',
                data: {
                    action: 'fetch'
                },
                success: function(data) {
                    let upcomingRows = '',
                        historyRows = '';
                    if (!data || data.length === 0) {
                        upcomingRows = '<tr><td colspan="5" style="text-align:center;">No appointments.</td></tr>';
                    } else {
                        data.forEach(function(appt) {
                            if (appt.status === 'Completed') {
                                historyRows += `<tr style="background:#fafafa;"><td>${appt.appointment_time}</td><td>${appt.patient_name}</td><td>${appt.reason}</td><td><span class="status-badge st-Completed">Completed</span></td><td><button class="btn-icon btn-trash" onclick="deleteAppt(${appt.id})"><i class="fas fa-trash"></i></button></td></tr>`;
                            } else {
                                let badgeClass = (appt.status === 'Confirmed') ? 'st-Confirmed' : 'st-Scheduled';
                                let badgeText = (appt.status === 'Confirmed') ? 'Confirmed' : 'Scheduled';
                                let actionBtns = '';
                                if (appt.status === 'Confirmed') {
                                    actionBtns = `<span style="color:#0062cc; font-size:11px; font-weight:bold;">Ready to Bill</span>`;
                                } else {
                                    actionBtns = `<button class="btn-icon btn-check" onclick="completeAppt(${appt.id})"><i class="fas fa-check"></i></button><button class="btn-icon btn-trash" onclick="deleteAppt(${appt.id})"><i class="fas fa-trash"></i></button>`;
                                }
                                upcomingRows += `<tr><td style="font-weight:600; color:#0062cc;">${appt.appointment_time}</td><td>${appt.patient_name}</td><td>${appt.reason}</td><td><span class="status-badge ${badgeClass}">${badgeText}</span></td><td>${actionBtns}</td></tr>`;
                            }
                        });
                    }
                    $('#upcomingTableBody').html(upcomingRows);
                    $('#historyTableBody').html(historyRows);
                }
            });
        }

        function completeAppt(id) {
            $.post('doctor_api.php', {
                action: 'update',
                id: id
            }, function() {
                location.reload();
            });
        }

        function deleteAppt(id) {
            if (confirm('Delete?')) {
                $.post('doctor_api.php', {
                    action: 'delete',
                    id: id
                }, function() {
                    location.reload();
                });
            }
        }
    </script>
</body>

</html>