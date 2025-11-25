<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

$msg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $nic = mysqli_real_escape_string($conn, $_POST['nic']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $e_contact = mysqli_real_escape_string($conn, $_POST['emergency_contact']);
    $created_at = date('Y-m-d H:i:s');

    // Image Upload
    $profile_image = 'images/placeholder_user.png';
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $new_filename = "patient_" . time() . "." . $file_ext;
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_dir . $new_filename)) {
            $profile_image = $target_dir . $new_filename;
        }
    }

    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "<div class='alert error'><i class='fas fa-exclamation-triangle'></i> Email is already registered.</div>";
    } else {
        $sql = "INSERT INTO users (full_name, email, password, phone, role, nic, dob, gender, address, emergency_contact, created_at, profile_image) 
                VALUES ('$full_name', '$email', '$password', '$phone', 'patient', '$nic', '$dob', '$gender', '$address', '$e_contact', '$created_at', '$profile_image')";
        if (mysqli_query($conn, $sql)) {
            header("Location: manage_patients.php?status=added");
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
    <title>Add Patient | MEDICARE PLUS</title>
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
            width: 800px;
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
            <h2>Register New Patient</h2>
            <a href="manage_patients.php" class="btn-back"><i class="fas fa-arrow-left"></i> Cancel</a>
        </div>
        <div class="card-body">
            <?php echo $msg; ?>
            <form method="POST" enctype="multipart/form-data">

                <div class="form-section-title">Account Information</div>
                <div class="form-grid">
                    <div class="input-group full-width">
                        <label>Profile Picture</label>
                        <input type="file" name="profile_image" class="file-upload" accept="image/*">
                    </div>
                    <div class="input-group">
                        <label>Full Name <span style="color:red">*</span></label>
                        <input type="text" name="full_name" required placeholder="e.g. John Doe">
                    </div>
                    <div class="input-group">
                        <label>National ID (NIC) <span style="color:red">*</span></label>
                        <input type="text" name="nic" required placeholder="Identity Number">
                    </div>
                    <div class="input-group">
                        <label>Email Address <span style="color:red">*</span></label>
                        <input type="email" name="email" required placeholder="john@example.com">
                    </div>
                    <div class="input-group">
                        <label>Password <span style="color:red">*</span></label>
                        <input type="password" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <div class="form-section-title">Personal Details</div>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" placeholder="+94 7X XXX XXXX">
                    </div>
                    <div class="input-group">
                        <label>Date of Birth <span style="color:red">*</span></label>
                        <input type="date" name="dob" required>
                    </div>
                    <div class="input-group">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Emergency Contact</label>
                        <input type="text" name="emergency_contact" placeholder="Name & Phone">
                    </div>
                    <div class="input-group full-width">
                        <label>Residential Address</label>
                        <textarea name="address" rows="2" placeholder="Street, City, Province"></textarea>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Create Patient Account</button>
            </form>
        </div>
    </div>

</body>

</html>