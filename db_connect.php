<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicare_db";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    error_log("Database Connection Failed: " . $conn->connect_error);
    die("Database connection failed. Please try again later.");
}
