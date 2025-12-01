<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db_connect.php';

// --- TIMEZONE FIX ---
// Forces the page to display dates/times in Sri Lanka time
date_default_timezone_set('Asia/Colombo');
// --------------------

// Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

$patient_name = $_SESSION['username'];
$u_res = mysqli_query($conn, "SELECT id FROM users WHERE full_name = '$patient_name'");
$patient_id = (mysqli_num_rows($u_res) > 0) ? mysqli_fetch_assoc($u_res)['id'] : 0;


$result = mysqli_query($conn, "SELECT appointments.*, users.full_name AS doctor_name, users.id AS doc_user_id FROM appointments JOIN users ON appointments.doctor_id = users.id WHERE patient_name = '$patient_name' ORDER BY appointments.appointment_time ASC");


$hist_query = "SELECT * FROM payments 
               WHERE patient_id = '$patient_id' 
               ORDER BY paid_at DESC LIMIT 5";
$hist_res = mysqli_query($conn, $hist_query);

// --- FETCH PRESCRIPTIONS ---
$pres_query = "SELECT p.*, u.full_name as doctor_name 
               FROM prescriptions p 
               JOIN users u ON p.doctor_id = u.id 
               WHERE p.patient_id = '$patient_id' 
               ORDER BY p.created_at DESC LIMIT 6";
