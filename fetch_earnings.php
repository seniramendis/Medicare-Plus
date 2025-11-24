<?php
session_start();
include 'db_connect.php';

// Security: Ensure it's a doctor
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    echo json_encode(['revenue' => 0, 'total' => 0, 'completed' => 0, 'pending' => 0]);
    exit();
}

$doctor_name = $_SESSION['username'];

// 1. Get Doctor ID
$d_sql = "SELECT id FROM users WHERE full_name = '$doctor_name'";
$d_res = mysqli_query($conn, $d_sql);
$doc_data = mysqli_fetch_assoc($d_res);
$doc_id = $doc_data['id'];

// --- 2. CALCULATE EARNINGS (The Fix) ---
// We SUM the 'amount' from the 'payments' table.
// We must JOIN 'invoices' to make sure we only count money for THIS doctor.
$earning_sql = "SELECT SUM(p.amount) as total_earned 
                FROM payments p 
                JOIN invoices i ON p.invoice_id = i.id 
                WHERE i.doctor_id = '$doc_id'";

$earning_res = mysqli_query($conn, $earning_sql);
$earning_row = mysqli_fetch_assoc($earning_res);

// If NULL (no payments yet), set to 0
$total_revenue = $earning_row['total_earned'] ? $earning_row['total_earned'] : 0;


// --- 3. GET OTHER STATS (Patients, Completed, Pending) ---

// Total Unique Patients
$pat_sql = "SELECT COUNT(DISTINCT patient_name) as cnt FROM appointments WHERE doctor_id = '$doc_id'";
$pat_res = mysqli_fetch_assoc(mysqli_query($conn, $pat_sql));

// Completed Appointments
$comp_sql = "SELECT COUNT(*) as cnt FROM appointments WHERE doctor_id = '$doc_id' AND status = 'Completed'";
$comp_res = mysqli_fetch_assoc(mysqli_query($conn, $comp_sql));

// Pending Appointments
$pend_sql = "SELECT COUNT(*) as cnt FROM appointments WHERE doctor_id = '$doc_id' AND (status = 'Scheduled' OR status = 'Confirmed')";
$pend_res = mysqli_fetch_assoc(mysqli_query($conn, $pend_sql));


// --- 4. RETURN DATA AS JSON ---
// The Javascript in dashboard_doctor.php reads this
header('Content-Type: application/json');
echo json_encode([
    'revenue' => number_format($total_revenue, 2), // Formats like 1,500.00
    'total' => $pat_res['cnt'],
    'completed' => $comp_res['cnt'],
    'pending' => $pend_res['cnt']
]);
