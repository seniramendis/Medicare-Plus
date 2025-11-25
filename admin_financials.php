<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

$current_page = 'admin_financials.php';

// --- EARNINGS TRACKER LOGIC ---
$query_total = mysqli_query($conn, "SELECT SUM(amount) as total FROM payments WHERE status = 'paid'");
$total_revenue = mysqli_fetch_assoc($query_total)['total'] ?? 0;

$today = date('Y-m-d');
$query_today = mysqli_query($conn, "SELECT SUM(amount) as total FROM payments WHERE status = 'paid' AND DATE(payment_date) = '$today'");
$today_revenue = mysqli_fetch_assoc($query_today)['total'] ?? 0;

$query_count = mysqli_query($conn, "SELECT COUNT(*) as count FROM payments WHERE status = 'paid'");
$successful_count = mysqli_fetch_assoc($query_count)['count'] ?? 0;

// --- TRANSACTION LOG ---
// Fetches the 'cause' directly from the payments table
$trans_query = "SELECT p.*, 
                pat.full_name AS patient_name, 
                doc.full_name AS doctor_name 
                FROM payments p 
                LEFT JOIN users pat ON p.patient_id = pat.id 
                LEFT JOIN users doc ON p.doctor_id = doc.id 
                ORDER BY p.payment_date DESC LIMIT 50";

$trans_result = mysqli_query($conn, $trans_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Financials | MEDICARE PLUS</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --primary: #2563eb;
            --bg: #f1f5f9;
            --surface: #ffffff;
            --text: #334155;
            --text-light: #64748b;
            --border: #e2e8f0;
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

        .main-content {
            margin-left: 260px;
            padding: 40px;
            width: calc(100% - 260px);
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
        }

        .earnings-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 30px 0;
        }

        .stat-card {
            background: var(--surface);
            padding: 25px;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .stat-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #0f172a;
        }

        .icon-box {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .table-card {
            background: var(--surface);
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            text-align: left;
            padding: 15px 20px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
        }

        td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }

        .badge-paid {
            background: #ecfdf5;
            color: #059669;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .btn-print {
            background: white;
            border: 1px solid var(--border);
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            color: var(--text);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-print:hover {
            background: #f8fafc;
        }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <div>
                <h1>Financial Overview</h1>
                <p style="color: var(--text-light); margin-top: 5px;">Track hospital revenue and transaction history.</p>
            </div>
            <button onclick="window.print()" class="btn-print"><i class="fas fa-print"></i> Print Report</button>
        </div>

        <div class="earnings-grid">
            <div class="stat-card">
                <div class="icon-box" style="background:#ecfdf5; color:#059669;"><i class="fas fa-coins"></i></div>
                <div class="stat-label">Total Earnings</div>
                <div class="stat-value">LKR <?php echo number_format($total_revenue, 2); ?></div>
            </div>
            <div class="stat-card">
                <div class="icon-box" style="background:#eff6ff; color:#2563eb;"><i class="fas fa-calendar-day"></i></div>
                <div class="stat-label">Today's Income</div>
                <div class="stat-value">LKR <?php echo number_format($today_revenue, 2); ?></div>
            </div>
            <div class="stat-card">
                <div class="icon-box" style="background:#f3e8ff; color:#7c3aed;"><i class="fas fa-receipt"></i></div>
                <div class="stat-label">Total Transactions</div>
                <div class="stat-value"><?php echo $successful_count; ?></div>
            </div>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Diagnosis / Cause</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($trans_result && mysqli_num_rows($trans_result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($trans_result)): ?>
                            <?php
                            $txn_id = isset($row['payment_id']) ? $row['payment_id'] : (isset($row['id']) ? $row['id'] : '---');
                            $txn_date = isset($row['payment_date']) ? date('M j, Y h:i A', strtotime($row['payment_date'])) : 'N/A';
                            ?>
                            <tr>
                                <td style="font-family:monospace; color:#64748b;">#<?php echo str_pad($txn_id, 6, '0', STR_PAD_LEFT); ?></td>

                                <td><strong><?php echo htmlspecialchars($row['patient_name'] ?? 'Unknown'); ?></strong></td>

                                <td style="color:#475569;"><?php echo htmlspecialchars($row['doctor_name'] ?? 'Unknown'); ?></td>

                                <td style="color:#2563eb; font-weight:500;">
                                    <?php echo htmlspecialchars($row['cause'] ?? '-'); ?>
                                </td>

                                <td><?php echo $txn_date; ?></td>

                                <td style="font-weight:700;">LKR <?php echo number_format($row['amount'], 2); ?></td>

                                <td><span class="badge-paid">Paid</span></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align:center; padding:30px;">No transactions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>