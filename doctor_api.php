<?php
include 'db_connect.php';

if ($_POST['action'] == 'fetch') {
    $doctor_name = 'Doctor'; // ideally fetch from session
    session_start();
    if (isset($_SESSION['username'])) {
        $doctor_name = $_SESSION['username'];
        $d_sql = "SELECT id FROM users WHERE full_name = '$doctor_name'";
        $doc_id = mysqli_fetch_assoc(mysqli_query($conn, $d_sql))['id'];

        // Fetch ALL appointments that are NOT completed yet (Scheduled & Confirmed)
        $sql = "SELECT * FROM appointments WHERE doctor_id = '$doc_id' ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

if ($_POST['action'] == 'update') {
    $id = $_POST['id'];
    // CHANGE: Set status to 'Confirmed' instead of 'Completed'
    $sql = "UPDATE appointments SET status = 'Confirmed' WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "Success";
    }
}

if ($_POST['action'] == 'delete') {
    $id = $_POST['id'];
    $sql = "DELETE FROM appointments WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "Success";
    }
}
