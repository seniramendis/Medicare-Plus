<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db_connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}
$patient_name = $_SESSION['username'];
$u_res = mysqli_query($conn, "SELECT id FROM users WHERE full_name = '$patient_name'");
$patient_id = (mysqli_num_rows($u_res) > 0) ? mysqli_fetch_assoc($u_res)['id'] : 0;

// Appointments
$result = mysqli_query($conn, "SELECT appointments.*, users.full_name AS doctor_name, users.id AS doc_user_id FROM appointments JOIN users ON appointments.doctor_id = users.id WHERE patient_name = '$patient_name' ORDER BY appointments.id DESC");

// --- LOGIC UPDATE HERE ---
// History: We now JOIN with 'invoices' to get the service name
$hist_query = "SELECT p.*, i.service_name 
               FROM payments p 
               JOIN invoices i ON p.invoice_id = i.id 
               WHERE p.patient_id = '$patient_id' 
               ORDER BY p.paid_at DESC LIMIT 5";
$hist_res = mysqli_query($conn, $hist_query);
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
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            border: 1px solid #eee;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-Scheduled {
            background: #e3f2fd;
            color: #0062cc;
        }

        .status-Completed {
            background: #dcfce7;
            color: #16a34a;
        }

        .btn-chat {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 15px;
            padding: 10px 0;
            background-color: #f0f7ff;
            color: #0062cc;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
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

        .total-due {
            font-size: 32px;
            font-weight: 700;
            color: #dc3545;
            margin: 10px 0;
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

        .btn-pay {
            background: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
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
                                <td><?php echo htmlspecialchars($hist['service_name']); ?></td>
                                <td><?php echo htmlspecialchars($hist['method']); ?></td>
                                <td style="color:#28a745; font-weight:600;">LKR <?php echo $hist['amount']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align:center; padding:15px; color:#999;">No payments yet.</td>
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
                    $icon = ($status == 'Completed') ? 'fa-check-circle' : 'fa-calendar-alt';
                    $iconColor = ($status == 'Completed') ? '#dcfce7' : '#e3f2fd';
                    $iconText = ($status == 'Completed') ? '#16a34a' : '#0062cc';
                    echo "<div class='card'>
                        <div class='card-header'><div style='width:45px; height:45px; border-radius:12px; background:$iconColor; color:$iconText; display:flex; align-items:center; justify-content:center; font-size:20px;'><i class='fas $icon'></i></div><span class='status-badge status-$status'>$status</span></div>
                        <div><h4 style='margin:0; font-size:16px; color:#333;'>{$row['doctor_name']}</h4><p style='color:#666; font-size:13px; margin:5px 0;'>{$row['appointment_time']}</p><p style='color:#888; font-size:13px;'>{$row['reason']}</p><a href='messages.php?uid={$row['doc_user_id']}' class='btn-chat'><i class='far fa-comment-dots'></i> Message Doctor</a></div>
                    </div>";
                }
            } else {
                echo "<p>No appointments found.</p>";
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
                // Math.random() forces browser to ignore cache
                $("#live-bills-container").load("load_bills.php?v=" + Math.random());
            }, 2000);
        });
    </script>
</body>

</html>