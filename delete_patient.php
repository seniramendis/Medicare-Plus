<?php
session_start();
include 'db_connect.php';

// Security Check: Ensure Admin is logged in
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

// 1. Check if ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: manage_patients.php");
    exit();
}

// 2. Sanitize and escape the ID
$patient_id = mysqli_real_escape_string($conn, $_GET['id']);

// 3. Construct the DELETE query. Important: We confirm the role is 'patient'.
$delete_sql = "DELETE FROM users WHERE id = '$patient_id' AND role = 'patient'";

if (mysqli_query($conn, $delete_sql)) {
    // 4. Check if any rows were actually deleted
    if (mysqli_affected_rows($conn) > 0) {
        // *** SUCCESS REDIRECT ***
        header("Location: manage_patients.php?status=deleted");
    } else {
        // Patient ID was valid but maybe already deleted or wrong role
        header("Location: manage_patients.php?status=error_db");
    }
    exit();
} else {
    // *** DATABASE ERROR REDIRECT ***
    header("Location: manage_patients.php?status=error_db");
    exit();
}
