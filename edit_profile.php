<?php
// --- 1. SESSION & SECURITY ---
session_start();
// Force disable caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$my_id = $_SESSION['user_id'];

// Security Check
$check = $conn->query("SELECT id FROM users WHERE id='$my_id'");
if ($check->num_rows == 0) {
    session_destroy();
    header("Location: login.php");
    exit();
}


$sql = "SELECT * FROM users WHERE id = $my_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$role = isset($user['role']) ? strtolower($user['role']) : 'patient';


$show_alert = false;
$alert_title = "";
$alert_text = "";
$alert_icon = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title      = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
    $full_name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $address    = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $gender     = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');
    $dob        = mysqli_real_escape_string($conn, $_POST['dob'] ?? '');
    $nic        = mysqli_real_escape_string($conn, $_POST['nic'] ?? '');
    $emergency  = mysqli_real_escape_string($conn, $_POST['emergency'] ?? '');
    $specialty  = mysqli_real_escape_string($conn, $_POST['specialty'] ?? '');
    $bio        = mysqli_real_escape_string($conn, $_POST['bio'] ?? '');

    $changes = false;

    // Check Changes
    if ($full_name != $user['full_name']) $changes = true;
    if ($email != $user['email']) $changes = true;
    if ($phone != $user['phone']) $changes = true;
    if ($dob != $user['dob']) $changes = true;
    if ($gender != $user['gender']) $changes = true;
    if ($title != ($user['title'] ?? '')) $changes = true;
    if ($address != ($user['address'] ?? '')) $changes = true;
    if ($nic != ($user['nic'] ?? '')) $changes = true;
    if ($emergency != ($user['emergency_contact'] ?? '')) $changes = true;
    if ($specialty != ($user['specialty'] ?? '')) $changes = true;
    if ($bio != ($user['bio'] ?? '')) $changes = true;

    // Image Upload
    $avatar_part = "";
    if (!empty($_FILES['profile_pic']['name'])) {
        $changes = true;
        $target = "uploads/" . time() . "_" . $_FILES['profile_pic']['name'];
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {
            $avatar_part = ", profile_pic = '" . time() . "_" . $_FILES['profile_pic']['name'] . "'";
        }
    }

    // Password Logic
    $pass_part = "";
    $password_error = false;
    if (!empty($_POST['new_password'])) {
        $changes = true;
        if (empty($_POST['current_password']) || !password_verify($_POST['current_password'], $user['password'])) {
            $show_alert = true;
            $alert_icon = "error";
            $alert_title = "Error";
            $alert_text = "Incorrect Current Password";
            $password_error = true;
        } else {
            $pass_part = ", password = '" . password_hash($_POST['new_password'], PASSWORD_DEFAULT) . "'";
        }
    }

    // Update DB
    if (!$password_error) {
        if ($changes) {
            $update = "UPDATE users SET 
                       full_name='$full_name', email='$email', phone='$phone', 
                       dob='$dob', gender='$gender', address='$address', 
                       title='$title', nic='$nic', emergency_contact='$emergency', 
                       specialty='$specialty', bio='$bio' 
                       $avatar_part $pass_part 
                       WHERE id='$my_id'";

            if ($conn->query($update)) {
                $show_alert = true;
                $alert_icon = "success";
                $alert_title = "Saved!";
                $alert_text = "Profile updated successfully.";
                $_SESSION['username'] = $full_name;
                $user = $conn->query("SELECT * FROM users WHERE id = $my_id")->fetch_assoc();
            } else {
                $show_alert = true;
                $alert_icon = "error";
                $alert_title = "Error";
                $alert_text = $conn->error;
            }
        } else {
            $show_alert = true;
            $alert_icon = "info";
            $alert_title = "No Changes";
            $alert_text = "Your information is already up to date.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile | Medicare Plus</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary: #1e40af;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --bg: #f8fafc;
            --white: #ffffff;
            --border: #e2e8f0;
        }

        body {
            background-color: var(--bg);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding-top: 80px;
            color: var(--text-dark);
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 30px;
        }

        /* Sidebar */
        .profile-card {
            background: var(--white);
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            height: fit-content;
            margin-top: -75px;
        }

        .avatar-wrapper {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto 15px;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #dbeafe;
        }

        .upload-icon {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: var(--primary);
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 3px solid white;
        }

        .sidebar-name {
            font-family: 'Inter', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin: 15px 0 5px 0;
            display: block;
        }

        .user-role {
            display: inline-block;
            padding: 4px 16px;
            background: #eff6ff;
            color: var(--primary);
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-gray);
            font-size: 14px;
            margin-bottom: 12px;
            text-align: left;
        }

        .info-row i {
            color: #3b82f6;
            width: 20px;
            text-align: center;
        }

        /* Form */
        .edit-card {
            background: var(--white);
            border-radius: 16px;
            padding: 40px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-top: -75px
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-gray);
            text-transform: uppercase;
            margin-bottom: 20px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 5px;
        }

        .full-width {
            grid-column: span 2;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-gray);
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-dark);
            background: #f8fafc;
            box-sizing: border-box;
        }

        .btn-save {
            background: #1e40af;
            color: white;
            border: none;
            padding: 16px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
        }

        @media (max-width: 850px) {
            .container {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: span 1;
            }

            .edit-card {
                margin-top: auto;
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container">

        <aside class="profile-card">
            <div class="avatar-wrapper">
                <?php
                $pic = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png";
                if (!empty($user['profile_pic']) && file_exists("uploads/" . $user['profile_pic'])) {
                    $pic = "uploads/" . $user['profile_pic'];
                }
                ?>
                <img src="<?php echo $pic; ?>" id="avatarPreview" class="avatar-img">
                <label for="uploadAvatar" class="upload-icon"><i class="fas fa-camera"></i></label>
            </div>

            <h3 class="sidebar-name" style="margin-bottom: 5px !important;">
                <?php
                $display = trim(($user['title'] ?? '') . " " . ($user['full_name'] ?? ''));
                echo !empty($display) ? htmlspecialchars($display) : htmlspecialchars($_SESSION['username'] ?? 'User');
                ?>
            </h3>

            <span class="user-role" style="margin-bottom: 5px !important; display: inline-block;">
                <?php echo ucfirst($role); ?>
            </span>

            <div style="margin-top: 0px !important; padding-top: 15px !important; border-top: 1px solid #f1f5f9;">
                <div class="info-row"><i class="fas fa-id-card"></i> <?php echo htmlspecialchars($user['nic'] ?? 'No ID'); ?></div>
                <div class="info-row"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></div>
                <div class="info-row"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($user['phone'] ?? 'No Phone'); ?></div>
                <div class="info-row"><i class="fas fa-birthday-cake"></i> <?php echo htmlspecialchars($user['dob'] ?? 'No DOB'); ?></div>
                <div class="info-row"><i class="fas fa-venus-mars"></i> <?php echo htmlspecialchars($user['gender'] ?? 'No Gender'); ?></div>
                <div class="info-row" style="align-items:flex-start;">
                    <i class="fas fa-map-marker-alt" style="margin-top:3px;"></i>
                    <?php echo htmlspecialchars(substr($user['address'] ?? 'No Address', 0, 30)); ?>
                </div>
            </div>
        </aside>

        <main class="edit-card">
            <h2 style="margin:0 0 30px 0; font-size:24px; color:#1e293b;">Profile Settings</h2>

            <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="profile_pic" id="uploadAvatar" accept="image/*" style="display: none;" onchange="previewImage(this)">

                <div class="section-title"><i class="fas fa-user"></i> Personal Identity</div>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Full Name</label>
                        <div style="display: flex; gap: 15px;">
                            <select name="title" style="width: 100px;">
                                <option value="">Title</option>
                                <?php
                                $titles = ["Mr.", "Mrs.", "Ms.", "Rev."];
                                if ($role === 'doctor') {
                                    array_unshift($titles, "Dr.");
                                }
                                foreach ($titles as $t) {
                                    $sel = ($user['title'] ?? '') == $t ? 'selected' : '';
                                    echo "<option value='$t' $sel>$t</option>";
                                }
                                ?>
                            </select>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>NIC / Passport</label>
                        <input type="text" name="nic" value="<?php echo htmlspecialchars($user['nic'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">Select</option>
                            <option value="Male" <?php if (($user['gender'] ?? '') == 'Male') echo 'selected'; ?>>Male</option>
                            <option value="Female" <?php if (($user['gender'] ?? '') == 'Female') echo 'selected'; ?>>Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" value="<?php echo $user['dob'] ?? ''; ?>">
                    </div>
                </div>

                <div class="section-title"><i class="fas fa-address-book"></i> Contact Details</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                    </div>
                    <div class="form-group full-width">
                        <label>Address</label>
                        <textarea name="address" rows="2"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label style="color: #e11d48;"><i class="fas fa-phone-volume"></i> Emergency Contact</label>
                        <input type="text" name="emergency" value="<?php echo htmlspecialchars($user['emergency_contact'] ?? ''); ?>" style="background:#fff1f2; border-color:#fecdd3;">
                    </div>
                </div>

                <?php if ($role == 'doctor'): ?>
                    <div class="section-title"><i class="fas fa-user-md"></i> Medical Profile</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Specialization</label>
                            <select name="specialty">
                                <?php
                                $specs = ['Cardiologist', 'Neurologist', 'Pediatrician', 'General Surgeon', 'Dermatologist', 'General Practitioner'];
                                $cur = $user['specialty'] ?? '';
                                foreach ($specs as $s) {
                                    $sel = ($cur == $s) ? 'selected' : '';
                                    echo "<option value='$s' $sel>$s</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group full-width">
                            <label>Bio</label>
                            <textarea name="bio"><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="section-title"><i class="fas fa-lock"></i> Security</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password">
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password">
                    </div>
                </div>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </main>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var r = new FileReader();
                r.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                r.readAsDataURL(input.files[0]);
            }
        }
        <?php if ($show_alert): ?>
            Swal.fire({
                title: '<?php echo $alert_title; ?>',
                text: '<?php echo $alert_text; ?>',
                icon: '<?php echo $alert_icon; ?>',
                confirmButtonColor: '#1e40af'
            });
        <?php endif; ?>
    </script>
</body>

</html>