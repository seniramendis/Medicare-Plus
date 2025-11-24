<?php
include 'db_connect.php';

// This generates a valid hash for "123" using YOUR server's settings
$new_password = password_hash("123", PASSWORD_DEFAULT);

// Update ALL doctors to have this new password
$sql = "UPDATE users SET password = '$new_password' WHERE role = 'doctor'";

if (mysqli_query($conn, $sql)) {
    echo "<h1>✅ SUCCESS!</h1>";
    echo "<h3>All Doctor passwords have been reset to: 123</h3>";
    echo "<p>You can now go to <a href='login.php'>Login.php</a> and try again.</p>";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
