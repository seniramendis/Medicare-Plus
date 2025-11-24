<?php
session_start();
include 'db_connect.php';

// Ensure the request came from the payment form
if (isset($_POST['pay_now']) && isset($_SESSION['username'])) {

    $patient_name = $_SESSION['username'];
    $invoice_id = $_POST['invoice_id'];
    $amount = $_POST['amount'];

    // 1. Get Patient ID
    $u_query = "SELECT id FROM users WHERE full_name = '$patient_name'";
    $u_result = mysqli_query($conn, $u_query);

    if (mysqli_num_rows($u_result) > 0) {
        $u_row = mysqli_fetch_assoc($u_result);
        $patient_id = $u_row['id'];
    } else {
        echo "<script>alert('Error: User not found.'); window.location.href='dashboard_patient.php';</script>";
        exit();
    }

    // 2. Mark Invoice as PAID
    // This is CRITICAL: The doctor dashboard looks for invoices belonging to them.
    $update_inv = "UPDATE invoices SET status = 'paid' WHERE id = '$invoice_id'";
    mysqli_query($conn, $update_inv);

    // 3. Record Transaction in Payments Table
    // We link the payment to the Invoice ID. 
    // The Doctor Dashboard will use the Invoice ID to figure out who gets the money.
    $insert_hist = "INSERT INTO payments (invoice_id, patient_id, amount, method, paid_at) 
                    VALUES ('$invoice_id', '$patient_id', '$amount', 'Online Card', NOW())";

    if (mysqli_query($conn, $insert_hist)) {

        // 4. Auto-Complete the Linked Appointment
        $check_sql = "SELECT appointment_id FROM invoices WHERE id = '$invoice_id'";
        $check_res = mysqli_query($conn, $check_sql);
        $row = mysqli_fetch_assoc($check_res);

        if ($row && !empty($row['appointment_id'])) {
            $appt_id = $row['appointment_id'];
            $complete_sql = "UPDATE appointments SET status = 'Completed' WHERE id = '$appt_id'";
            mysqli_query($conn, $complete_sql);
        }

        // 5. Success Message
        echo "<script>
                alert('Payment Successful! The transaction is now visible on your dashboard.'); 
                window.location.href='dashboard_patient.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: dashboard_patient.php");
    exit();
}
