<?php
// doctor-profile.php

// 1. ENABLE ERROR REPORTING
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. CONNECT TO DB
if (file_exists('db_connect.php')) {
    include 'db_connect.php';
} else {
    die("Error: Database connection file not found.");
}

// 3. AUTH CHECK & GET REAL USER NAME
$is_logged_in = isset($_SESSION['user_id']);
$current_user_id = $is_logged_in ? $_SESSION['user_id'] : 0;
$current_user_name = 'User'; // Default fallback

if ($is_logged_in) {
    // --- FIX: Fetch the actual full_name from the database ---
    $u_stmt = $conn->prepare("SELECT full_name FROM users WHERE id = ?");
    $u_stmt->bind_param("i", $current_user_id);
    $u_stmt->execute();
    $u_result = $u_stmt->get_result();
    if ($u_row = $u_result->fetch_assoc()) {
        // Use the name from DB, otherwise fall back to session or 'User'
        $current_user_name = !empty($u_row['full_name']) ? $u_row['full_name'] : ($_SESSION['username'] ?? 'User');
    }
    $u_stmt->close();
}

// 4. GET DOCTOR SLUG
$doctor_slug = $_GET['slug'] ?? null;
if (!$doctor_slug) {
    header('Location: find_a_doctor.php');
    exit;
}

// 5. FETCH DOCTOR DETAILS
$stmt = $conn->prepare("SELECT id, name, title, specialty, image_url, bio, qualifications, schedule FROM doctors WHERE slug = ?");
if (!$stmt) {
    die("Database Error: " . $conn->error);
}
$stmt->bind_param("s", $doctor_slug);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();
$stmt->close();

if (!$doctor) {
    echo "<div style='padding:50px; text-align:center;'><h1>Doctor Not Found</h1><a href='find_a_doctor.php'>Go Back</a></div>";
    exit;
}

$doctor_name = $doctor['name'];
$doctor_id = $doctor['id'];

// 6. FETCH CHAT ID
$chat_uid = 0;
$user_stmt = $conn->prepare("SELECT id FROM users WHERE full_name = ? AND role = 'doctor' LIMIT 1");
if ($user_stmt) {
    $user_stmt->bind_param("s", $doctor_name);
    $user_stmt->execute();
    $user_res = $user_stmt->get_result();
    if ($u_row = $user_res->fetch_assoc()) {
        $chat_uid = $u_row['id'];
    }
    $user_stmt->close();
}

// 7. FETCH REVIEWS
$reviews = [];
$reviews_query = $conn->prepare("SELECT user_name, rating, review_text, review_date FROM reviews WHERE doctor_id = ? ORDER BY review_date DESC");
if ($reviews_query) {
    $reviews_query->bind_param("i", $doctor_id);
    $reviews_query->execute();
    $r_result = $reviews_query->get_result();
    while ($r_row = $r_result->fetch_assoc()) {
        $reviews[] = $r_row;
    }
    $reviews_query->close();
}

// Calculate Ratings
$total_ratings = count($reviews);
$average_rating = 0;
if ($total_ratings > 0) {
    $sum_ratings = array_sum(array_column($reviews, 'rating'));
    $average_rating = round($sum_ratings / $total_ratings, 1);
}
$full_stars = floor($average_rating);
$has_half_star = ($average_rating - $full_stars) >= 0.5;

