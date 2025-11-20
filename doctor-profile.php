<?php
// --- 1. START SESSION ---
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- 2. DATABASE ---
if (file_exists('db_connect.php')) {
    include 'db_connect.php';
} else {
    die("Error: db_connect.php not found.");
}

// --- 3. AUTH CHECK ---
$is_logged_in = isset($_SESSION['user_id']);
$current_user_id = $is_logged_in ? $_SESSION['user_id'] : 0;
$current_user_name = $is_logged_in ? ($_SESSION['user_name'] ?? 'User') : 'Guest';

// --- 4. GET DATA ---
$doctor_slug = $_GET['slug'] ?? null;
if (!$doctor_slug) {
    header('Location: find_a_doctor.php');
    exit;
}

$stmt = $conn->prepare("SELECT id, name, title, specialty, image_url, bio, qualifications, schedule FROM doctors WHERE slug = ?");
$stmt->bind_param("s", $doctor_slug);
$stmt->execute();
$doctor = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$doctor) {
    echo "<div style='padding:50px; text-align:center;'><h1>Doctor Not Found</h1><a href='find_a_doctor.php'>Go Back</a></div>";
    exit;
}

$doctor_id = $doctor['id'];

// --- 5. REVIEWS ---
$reviews_query = $conn->prepare("SELECT user_name, rating, review_text, review_date FROM reviews WHERE doctor_id = ? ORDER BY review_date DESC");
$reviews_query->bind_param("i", $doctor_id);
$reviews_query->execute();
$reviews = $reviews_query->get_result()->fetch_all(MYSQLI_ASSOC);
$reviews_query->close();

$total_ratings = count($reviews);
$sum_ratings = array_sum(array_column($reviews, 'rating'));
$average_rating = $total_ratings > 0 ? round($sum_ratings / $total_ratings, 1) : 0.0;
$full_stars = floor($average_rating);
$has_half_star = ($average_rating - $full_stars) >= 0.5;

