<?php
session_start();
include 'db_connect.php';

// Check if user is a Doctor
if (!isset($_SESSION['doctor_id']) && $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

$doctor_id = $_SESSION['user_id']; // Assuming user_id is stored in session
$message = "";
$error = "";

// --- HANDLE FORM SUBMISSION ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];
    $cause = mysqli_real_escape_string($conn, $_POST['cause']);
    $amount = $_POST['amount'];
    $date = date('Y-m-d H:i:s');

    // Insert the bill into the database
    $sql = "INSERT INTO payments (patient_id, doctor_id, amount, status, payment_date, cause) 
            VALUES ('$patient_id', '$doctor_id', '$amount', 'paid', '$date', '$cause')";

    if (mysqli_query($conn, $sql)) {
        $message = "Bill added successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

// --- FETCH PATIENTS FOR DROPDOWN ---
// Gets all users who are patients so the doctor can select one
$patients = mysqli_query($conn, "SELECT id, full_name FROM users WHERE role = 'patient'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Billing | Medicare Plus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            width: 400px;
        }

        h2 {
            margin-bottom: 20px;
            color: #1e293b;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-size: 14px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Add Patient Bill</h2>

        <?php if ($message): ?> <div class="alert success"><?php echo $message; ?></div> <?php endif; ?>
        <?php if ($error): ?> <div class="alert error"><?php echo $error; ?></div> <?php endif; ?>

        <form method="POST" action="">
            <label>Select Patient</label>
            <select name="patient_id" required>
                <option value="">-- Choose Patient --</option>
                <?php while ($row = mysqli_fetch_assoc($patients)): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
                <?php endwhile; ?>
            </select>

            <label>Diagnosis / Cause</label>
            <input type="text" name="cause" placeholder="e.g. Viral Fever Treatment" required>

            <label>Amount (LKR)</label>
            <input type="number" name="amount" placeholder="5000.00" step="0.01" required>

            <button type="submit">Save Record</button>
        </form>

        <a href="doctor_dashboard.php" class="back-link">← Back to Dashboard</a>
    </div>

</body>

</html>