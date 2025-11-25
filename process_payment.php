<?php
session_start();
include 'db_connect.php';

if (isset($_POST['pay_now']) && isset($_SESSION['user_id'])) {
    $patient_id = $_SESSION['user_id'];
    $invoice_id = mysqli_real_escape_string($conn, $_POST['invoice_id']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);

    // 1. GET DOCTOR ID & SERVICE INFO
    $doctor_id = 0;
    $service_name = "Medical Consultation";

    // FIX: Changed 'a.service' to 'a.reason' because your table uses 'reason'
    $info_query = "SELECT a.doctor_id, a.reason 
                   FROM invoices i 
                   JOIN appointments a ON i.appointment_id = a.id 
                   WHERE i.id = '$invoice_id'";

    $info_result = mysqli_query($conn, $info_query);
    if ($info_row = mysqli_fetch_assoc($info_result)) {
        $doctor_id = $info_row['doctor_id'];

        // FIX: Use 'reason' to populate the service name
        $service_name = $info_row['reason'];
    }

    // 2. UPDATE Invoices
    mysqli_query($conn, "UPDATE invoices SET status = 'paid' WHERE id = '$invoice_id'");

    // 3. UPDATE Appointments
    $check_sql = "SELECT appointment_id FROM invoices WHERE id = '$invoice_id'";
    $check_res = mysqli_query($conn, $check_sql);
    if ($row = mysqli_fetch_assoc($check_res)) {
        $appt_id = $row['appointment_id'];
        mysqli_query($conn, "UPDATE appointments SET status = 'Completed' WHERE id = '$appt_id'");
    }

    // 4. INSERT Payment Record
    $payment_date = date('Y-m-d H:i:s');

    // Make sure your payments table has these exact columns.
    // If 'description' or 'invoice_id' causes an error, remove them from this query.
    $insert_payment = "INSERT INTO payments (invoice_id, patient_id, doctor_id, amount, payment_method, status, paid_at, description) 
                       VALUES ('$invoice_id', '$patient_id', '$doctor_id', '$amount', 'Credit Card', 'paid', '$payment_date', '$service_name')";

    if (mysqli_query($conn, $insert_payment)) {
        echo "<script>alert('Payment Successful!'); window.location.href='dashboard_patient.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: dashboard_patient.php");
    exit();
}
