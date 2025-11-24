<?php
session_start();
include 'db_connect.php';

if (isset($_POST['update_btn'])) {
    $id = $_POST['id'];
    $service = $_POST['service'];
    $amount = $_POST['amount'];

    // Update query: Change details AND set is_edited to 1
    $sql = "UPDATE invoices SET service_name='$service', amount='$amount', is_edited=1 WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['popup_message'] = "✅ Invoice updated successfully!";
        header("Location: dashboard_doctor.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
