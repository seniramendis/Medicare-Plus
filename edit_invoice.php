<?php
session_start();
include 'db_connect.php';

// Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM invoices WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Prevent editing if already paid
if ($row['status'] == 'paid') {
    echo "<script>alert('Cannot edit a paid invoice!'); window.location.href='dashboard_doctor.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Invoice | Medicare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .edit-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }

        .btn-save {
            background: #28a745;
            color: white;
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
        }
    </style>
</head>

<body>
    <div class="edit-card">
        <h2 style="margin-top:0;">Edit Invoice #<?php echo $id; ?></h2>
        <form action="update_invoice_logic.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <label>Service Description</label>
            <input type="text" name="service" value="<?php echo $row['service_name']; ?>" required>

            <label>Amount (LKR)</label>
            <input type="number" name="amount" value="<?php echo $row['amount']; ?>" step="0.01" required>

            <button type="submit" class="btn btn-save" name="update_btn">Save Changes</button>
            <a href="dashboard_doctor.php"><button type="button" class="btn btn-cancel">Cancel</button></a>
        </form>
    </div>
</body>

</html>