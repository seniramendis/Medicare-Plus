<?php
// signup_process.php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Sanitize Inputs
    $full_name = trim($_POST['full_name']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST['phone']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 2. Validate Empty Fields
    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password) || empty($dob) || empty($gender)) {
        header("Location: login.php?error=empty_fields&tab=signup");
        exit();
    }

    // 3. Validate Passwords Match
    if ($password !== $confirm_password) {
        header("Location: login.php?error=password_mismatch&tab=signup");
        exit();
    }

    // 4. Check if Email exists
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $checkStmt->close();
        header("Location: login.php?error=email_taken&tab=signup");
        exit();
    }
    $checkStmt->close();

    // 5. Hash Password and Insert Data
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, dob, gender, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $full_name, $email, $phone, $dob, $gender, $hashed_password);

    if ($stmt->execute()) {
        header("Location: login.php?success=registered");
    } else {
        header("Location: login.php?error=sql_error");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: login.php");
    exit();
}
