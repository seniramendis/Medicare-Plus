<?php
session_start();
include 'db_connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json');

$action = isset($_POST['action']) ? $_POST['action'] : '';

try {
    switch ($action) {

        // --- READ: Fetch Data ---
        case 'fetch':
            // FIXED: We select 'patient_name' directly from the appointments table
            // We still JOIN for the doctor_name because your table has 'doctor_id'
            $sql = "SELECT a.id, a.appointment_time, a.status, a.reason,
                           a.patient_name, 
                           u.full_name AS doctor_name 
                    FROM appointments a
                    LEFT JOIN users u ON a.doctor_id = u.id
                    ORDER BY a.appointment_time DESC";

            $result = mysqli_query($conn, $sql);
            if (!$result) throw new Exception(mysqli_error($conn));

            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                // If doctor name is null (deleted user), show Unknown
                $row['doctor_name'] = $row['doctor_name'] ?? 'Unknown Doctor';
                $data[] = $row;
            }
            echo json_encode($data);
            exit;

            // --- CREATE: New Appointment ---
        case 'create':
            // We now accept patient_name directly
            $p_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
            $d_id = $_POST['doctor_id'];
            $date = $_POST['date'];
            $reason = mysqli_real_escape_string($conn, $_POST['reason']);

            // FIXED: Insert into 'patient_name'
            $sql = "INSERT INTO appointments (patient_name, doctor_id, appointment_time, reason, status) 
                    VALUES ('$p_name', '$d_id', '$date', '$reason', 'Scheduled')";

            if (!mysqli_query($conn, $sql)) throw new Exception(mysqli_error($conn));

            echo json_encode(['status' => 'success']);
            break;

        // --- UPDATE: Change Status ---
        case 'update_status':
            $id = $_POST['id'];
            $status = $_POST['status'];
            $sql = "UPDATE appointments SET status = '$status' WHERE id = '$id'";
            if (!mysqli_query($conn, $sql)) throw new Exception(mysqli_error($conn));
            echo json_encode(['status' => 'success']);
            break;

        // --- DELETE: Remove Appointment ---
        case 'delete':
            $id = $_POST['id'];
            $sql = "DELETE FROM appointments WHERE id = '$id'";
            if (!mysqli_query($conn, $sql)) throw new Exception(mysqli_error($conn));
            echo json_encode(['status' => 'success']);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