$pageTitle = $doctor['name'] . ' - Profile';
$pageKey = 'find_doctor';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Medicare Plus</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>

    <style>
        /* --- GLOBAL RESETS (Keep header safe) --- */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
        }

        /* --- SCOPED PROFILE CSS --- */
        .doc-profile-wrapper {
            padding: 40px 0;
            font-family: 'Roboto', sans-serif;
        }

        .profile-grid {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 40px;
            padding: 40px;
            border: 1px solid #e0e0e0;
        }

        /* Sidebar */
        .doc-sidebar {
            text-align: center;
            padding-right: 30px;
            border-right: 1px solid #eee;
        }

        .doc-img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #1e3a8a;
            padding: 3px;
            background: #fff;
            margin-bottom: 20px;
        }

        .doc-name {
            font-size: 1.8em;
            color: #1e3a8a;
            margin: 10px 0 5px 0;
            font-weight: bold;
            line-height: 1.2;
        }

        .doc-title {
            font-size: 1.1em;
            color: #57c95a;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .doc-specialty {
            color: #777;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-size: 0.9em;
            letter-spacing: 1px;
        }

        .doc-stars {
            color: #f0ad4e;
            font-size: 1.1em;
            margin-bottom: 25px;
        }

        /* Buttons */
        .doc-btn {
            display: block;
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            text-align: center;
            transition: 0.3s;
            font-size: 1em;
            cursor: pointer;
            border: none;
        }

        .doc-btn-primary {
            background-color: #1e3a8a;
            color: white !important;
        }

        .doc-btn-primary:hover {
            background-color: #152c6b;
            transform: translateY(-2px);
        }

        .doc-btn-secondary {
            background-color: white;
            color: #555 !important;
            border: 2px solid #e0e0e0;
        }

        .doc-btn-secondary:hover {
            border-color: #57c95a;
            color: #57c95a !important;
        }

        /* Content */
        .doc-content h1 {
            font-size: 2.2em;
            color: #1e3a8a;
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #f4f7f6;
            padding-bottom: 15px;
        }

        /* Tabs */
        .doc-tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 30px;
            overflow-x: auto;
        }

        .doc-tab-btn {
            background: none;
            border: none;
            padding: 15px 25px;
            font-size: 1em;
            font-weight: bold;
            color: #777;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            white-space: nowrap;
        }

        .doc-tab-btn.active {
            color: #1e3a8a;
            border-bottom: 3px solid #1e3a8a;
        }

        .doc-section-header {
            font-size: 1.4em;
            color: #333;
            margin-bottom: 15px;
            border-left: 4px solid #57c95a;
            padding-left: 15px;
        }

        .doc-text-block {
            color: #555;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .hidden {
            display: none;
        }

        /* Reviews */
        .doc-review-item {
            border: 1px solid #eee;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            background: #fff;
        }

        .doc-review-head {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .doc-reviewer {
            font-weight: bold;
            color: #1e3a8a;
        }

        .doc-date {
            font-size: 0.85em;
            color: #999;
        }

        .doc-star-display {
            color: #f0ad4e;
            font-size: 0.9em;
        }

        /* Review Form */
        .doc-form-box {
            background: #f9f9f9;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #eee;
            margin-top: 30px;
        }

        .doc-rating-select {
            margin: 10px 0;
            direction: rtl;
            display: inline-block;
        }

        .doc-rating-select input {
            display: none;
        }

        .doc-rating-select label {
            font-size: 2em;
            color: #ddd;
            cursor: pointer;
            padding: 0 2px;
            transition: color 0.2s;
        }

        .doc-rating-select label:hover,
        .doc-rating-select label:hover~label,
        .doc-rating-select input:checked~label {
            color: #f0ad4e;
        }

        .doc-form-box textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            min-height: 120px;
            font-family: inherit;
            margin-bottom: 15px;
        }

        /* Mobile */
        @media (max-width: 900px) {
            .profile-grid {
                grid-template-columns: 1fr;
                gap: 30px;
                width: 95%;
                padding: 20px;
            }

            .doc-sidebar {
                border-right: none;
                border-bottom: 1px solid #eee;
                padding-right: 0;
                padding-bottom: 30px;
            }

            .doc-tabs {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

    <?php
    if (file_exists('header.php')) {
        include 'header.php';
    }
    ?>

    <div class="doc-profile-wrapper">
        <div class="profile-grid">

            <div class="doc-sidebar">
                <img src="<?php echo htmlspecialchars($doctor['image_url']); ?>"
                    alt="<?php echo htmlspecialchars($doctor['name']); ?>"
                    class="doc-img"
                    onerror="this.src='images/placeholder_doctor.png'">

                <div class="doc-name"><?php echo htmlspecialchars($doctor['name']); ?></div>
                <div class="doc-title"><?php echo htmlspecialchars($doctor['title']); ?></div>
                <div class="doc-specialty"><?php echo htmlspecialchars($doctor['specialty']); ?></div>

                <div class="doc-stars">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $full_stars) echo '<i class="fa-solid fa-star"></i>';
                        elseif ($i == $full_stars + 1 && $has_half_star) echo '<i class="fa-solid fa-star-half-stroke"></i>';
                        else echo '<i class="fa-regular fa-star"></i>';
                    }
                    ?>
                    <br><span style="font-size:0.8em; color:#777;">(<?php echo number_format($average_rating, 1); ?> / 5.0)</span>
                </div>

                <a href="book_appointment.php?doctor_id=<?php echo $doctor_id; ?>" class="doc-btn doc-btn-primary">
                    <i class="fa-regular fa-calendar-check"></i> Book Appointment
                </a>

                <button onclick="goToReviews()" class="doc-btn doc-btn-secondary">Write a Review</button>
            </div>

            <div class="doc-content">
                <h1><?php echo htmlspecialchars($doctor['name']); ?></h1>

                <div class="doc-tabs">
                    <button class="doc-tab-btn active" id="tab-btn-bio" onclick="switchTab('bio', this)">Biography</button>
                    <button class="doc-tab-btn" id="tab-btn-qualifications" onclick="switchTab('qualifications', this)">Qualifications</button>
                    <button class="doc-tab-btn" id="tab-btn-schedule" onclick="switchTab('schedule', this)">Schedule</button>
                    <button class="doc-tab-btn" id="tab-btn-reviews" onclick="switchTab('reviews', this)">Reviews</button>
                </div>

                <div id="bio" class="tab-section">
                    <h3 class="doc-section-header">About Dr. <?php echo explode(' ', $doctor['name'])[1] ?? 'Doctor'; ?></h3>
                    <div class="doc-text-block"><?php echo nl2br(htmlspecialchars($doctor['bio'])); ?></div>
                </div>

                <div id="qualifications" class="tab-section hidden">
                    <h3 class="doc-section-header">Professional Qualifications</h3>
                    <div class="doc-text-block"><?php echo nl2br(htmlspecialchars($doctor['qualifications'])); ?></div>
                </div>

                <div id="schedule" class="tab-section hidden">
                    <h3 class="doc-section-header">Clinic Hours</h3>
                    <div class="doc-text-block"><?php echo nl2br(htmlspecialchars($doctor['schedule'])); ?></div>
                </div>

                <div id="reviews" class="tab-section hidden">
                    <h3 class="doc-section-header">Patient Reviews (<?php echo $total_ratings; ?>)</h3>

                    <?php if ($total_ratings > 0): ?>
                        <?php foreach ($reviews as $review): ?>
                            <div class="doc-review-item">
                                <div class="doc-review-head">
                                    <span class="doc-reviewer"><?php echo htmlspecialchars($review['user_name']); ?></span>
                                    <div class="doc-star-display">
                                        <?php for ($k = 0; $k < $review['rating']; $k++) echo '<i class="fa-solid fa-star"></i>'; ?>
                                    </div>
                                </div>
                                <div class="doc-date"><?php echo date('M d, Y', strtotime($review['review_date'])); ?></div>
                                <p style="margin-top:10px; color:#555;"><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No reviews yet. Be the first!</p>
                    <?php endif; ?>

                    <div class="doc-form-box" id="write-review-section">
                        <h3>Write a Review</h3>
                        <?php if ($is_logged_in): ?>
                            <form action="submit_review.php" method="POST">
                                <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
                                <input type="hidden" name="user_name" value="<?php echo htmlspecialchars($current_user_name); ?>">

                                <div>
                                    <label style="font-weight:bold; display:block;">Your Rating</label>
                                    <div class="doc-rating-select">
                                        <input type="radio" id="star5" name="rating" value="5" required><label for="star5"><i class="fa-solid fa-star"></i></label>
                                        <input type="radio" id="star4" name="rating" value="4"><label for="star4"><i class="fa-solid fa-star"></i></label>
                                        <input type="radio" id="star3" name="rating" value="3"><label for="star3"><i class="fa-solid fa-star"></i></label>
                                        <input type="radio" id="star2" name="rating" value="2"><label for="star2"><i class="fa-solid fa-star"></i></label>
                                        <input type="radio" id="star1" name="rating" value="1"><label for="star1"><i class="fa-solid fa-star"></i></label>
                                    </div>
                                </div>

                                <label style="font-weight:bold;">Your Experience</label>
                                <textarea name="review_text" placeholder="Share your feedback..." required></textarea>
                                <button type="submit" class="doc-btn doc-btn-primary" style="width:auto; padding:10px 30px;">Submit Review</button>
                            </form>
                        <?php else: ?>
                            <p style="text-align:center;">Please <a href="login.php" style="color:#1e3a8a; font-weight:bold;">Log In</a> to write a review.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Standard Tab Switcher
        function switchTab(tabId, btnElement) {
            const wrapper = document.querySelector('.doc-profile-wrapper');

            // Hide all tab sections
            wrapper.querySelectorAll('.tab-section').forEach(el => el.classList.add('hidden'));

            // Reset all tab buttons
            wrapper.querySelectorAll('.doc-tab-btn').forEach(el => el.classList.remove('active'));

            // Show target tab and activate button
            wrapper.querySelector('#' + tabId).classList.remove('hidden');
            btnElement.classList.add('active');
        }

        // Function to Open Reviews Tab and Scroll (Linked to Sidebar Button)
        function goToReviews() {
            // 1. Find the Reviews Tab Button
            const reviewsBtn = document.getElementById('tab-btn-reviews');

            // 2. Trigger the tab switch logic
            if (reviewsBtn) {
                switchTab('reviews', reviewsBtn);
            }

            // 3. Scroll smoothly to the form
            const formSection = document.getElementById('write-review-section');
            if (formSection) {
                formSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    </script>

    <?php if (file_exists('footer.php')) {
        include 'footer.php';
    } ?>
</body>

</html>