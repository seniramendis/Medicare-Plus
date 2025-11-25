<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id'"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $specialty = mysqli_real_escape_string($conn, $_POST['specialty']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);

    // Image Update Logic
    $img_sql = "";
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $new_filename = "doctor_" . time() . "." . $file_ext;
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_dir . $new_filename)) {
            $img_sql = ", profile_image='" . $target_dir . $new_filename . "'";
        }
    }

    // Password Update
    $pass_sql = "";
    if (!empty($_POST['new_password'])) {
        $pass_hash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $pass_sql = ", password='$pass_hash'";
    }

    $sql = "UPDATE users SET full_name='$name', phone='$phone', specialty='$specialty', bio='$bio' $img_sql $pass_sql WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: manage_doctors.php?status=updated");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Doctor | MEDICARE PLUS</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
    <style>
        /* Reusing standard CSS */
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

        .photo-preview-container {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid var(--border);
            margin-bottom: 20px;
        }

        .current-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
    </style>
</head>

<body>

    <div class="form-card">
        <div class="card-header">
            <h2>Edit Doctor: <?php echo htmlspecialchars($row['full_name']); ?></h2>
            <a href="manage_doctors.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">

                <div class="form-section-title">Profile Photo</div>
                <div class="photo-preview-container full-width">
                    <?php $img = !empty($row['profile_image']) ? $row['profile_image'] : 'images/placeholder_doctor.png'; ?>
                    <img src="<?php echo htmlspecialchars($img); ?>" class="current-img">
                    <div style="flex:1">
                        <label style="font-size:13px; font-weight:600; margin-bottom:5px; display:block;">Update Photo</label>
                        <input type="file" name="profile_image" style="background:white; padding:5px;">
                    </div>
                </div>

                <div class="form-section-title">Details</div>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" value="<?php echo htmlspecialchars($row['full_name']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>">
                    </div>
                    <div class="input-group">
                        <label>Specialty</label>
                        <select name="specialty" required>
                            <?php
                            $options = ['Cardiology', 'Pediatrics', 'Orthopedics', 'Dermatology', 'General Practitioner', 'Neurology'];
                            foreach ($options as $opt) {
                                $sel = ($row['specialty'] == $opt) ? 'selected' : '';
                                echo "<option value='$opt' $sel>$opt</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>New Password (Optional)</label>
                        <input type="password" name="new_password" placeholder="Leave empty to keep current">
                    </div>
                    <div class="input-group full-width">
                        <label>Biography</label>
                        <textarea name="bio" rows="3"><?php echo htmlspecialchars($row['bio']); ?></textarea>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Save Changes</button>
            </form>
        </div>
    </div>

</body>

</html>