$pageTitle = htmlspecialchars($doctor['name']) . ' - Profile';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Medicare Plus</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
            color: #333;
        }

        .doc-profile-wrapper {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }

        .doc-sidebar {
            padding: 40px 20px;
            background: #fdfdfd;
            text-align: center;
            border-right: 1px solid #eee;
        }

        .doc-img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #1e3a8a;
            padding: 3px;
            background: #fff;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .doc-name {
            font-size: 1.6rem;
            color: #1e3a8a;
            font-weight: 700;
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .doc-title {
            font-size: 1rem;
            color: #57c95a;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .doc-specialty {
            color: #777;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .doc-stars {
            color: #f0ad4e;
            font-size: 1.1rem;
            margin-bottom: 25px;
        }

        .doc-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: #1e3a8a;
            color: white;
        }

        .btn-primary:hover {
            background: #152c6b;
            transform: translateY(-2px);
        }

        .btn-outline {
            background: white;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-outline:hover {
            border-color: #57c95a;
            color: #57c95a;
        }

        .btn-msg {
            background: #e3f2fd;
            color: #0062cc;
            border: 1px solid #90caf9;
        }

        .btn-msg:hover {
            background: #bbdefb;
        }

        .doc-content {
            padding: 40px;
        }

        .doc-tabs {
            display: flex;
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 30px;
            overflow-x: auto;
        }

        .tab-btn {
            background: none;
            border: none;
            padding: 15px 25px;
            font-size: 1rem;
            font-weight: 600;
            color: #777;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            white-space: nowrap;
        }

        .tab-btn.active {
            color: #1e3a8a;
            border-bottom-color: #1e3a8a;
        }

        .tab-btn:hover {
            color: #1e3a8a;
        }

        .tab-section {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .tab-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-title {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 15px;
            border-left: 4px solid #57c95a;
            padding-left: 15px;
        }

        .text-block {
            color: #555;
            line-height: 1.7;
            margin-bottom: 20px;
            white-space: pre-line;
        }

        .review-item {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 15px;
        }

        .review-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .reviewer {
            font-weight: 700;
            color: #1e3a8a;
        }

        .review-stars {
            color: #f0ad4e;
            font-size: 0.85rem;
        }

        .review-form {
            background: #f8fafc;
            padding: 25px;
            border-radius: 12px;
            margin-top: 30px;
            border: 1px solid #e2e8f0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #444;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: inherit;
        }

        .star-rating-input {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 5px;
        }

        .star-rating-input input {
            display: none;
        }

        .star-rating-input label {
            font-size: 24px;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating-input label:hover,
        .star-rating-input label:hover~label,
        .star-rating-input input:checked~label {
            color: #f0ad4e;
        }

        .login-prompt {
            text-align: center;
            padding: 30px;
            background: #fff7ed;
            border-radius: 10px;
            border: 1px solid #ffedd5;
            color: #9a3412;
        }

        @media (max-width: 850px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .doc-sidebar {
                border-right: none;
                border-bottom: 1px solid #eee;
            }
        }
    </style>
</head>

<body>

    <?php if (file_exists('header.php')) include 'header.php'; ?>

    <div class="doc-profile-wrapper">
        <div class="profile-grid">

            <div class="doc-sidebar">
                <?php
                $img_url = !empty($doctor['image_url']) ? htmlspecialchars($doctor['image_url']) : 'images/placeholder_doctor.png';
                $img_url .= '?v=' . time(); // Cache buster
                ?>
                <img src="<?php echo $img_url; ?>" alt="<?php echo htmlspecialchars($doctor['name']); ?>" class="doc-img" loading="lazy">

                <div class="doc-name"><?php echo htmlspecialchars($doctor['name']); ?></div>
                <div class="doc-title"><?php echo htmlspecialchars($doctor['title']); ?></div>
                <div class="doc-specialty"><?php echo htmlspecialchars($doctor['specialty']); ?></div>

                <div class="doc-stars">
                    <?php for ($i = 1; $i <= 5; $i++) echo ($i <= $full_stars) ? '<i class="fa-solid fa-star"></i>' : (($i == $full_stars + 1 && $has_half_star) ? '<i class="fa-solid fa-star-half-stroke"></i>' : '<i class="fa-regular fa-star"></i>'); ?>
                    <div style="font-size:0.8rem; color:#888; margin-top:5px;">(<?php echo number_format($average_rating, 1); ?> / 5.0 based on <?php echo $total_ratings; ?> reviews)</div>
                </div>

                <a href="book_appointment.php?doctor_id=<?php echo $chat_uid; ?>" class="doc-btn btn-primary">
                    <i class="fa-regular fa-calendar-check"></i> Book Appointment
                </a>

                <?php if ($is_logged_in): ?>
                    <a href="messages.php?uid=<?php echo $chat_uid; ?>" class="doc-btn btn-msg">
                        <i class="fa-regular fa-comment-dots"></i> Message Doctor
                    </a>
                <?php else: ?>
                    <a href="login.php" class="doc-btn btn-msg">
                        <i class="fa-solid fa-lock"></i> Login to Message
                    </a>
                <?php endif; ?>

                <button onclick="scrollToReview()" class="doc-btn btn-outline">
                    <i class="fa-solid fa-pen-nib"></i> Write a Review
                </button>
            </div>

            <div class="doc-content">
                <div class="doc-tabs">
                    <button class="tab-btn active" onclick="openTab(event, 'bio')">Biography</button>
                    <button class="tab-btn" onclick="openTab(event, 'qualifications')">Qualifications</button>
                    <button class="tab-btn" onclick="openTab(event, 'schedule')">Schedule</button>
                    <button class="tab-btn" onclick="openTab(event, 'reviews')">Reviews</button>
                </div>

                <div id="bio" class="tab-section active">
                    <h3 class="section-title">About Dr. <?php echo htmlspecialchars($doctor['name']); ?></h3>
                    <div class="text-block"><?php echo strip_tags($doctor['bio']); ?></div>
                </div>

                <div id="qualifications" class="tab-section">
                    <h3 class="section-title">Medical Qualifications</h3>
                    <div class="text-block"><?php echo strip_tags($doctor['qualifications']); ?></div>
                </div>

                <div id="schedule" class="tab-section">
                    <h3 class="section-title">Availability</h3>
                    <div class="text-block"><?php echo strip_tags($doctor['schedule']); ?></div>
                </div>

                <div id="reviews" class="tab-section">
                    <h3 class="section-title">Patient Reviews</h3>

                    <?php if (empty($reviews)): ?>
                        <p style="color:#777; font-style:italic;">No reviews yet. Be the first to share your experience!</p>
                    <?php else: ?>
                        <?php foreach ($reviews as $rev): ?>
                            <div class="review-item">
                                <div class="review-head">
                                    <span class="reviewer"><?php echo htmlspecialchars($rev['user_name']); ?></span>
                                    <div class="review-stars">
                                        <?php for ($k = 1; $k <= 5; $k++) echo ($k <= $rev['rating']) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star" style="color:#ddd;"></i>'; ?>
                                    </div>
                                </div>
                                <div class="text-block" style="margin-bottom:0; font-size:0.95rem;"><?php echo htmlspecialchars($rev['review_text']); ?></div>
                                <small style="color:#aaa;"><?php echo date('M d, Y', strtotime($rev['review_date'])); ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="review-form" id="reviewFormSection">
                        <h4 style="margin-top:0; color:#1e3a8a;">Share Your Experience</h4>

                        <?php if ($is_logged_in): ?>
                            <form id="reviewForm">
                                <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">

                                <input type="hidden" name="user_name" value="<?php echo htmlspecialchars($current_user_name); ?>">

                                <div class="form-group">
                                    <label class="form-label">Rating</label>
                                    <div class="star-rating-input">
                                        <input type="radio" id="s5" name="rating" value="5" required><label for="s5"><i class="fa-solid fa-star"></i></label>
                                        <input type="radio" id="s4" name="rating" value="4"><label for="s4"><i class="fa-solid fa-star"></i></label>
                                        <input type="radio" id="s3" name="rating" value="3"><label for="s3"><i class="fa-solid fa-star"></i></label>
                                        <input type="radio" id="s2" name="rating" value="2"><label for="s2"><i class="fa-solid fa-star"></i></label>
                                        <input type="radio" id="s1" name="rating" value="1"><label for="s1"><i class="fa-solid fa-star"></i></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Your Review</label>
                                    <textarea name="review_text" class="form-input" rows="4" required placeholder="How was your appointment?"></textarea>
                                </div>

                                <button type="submit" id="submitBtn" class="doc-btn btn-primary" style="width:auto; padding:10px 30px;">Submit Review</button>
                            </form>
                        <?php else: ?>
                            <div class="login-prompt">
                                <i class="fa-solid fa-lock" style="font-size:24px; margin-bottom:10px;"></i>
                                <p>Please <strong>Login</strong> or <strong>Register</strong> to write a review.</p>
                                <div style="margin-top:15px; display:flex; gap:10px; justify-content:center;">
                                    <a href="login.php" class="doc-btn btn-primary" style="width:auto; padding:8px 25px;">Login</a>
                                    <a href="register.php" class="doc-btn btn-outline" style="width:auto; padding:8px 25px;">Register</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php if (file_exists('footer.php')) include 'footer.php'; ?>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-section");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
                tabcontent[i].classList.remove("active");
            }
            tablinks = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            setTimeout(() => document.getElementById(tabName).classList.add("active"), 10);
            evt.currentTarget.className += " active";
        }

        function scrollToReview() {
            var reviewsBtn = document.querySelector('button[onclick*="reviews"]');
            if (reviewsBtn) reviewsBtn.click();
            document.getElementById('reviewFormSection').scrollIntoView({
                behavior: 'smooth'
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('reviewForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const btn = document.getElementById('submitBtn');
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';
                    btn.disabled = true;

                    const formData = new FormData(this);

                    fetch('submit_review.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert("Review submitted successfully!");
                                location.reload();
                            } else {
                                alert("Error: " + data.message);
                                btn.innerHTML = originalText;
                                btn.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert("An error occurred. Please try again.");
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        });
                });
            }
        });
    </script>
</body>

</html>