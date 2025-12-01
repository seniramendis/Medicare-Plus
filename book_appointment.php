<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db_connect.php';

// FORCE LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$msg = "";
$patient_name = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = $_POST['doctor_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $reason = mysqli_real_escape_string($conn, $_POST['message']);


    $full_time_string = $date . ' (' . $time . ')';


    $check_sql = "SELECT * FROM appointments 
                  WHERE doctor_id = '$doctor_id' 
                  AND appointment_time = '$full_time_string'";

    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {

        $msg = "<div style='background:#fee2e2; color:#c62828; padding:15px; border-radius:5px; margin-bottom:20px; border: 1px solid #fca5a5;'>
                    <i class='fas fa-exclamation-circle'></i> 
                    <strong>Slot Unavailable:</strong> This doctor is already booked for $time on $date. Please choose a different time.
                </div>";
    } else {

        $sql = "INSERT INTO appointments (doctor_id, patient_name, appointment_time, reason, status) 
                VALUES ('$doctor_id', '$patient_name', '$full_time_string', '$reason', 'Scheduled')";

        if (mysqli_query($conn, $sql)) {
            $msg = "<div style='background:#d4edda; color:#155724; padding:15px; border-radius:5px; margin-bottom:20px; border: 1px solid #c3e6cb;'>
                        <i class='fas fa-check-circle'></i> 
                        <strong>Success!</strong> Your appointment has been confirmed. View status in your <a href='dashboard_patient.php' style='color:#155724; font-weight:bold;'>Dashboard</a>.
                    </div>";
        } else {
            $msg = "<div style='color:red;'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Book Appointment - Medicare Plus</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7f6;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #1e3a8a;
            border-bottom: 3px solid #57c95a;
            display: inline-block;
            padding-bottom: 5px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .full-width {
            grid-column: span 2;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        button {
            background: #57c95a;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 30px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.3s;
        }

        button:hover {
            background: #45a049;
        }
    </style>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <?php echo $msg; ?>

        <h2>Book an Appointment</h2>
        <p>Please fill in the form below. Our team will confirm your slot shortly.</p>

        <form method="POST" action="">
            <div class="form-grid">

                <div class="full-width">
                    <label>Select Doctor & Department</label>
                    <select name="doctor_id" required>
                        <option value="">-- Choose a Specialist --</option>
                        <?php
                        // Fetch doctors from database
                        $doc_sql = "SELECT id, full_name, specialty FROM users WHERE role='doctor'";
                        $doc_result = mysqli_query($conn, $doc_sql);

                        if (mysqli_num_rows($doc_result) > 0) {
                            while ($row = mysqli_fetch_assoc($doc_result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['full_name'] . " (" . $row['specialty'] . ")</option>";
                            }
                        } else {
                            echo "<option value='' disabled>No doctors available</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label>Preferred Date</label>
                    <input type="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div>
                    <label>Preferred Time</label>
                    <select name="time" required>
                        <option value="09:00 AM">09:00 AM</option>
                        <option value="10:00 AM">10:00 AM</option>
                        <option value="11:00 AM">11:00 AM</option>
                        <option value="02:00 PM">02:00 PM</option>
                        <option value="03:00 PM">03:00 PM</option>
                        <option value="04:00 PM">04:00 PM</option>
                    </select>
                </div>

                <div class="full-width">
                    <label>Reason for Visit / Symptoms</label>
                    <textarea name="message" rows="4" placeholder="Describe your symptoms briefly..." required></textarea>
                </div>
            </div>

            <button type="submit"><i class="fas fa-calendar-check"></i> Confirm Booking</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>

</body>

</html>