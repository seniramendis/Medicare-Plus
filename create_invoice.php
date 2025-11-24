<?php
session_start();
include 'db_connect.php';

if (isset($_POST['send_bill']) && isset($_SESSION['username'])) {

    $doctor_name = $_SESSION['username'];
    $appt_id     = $_POST['appointment_id'];
    $service     = $_POST['service'];
    $amount      = $_POST['amount'];

    // 1. Get Doctor ID
    $d_res = mysqli_query($conn, "SELECT id FROM users WHERE full_name = '$doctor_name'");
    $doctor_id = mysqli_fetch_assoc($d_res)['id'];

    // 2. Get Patient Name AND ID correctly
    // We first look at the Appointment to get the Patient's Name
    $appt_query = "SELECT patient_name FROM appointments WHERE id = '$appt_id'";
    $appt_res = mysqli_query($conn, $appt_query);

    if (mysqli_num_rows($appt_res) == 0) {
        die("Error: Appointment not found.");
    }

    $appt_row = mysqli_fetch_assoc($appt_res);
    $patient_name = $appt_row['patient_name'];

    // Now we find the Patient's User ID based on that name
    $u_query = "SELECT id FROM users WHERE full_name = '$patient_name'";
    $u_res = mysqli_query($conn, $u_query);
    $u_row = mysqli_fetch_assoc($u_res);
    $patient_id = $u_row['id'];

    if (!$patient_id) {
        echo "<script>alert('Error: Could not find a user account for $patient_name. Bill not sent.'); window.location.href='dashboard_doctor.php';</script>";
        exit();
    }

    // 3. CHECK LIMIT: Max 2 Invoices per Appointment
    $check_limit = "SELECT COUNT(*) as count FROM invoices WHERE appointment_id = '$appt_id'";
    $limit_res = mysqli_query($conn, $check_limit);
    $limit_row = mysqli_fetch_assoc($limit_res);

    if ($limit_row['count'] >= 2) {
        $_SESSION['popup_message'] = "⚠️ Limit Reached: You can only send 2 invoices for this appointment. Please edit an existing one.";
        header("Location: dashboard_doctor.php");
        exit();
    }

    // 4. Insert Invoice
    $sql = "INSERT INTO invoices (patient_id, doctor_id, appointment_id, amount, service_name, status, is_edited) 
            VALUES ('$patient_id', '$doctor_id', '$appt_id', '$amount', '$service', 'unpaid', 0)";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['popup_message'] = "✅ Invoice sent to " . $patient_name;
        header("Location: dashboard_doctor.php");
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    header("Location: dashboard_doctor.php");
    exit();
}
