<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

$msg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $specialty = mysqli_real_escape_string($conn, $_POST['specialty']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $created_at = date('Y-m-d H:i:s');

    // Image Upload
    $profile_image = 'images/placeholder_doctor.png';
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $new_filename = "doctor_" . time() . "." . $file_ext;
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_dir . $new_filename)) {
            $profile_image = $target_dir . $new_filename;
        }
    }

    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "<div class='alert error'><i class='fas fa-exclamation-triangle'></i> Email is already registered.</div>";
    } else {
        $sql = "INSERT INTO users (full_name, email, password, phone, role, specialty, bio, rating, profile_image, created_at) 
                VALUES ('$name', '$email', '$pass', '$phone', 'doctor', '$specialty', '$bio', '5.0', '$profile_image', '$created_at')";

        if (mysqli_query($conn, $sql)) {
            header("Location: manage_doctors.php?status=added");
            exit();
        } else {
            $msg = "<div class='alert error'>Database Error: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Doctor | MEDICARE PLUS</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --primary: #2563eb;
            --bg: #f8fafc;
            --surface: #ffffff;
            --border: #e2e8f0;
            --text: #334155;
        }

        body {
            background-color: var(--bg);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            padding: 40px 0;
        }

        .form-card {
            background: var(--surface);
            width: 750px;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-header {
            background: white;
            padding: 25px 35px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h2 {
            font-size: 20px;
            color: #0f172a;
            font-weight: 700;
        }

        .btn-back {
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
        }

        .btn-back:hover {
            color: var(--primary);
        }

        .card-body {
            padding: 35px;
        }

        .form-section-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            margin-bottom: 15px;
            margin-top: 10px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .full-width {
            grid-column: span 2;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #475569;
            margin-bottom: 6px;
        }

        .input-group input,
        .input-group select,
        .input-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            color: #1e293b;
            transition: 0.2s;
            outline: none;
        }

        .input-group input:focus,
        .input-group select:focus,
        .input-group textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .file-upload {
            border: 2px dashed var(--border);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: 0.2s;
            background: #f8fafc;
        }

        .file-upload:hover {
            border-color: var(--primary);
            background: #eff6ff;
        }

        .btn-submit {
            background: var(--primary);
            color: white;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: #1e40af;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
        }

        .alert {
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert.error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
    </style>
</head>

<body>

    <div class="form-card">
        <div class="card-header">
            <h2>Add New Doctor</h2>
            <a href="manage_doctors.php" class="btn-back"><i class="fas fa-arrow-left"></i> Cancel</a>
        </div>
        <div class="card-body">
            <?php echo $msg; ?>
            <form method="POST" enctype="multipart/form-data">

                <div class="form-section-title">Account Credentials</div>
                <div class="form-grid">
                    <div class="input-group full-width">
                        <label>Profile Picture</label>
                        <input type="file" name="profile_image" class="file-upload" accept="image/*">
                    </div>
                    <div class="input-group">
                        <label>Full Name <span style="color:red">*</span></label>
                        <input type="text" name="full_name" required placeholder="Dr. John Doe">
                    </div>
                    <div class="input-group">
                        <label>Email Address <span style="color:red">*</span></label>
                        <input type="email" name="email" required placeholder="doctor@medicare.com">
                    </div>
                    <div class="input-group">
                        <label>Password <span style="color:red">*</span></label>
                        <input type="password" name="password" required placeholder="••••••••">
                    </div>
                    <div class="input-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" placeholder="+94 7X XXX XXXX">
                    </div>
                </div>

                <div class="form-section-title">Professional Profile</div>
                <div class="form-grid">
                    <div class="input-group full-width">
                        <label>Specialty <span style="color:red">*</span></label>
                        <select name="specialty" required>
                            <option value="">Select Specialty</option>
                            <option value="Cardiology">Cardiology</option>
                            <option value="Pediatrics">Pediatrics</option>
                            <option value="Orthopedics">Orthopedics</option>
                            <option value="Dermatology">Dermatology</option>
                            <option value="General Practitioner">General Practitioner</option>
                            <option value="Neurology">Neurology</option>
                        </select>
                    </div>
                    <div class="input-group full-width">
                        <label>Biography / Summary</label>
                        <textarea name="bio" rows="3" placeholder="Brief description of expertise..."></textarea>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Register Doctor</button>
            </form>
        </div>
    </div>

</body>

</html>