$pres_res = mysqli_query($conn, $pres_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Health Portal</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            min-height: 60vh;
        }

        .welcome-banner {
            background: linear-gradient(135deg, #0062cc, #0096ff);
            color: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 98, 204, 0.2);
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .banner-btn {
            background: white;
            color: #0062cc;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .banner-btn:hover {
            background: #e3f2fd;
        }

        .finance-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 40px;
        }

        .finance-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .pay-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
        }

        .pay-table th {
            text-align: left;
            color: #888;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .pay-table td {
            padding: 10px 0;
            border-bottom: 1px solid #f9f9f9;
        }

        .total-due {
            font-size: 32px;
            font-weight: 700;
            color: #dc3545;
            margin: 10px 0;
        }

        .btn-pay {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .appt-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
            background: #fff;
        }

        .appt-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .appt-card.st-Completed {
            border-left: 5px solid #22c55e;
        }

        .appt-card.st-Confirmed {
            border-left: 5px solid #0062cc;
        }

        .appt-card.st-Scheduled {
            border-left: 5px solid #f59e0b;
        }

        .appt-card.st-Prescription {
            border-left: 5px solid #6f42c1;
        }

        .appt-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .date-badge {
            background: #f8f9fa;
            color: #555;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .st-text-Completed {
            color: #22c55e;
        }

        .st-text-Confirmed {
            color: #0062cc;
        }

        .st-text-Scheduled {
            color: #f59e0b;
        }

        .st-text-Prescription {
            color: #6f42c1;
        }

        .doc-info h4 {
            margin: 0 0 5px 0;
            color: #333;
            font-size: 16px;
            font-weight: 600;
        }

        .doc-info p {
            margin: 0;
            color: #666;
            font-size: 13px;
            line-height: 1.5;
        }

        .reason-tag {
            display: inline-block;
            margin-top: 10px;
            font-size: 12px;
            color: #888;
            background: #f9f9f9;
            border: 1px solid #eee;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .card-footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #f5f5f5;
        }

        .btn-msg {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px;
            background: #f0f7ff;
            color: #0062cc;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s;
            box-sizing: border-box;
        }

        .btn-msg:hover {
            background: #0062cc;
            color: white;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="dashboard-container">
        <div class="welcome-banner">
            <div>
                <h1 style="margin:0;">Welcome back, <?php echo htmlspecialchars($patient_name); ?>! 👋</h1>
                <p style="margin:5px 0 0; opacity:0.9;">Manage your health and billing here.</p>
            </div>
            <a href="book_appointment.php" class="banner-btn"><i class="fas fa-plus-circle"></i> Book New</a>
        </div>

        <h3 style="color:#333;">Billing & Payments</h3>
        <div class="finance-section">
            <div class="finance-card" style="border-left: 5px solid #dc3545;" id="live-bills-container">
                <p style="color:#666;">Checking bills...</p>
            </div>

            <div class="finance-card" style="border-left: 5px solid #28a745;">
                <h4 style="margin:0; color:#555;">Recent Transactions</h4>
                <table class="pay-table">
                    <tr>
                        <th>Date</th>
                        <th>Service</th>
                        <th>Method</th>
                        <th>Amount</th>
                    </tr>
                    <?php if (mysqli_num_rows($hist_res) > 0): ?>
                        <?php while ($hist = mysqli_fetch_assoc($hist_res)): ?>
                            <tr>
                                <td><?php echo date('M d', strtotime($hist['paid_at'])); ?></td>
                                <td><?php echo htmlspecialchars($hist['description']); ?></td>
                                <td><?php echo isset($hist['payment_method']) ? htmlspecialchars($hist['payment_method']) : 'Online'; ?></td>
                                <td style="color:#28a745; font-weight:600;">LKR <?php echo number_format($hist['amount'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align:center; padding:15px; color:#999;">No payments made yet.</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <h3 style="color:#333; margin-bottom:20px;">My Appointments</h3>
        <div class="dashboard-grid">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $status = $row['status'];
                    $status_class = "st-" . $status;

                    $raw_date = $row['appointment_time'];
                    $timestamp = strtotime($raw_date);

                    if ($timestamp && date('Y', $timestamp) != '1970' && strpos($raw_date, '0000') === false) {
                        $nice_date = date('M d, Y', $timestamp);
                        $nice_time = date('h:i A', $timestamp);
                        $time_html = "<p><i class='far fa-clock' style='color:#bbb; margin-right:5px;'></i> $nice_time</p>";
                    } else {
                        $nice_date = !empty($raw_date) ? $raw_date : "Date Pending";
                        $time_html = "";
                    }

                    echo "
                    <div class='appt-card $status_class'>
                        <div class='appt-header'>
                            <div class='date-badge'><i class='far fa-calendar-alt'></i> $nice_date</div>
                            <div class='status-label st-text-$status'>$status</div>
                        </div>

                        <div class='doc-info'>
                            <h4>{$row['doctor_name']}</h4>
                            $time_html
                            <div class='reason-tag'>{$row['reason']}</div>
                        </div>

                        <div class='card-footer'>
                            <a href='messages.php?uid={$row['doc_user_id']}' class='btn-msg'>
                                <i class='far fa-comment-dots'></i> Message Doctor
                            </a>
                        </div>
                    </div>";
                }
            } else {
                echo "<p style='color:#888; text-align:center; grid-column:1/-1;'>No appointments found.</p>";
            }
            ?>
        </div>

        <h3 style="color:#333; margin-top:40px; margin-bottom:20px;">Medical Prescriptions</h3>
        <div class="dashboard-grid">
            <?php
            // CHECKING IF PRESCRIPTIONS EXIST
            if ($pres_res && mysqli_num_rows($pres_res) > 0) {
                while ($pres = mysqli_fetch_assoc($pres_res)) {

                    // Styling for Prescriptions
                    $border_class = "st-Prescription";
                    $text_class = "st-text-Prescription";
                    $bg_color = "#f3e5f5"; // Purple bg
                    $main_color = "#6f42c1"; // Purple text

                    $r_date = date('M d, Y', strtotime($pres['created_at']));

                    echo "
                    <div class='appt-card $border_class'>
                        <div class='appt-header'>
                            <div class='date-badge'><i class='fas fa-file-prescription'></i> $r_date</div>
                            <div class='status-label $text_class'>RX PRESCRIPTION</div>
                        </div>

                        <div class='doc-info'>
                            <h4>Dr. {$pres['doctor_name']}</h4>
                            <p style='color:#333; font-weight:600; font-size:14px; margin-bottom:5px;'>Diagnosis: {$pres['diagnosis']}</p>
                            <div class='reason-tag' style='background:$bg_color; color:$main_color; border:none; display:block; white-space:pre-wrap; max-height:60px; overflow:hidden;'>{$pres['dosage_instructions']}</div>
                        </div>

                        <div class='card-footer'>
                            <button class='btn-msg' style='background:$bg_color; color:$main_color; cursor:pointer;' 
                                    onclick=\"window.open('print_prescription.php?id={$pres['id']}', '_blank')\">
                                <i class='fas fa-print'></i> Print Prescription
                            </button>
                        </div>
                    </div>";
                }
            } else {
                echo "<p style='color:#888; text-align:center; grid-column:1/-1; padding:20px; background:white; border-radius:12px;'>No prescriptions found yet.</p>";
            }
            ?>
        </div>

    </div>
    <?php include 'footer.php'; ?>

    <script>
        $(document).ready(function() {
            // Initial load
            $("#live-bills-container").load("load_bills.php?v=" + Math.random());

            // Refresh every 2 seconds
            setInterval(function() {
                $("#live-bills-container").load("load_bills.php?v=" + Math.random());
            }, 2000);
        });
    </script>
</body>

</html>