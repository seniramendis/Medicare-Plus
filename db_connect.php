<?php
// db_connect.php
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$dbname = "medicare_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Log the error (optional) and terminate script safely
    error_log("Database Connection Failed: " . $conn->connect_error);
    die("Database connection failed. Please try again later.");
}
