<?php
session_start();
include 'db_connect.php';

// Check login
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'patient') {
    die("Access Denied");
}

// Get the Prescription ID securely
if (isset($_GET['id'])) {
    $pres_id = mysqli_real_escape_string($conn, $_GET['id']);
    $patient_name = $_SESSION['username'];

    // Fetch Prescription Details (Joining Doctor & Patient info)
    $sql = "SELECT p.*, 
                   d.full_name as doctor_name, 
                   pat.full_name as patient_name 
            FROM prescriptions p 
            JOIN users d ON p.doctor_id = d.id 
            JOIN users pat ON p.patient_id = pat.id 
            WHERE p.id = '$pres_id' 
            AND pat.full_name = '$patient_name'"; // Security: Ensure this patient owns the Rx

    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $doctor = $row['doctor_name'];
        $diagnosis = $row['diagnosis'];
        $instructions = $row['dosage_instructions'];
        $date = date('F d, Y', strtotime($row['created_at']));
    } else {
        die("Prescription not found or access denied.");
    }
} else {
    die("Invalid ID");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Prescription #<?php echo $pres_id; ?></title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #eee;
            padding: 40px;
        }

        .rx-paper {
            background: white;
            max-width: 800px;
            margin: 0 auto;
            padding: 50px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .header {
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand h1 {
            margin: 0;
            color: #2563eb;
            letter-spacing: 1px;
        }

        .brand p {
            margin: 0;
            font-size: 12px;
            color: #666;
        }

        .doc-meta {
            text-align: right;
        }

        .doc-meta h3 {
            margin: 0;
            color: #333;
        }

        .doc-meta p {
            margin: 0;
            color: #888;
            font-size: 13px;
        }

        .patient-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            border: 1px solid #eee;
        }

        .rx-content {
            min-height: 400px;
        }

        .rx-symbol {
            font-size: 60px;
            font-weight: bold;
            color: #ddd;
            font-family: serif;
            margin-bottom: 20px;
            display: block;
        }

        .section-title {
            font-size: 14px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .content-box {
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .footer {
            border-top: 1px solid #eee;
            padding-top: 30px;
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .signature-line {
            width: 200px;
            border-top: 1px solid #333;
            text-align: center;
            padding-top: 5px;
            font-size: 12px;
            color: #666;
        }

        /* Print Settings */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .rx-paper {
                box-shadow: none;
                padding: 0;
                width: 100%;
                max-width: 100%;
            }

            .no-print {
                display: none;
            }
        }

        .btn-print {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #2563eb;
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
            cursor: pointer;
        }
    </style>
</head>

<body>

    <a href="javascript:window.print()" class="btn-print no-print">🖨️ Print / Save PDF</a>

    <div class="rx-paper">
        <div class="header">
            <div class="brand">
                <h1>MEDICARE PLUS</h1>
                <p>Excellence in Healthcare Management</p>
            </div>
            <div class="doc-meta">
                <h3>Dr. <?php echo htmlspecialchars($doctor); ?></h3>
                <p>General Physician | Reg ID: 884291</p>
            </div>
        </div>

        <div class="patient-info">
            <div>
                <span style="color:#888; font-size:12px; display:block;">PATIENT NAME</span>
                <strong><?php echo htmlspecialchars($row['patient_name']); ?></strong>
            </div>
            <div style="text-align:right;">
                <span style="color:#888; font-size:12px; display:block;">DATE</span>
                <strong><?php echo $date; ?></strong>
            </div>
        </div>

        <div class="rx-content">
            <span class="rx-symbol">Rx</span>

            <div class="section-title">DIAGNOSIS</div>
            <div class="content-box">
                <?php echo htmlspecialchars($diagnosis); ?>
            </div>

            <div class="section-title">MEDICATIONS & INSTRUCTIONS</div>
            <div class="content-box">
                <?php echo nl2br(htmlspecialchars($instructions)); ?>
            </div>
        </div>

        <div class="footer">
            <div style="font-size: 11px; color: #aaa;">
                Generated by Medicare Plus System<br>
                Date Printed: <?php echo date('Y-m-d H:i'); ?>
            </div>
            <div class="signature-line">
                Doctor's Signature
            </div>
        </div>
    </div>

    <script>
        // Auto-trigger print when page loads
        window.onload = function() {
            // setTimeout(function(){ window.print(); }, 500);
        }
    </script>
</body>

</html>