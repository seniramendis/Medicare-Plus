<?php
// doctor-profile.php

// Include the database connection file
include 'db_connect.php';

// Start the session
session_start();

// --- AUTHENTICATION CHECK ---
$is_logged_in = isset($_SESSION['user_id']);
$current_user_id = $is_logged_in ? $_SESSION['user_id'] : 0;
$current_user_name = $is_logged_in ? (isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Authenticated User') : 'Guest';
// ----------------------------

// 1. Get Doctor Slug from URL
$doctor_slug = $_GET['slug'] ?? null;
if (!$doctor_slug) {
    header('Location: find_doctor.php');
    exit;
}

// 2. Fetch Doctor Details 
$stmt = $conn->prepare("SELECT id, name, title, specialty, image_url, bio, qualifications, schedule FROM doctors WHERE slug = ?");
$stmt->bind_param("s", $doctor_slug);
$stmt->execute();
$doctor_result = $stmt->get_result();
$doctor = $doctor_result->fetch_assoc();
$stmt->close();

if (!$doctor) {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Doctor Profile Not Found</h1><p>The doctor profile you requested could not be found.</p>";
    exit;
}

$doctor_id = $doctor['id'];

// 3. Fetch Reviews and Calculate Average Rating
$reviews_query = $conn->prepare("SELECT user_name, rating, review_text, review_date FROM reviews WHERE doctor_id = ? ORDER BY review_date DESC");
$reviews_query->bind_param("i", $doctor_id);
$reviews_query->execute();
$reviews_result = $reviews_query->get_result();
$reviews = $reviews_result->fetch_all(MYSQLI_ASSOC);
$reviews_query->close();

$total_ratings = count($reviews);
$sum_ratings = array_sum(array_column($reviews, 'rating'));
$average_rating = $total_ratings > 0 ? round($sum_ratings / $total_ratings, 1) : 0.0;
$full_stars = floor($average_rating);
$has_half_star = ($average_rating - $full_stars) >= 0.5;

// Set Page Title
$pageTitle = $doctor['name'] . ' - Profile';
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
        /* --- GLOBAL STYLES --- */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
            color: #333;
        }

        /* --- LAYOUT --- */
        .profile-container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05);
            display: grid;
            grid-template-columns: 340px 1fr;
            /* Slightly wider sidebar for buttons */
            gap: 50px;
        }

        /* --- SIDEBAR --- */
        .doctor-sidebar {
            text-align: center;
            padding: 20px;
            border-right: 1px solid #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .doctor-sidebar img {
            width: 220px;
            height: 220px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            outline: 3px solid #1e3a8a;
            box-shadow: 0 10px 25px rgba(30, 58, 138, 0.15);
            margin-bottom: 25px;
        }

        .doctor-sidebar h2 {
            font-size: 1.8em;
            color: #1e3a8a;
            margin: 15px 0 5px 0;
            font-weight: 800;
        }

        .doctor-title {
            font-size: 1.2em;
            font-weight: 600;
            color: #57c95a;
            margin-bottom: 5px;
        }

        .doctor-specialty {
            font-size: 1em;
            color: #8898aa;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .profile-rating {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 30px;
            width: 100%;
            padding: 15px 0;
            border-top: 1px dashed #ddd;
            border-bottom: 1px dashed #ddd;
        }

        .profile-rating .fa-star,
        .profile-rating .fa-star-half-stroke {
            color: #f0ad4e;
        }

        /* --- SIDEBAR ACTION BUTTONS --- */

        /* 1. Primary: Book Appointment */
        .btn-book-appointment {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            /* Blue Gradient */
            color: #fff;
            padding: 15px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 50px;
            margin-bottom: 15px;
            font-size: 1.1em;
            box-shadow: 0 8px 20px rgba(30, 58, 138, 0.3);
            transition: all 0.3s ease;
            border: none;
        }

        .btn-book-appointment i {
            margin-right: 10px;
        }

        .btn-book-appointment:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(30, 58, 138, 0.4);
        }

        /* 2. Secondary: Write a Review (Ghost Button) */
        .btn-write-review-sidebar {
            display: inline-block;
            width: 100%;
            background-color: transparent;
            color: #666;
            border: 2px solid #e0e0e0;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-write-review-sidebar:hover {
            border-color: #57c95a;
            color: #57c95a;
            background-color: #f0fdf4;
        }


        /* --- MAIN CONTENT --- */
        .doctor-main-content {
            padding-top: 10px;
        }

        .doctor-main-content h1 {
            font-size: 2.5em;
            color: #1e3a8a;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #eef1f5;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .tab-content h3 {
            color: #1e3a8a;
            font-size: 1.5em;
            margin-top: 30px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .tab-content h3::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 24px;
            background-color: #57c95a;
            margin-right: 12px;
            border-radius: 3px;
        }

        /* --- TABS --- */
        .tabs {
            display: flex;
            margin-bottom: 30px;
            border-bottom: 1px solid #e0e0e0;
        }

        .tab-button {
            padding: 15px 25px;
            cursor: pointer;
            border: none;
            background-color: transparent;
            border-bottom: 3px solid transparent;
            font-size: 1.05em;
            font-weight: 600;
            color: #6c757d;
            transition: all 0.3s;
        }

        .tab-button:hover {
            color: #1e3a8a;
        }

        .tab-button.active {
            border-bottom: 3px solid #57c95a;
            color: #1e3a8a;
        }

        .tab-content {
            padding: 20px;
            border: 1px solid #f0f0f0;
            border-radius: 8px;
            background-color: #fff;
        }

        .hidden {
            display: none;
        }

        /* --- REVIEWS LIST --- */
        .review-card {
            border: 1px solid #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .review-author {
            font-weight: bold;
            color: #1e3a8a;
            font-size: 1.1em;
        }

        .review-date {
            font-size: 0.85em;
            color: #999;
        }

        .review-text {
            overflow-wrap: break-word;
            color: #555;
        }

        /* =======================================================
           PROFESSIONAL REVIEW AREA + PRETTY BUTTONS
           ======================================================= */
        #review-form-container {
            background-color: #ffffff;
            padding: 40px;
            border: 1px solid #eef1f5;
            border-radius: 16px;
            margin-top: 50px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
            position: relative;
        }

        #review-form-container h3 {
            margin-top: 0;
            color: #1e3a8a;
            border-left: 6px solid #57c95a;
            padding-left: 18px;
            font-size: 1.6em;
            margin-bottom: 25px;
            font-weight: 700;
        }

        /* --- PRETTY AUTH BUTTONS --- */
        .login-prompt-message {
            text-align: center;
            /* Center the prompt */
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 12px;
            border: 1px dashed #cbd5e1;
        }

        .prompt-text {
            display: block;
            font-size: 1.2em;
            color: #64748b;
            margin-bottom: 20px;
        }

        .auth-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 35px;
            color: #fff !important;
            text-decoration: none;
            font-weight: 600;
            border-radius: 50px;
            /* Pill Shape */
            font-size: 1em;
            margin: 0 10px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            min-width: 140px;
        }

        /* Log In - Green Gradient */
        .btn-login {
            background: linear-gradient(135deg, #57c95a 0%, #45a049 100%);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(76, 175, 80, 0.3);
        }

        /* Register - Blue Gradient */
        .btn-register {
            background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(30, 58, 138, 0.3);
        }

        /* Textarea */
        #review-form textarea {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            min-height: 120px;
            margin-bottom: 20px;
            font-family: inherit;
            font-size: 1em;
            transition: all 0.3s;
            background-color: #fcfcfc;
        }

        #review-form textarea:focus {
            outline: none;
            border-color: #57c95a;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(87, 201, 90, 0.1);
        }

        /* Star Rating */
        .star-rating-input {
            margin: 10px 0 20px 0;
            direction: rtl;
            unicode-bidi: bidi-override;
            display: inline-block;
        }

        .star-rating-input input[type="radio"] {
            display: none;
        }

        .star-rating-input label {
            font-size: 2.2em;
            color: #e2e8f0;
            cursor: pointer;
            padding: 0 2px;
            transition: color 0.2s, transform 0.2s;
            display: inline-block;
        }

        .star-rating-input label:hover {
            transform: scale(1.1);
        }

        .star-rating-input label:hover,
        .star-rating-input label:hover~label,
        .star-rating-input input[type="radio"]:checked~label {
            color: #f0ad4e;
        }

        .is-submitting {
            opacity: 0.6;
            pointer-events: none;
        }

        /* --- RESPONSIVE --- */
        @media screen and (max-width: 900px) {
            .profile-container {
                grid-template-columns: 1fr;
                gap: 30px;
                width: 95%;
                padding: 25px;
            }

            .doctor-sidebar {
                border-right: none;
                border-bottom: 1px solid #e0e0e0;
                padding-bottom: 30px;
            }

            .tabs {
                overflow-x: auto;
                white-space: nowrap;
            }

            .auth-btn {
                margin: 10px;
                width: 100%;
                max-width: 300px;
            }

            .btn-book-appointment {
                font-size: 1.2em;
                padding: 18px;
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="profile-container">
            <div class="doctor-sidebar">
                <img src="<?php echo htmlspecialchars($doctor['image_url']); ?>" alt="<?php echo htmlspecialchars($doctor['name']); ?>">

                <h2><?php echo htmlspecialchars($doctor['name']); ?></h2>
                <p class="doctor-title"><?php echo htmlspecialchars($doctor['title']); ?></p>
                <p class="doctor-specialty"><?php echo htmlspecialchars($doctor['specialty']); ?></p>

                <div class="profile-rating">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $full_stars) {
                            echo '<i class="fa-solid fa-star"></i>';
                        } elseif ($i == $full_stars + 1 && $has_half_star) {
                            echo '<i class="fa-solid fa-star-half-stroke"></i>';
                        } else {
                            echo '<i class="fa-regular fa-star"></i>';
                        }
                    }
                    ?>
                    <div style="margin-top: 5px; font-size: 0.9em;">
                        <?php echo number_format($average_rating, 1); ?> / 5.0 (<?php echo $total_ratings; ?> Reviews)
                    </div>
                </div>

                <a href="book_appointment.php?doctor_id=<?php echo $doctor_id; ?>" class="btn-book-appointment">
                    <i class="fa-regular fa-calendar-check"></i> Book Appointment
                </a>

                <a href="#review-form-container" class="btn-write-review-sidebar">
                    Write a Review
                </a>
            </div>

            <div class="doctor-main-content">
                <h1><?php echo htmlspecialchars($doctor['name']); ?></h1>

                <div class="tabs">
                    <button class="tab-button active" data-tab="bio">Biography</button>
                    <button class="tab-button" data-tab="qualifications">Qualifications</button>
                    <button class="tab-button" data-tab="schedule">Schedule</button>
                    <button class="tab-button" data-tab="reviews">Reviews</button>
                </div>

                <div id="bio" class="tab-content">
                    <h3>About Dr. <?php echo htmlspecialchars(explode(' ', $doctor['name'])[1] ?? 'Doctor'); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($doctor['bio'])); ?></p>
                </div>

                <div id="qualifications" class="tab-content hidden">
                    <h3>Degrees and Professional Experience</h3>
                    <p><?php echo nl2br(htmlspecialchars($doctor['qualifications'])); ?></p>
                </div>

                <div id="schedule" class="tab-content hidden">
                    <h3>Clinic Schedule</h3>
                    <p><?php echo nl2br(htmlspecialchars($doctor['schedule'])); ?></p>
                </div>

                <div id="reviews" class="tab-content hidden">
                    <h3>Patient Reviews (<span id="review-count-display"><?php echo $total_ratings; ?></span>)</h3>
                    <div id="reviews-list">
                        <?php if ($total_ratings > 0): ?>
                            <?php foreach ($reviews as $review): ?>
                                <div class="review-card">
                                    <div class="review-header">
                                        <span class="review-author"><?php echo htmlspecialchars($review['user_name']); ?></span>
                                        <div class="review-rating">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php echo ($i <= $review['rating']) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>'; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <p class="review-date"><?php echo date('F j, Y', strtotime($review['review_date'])); ?></p>
                                    <p class="review-text"><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p id="no-reviews-message">No reviews yet. Be the first to share your experience!</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div id="review-form-container">
                    <h3>Write a Review for Dr. <?php echo htmlspecialchars(explode(' ', $doctor['name'])[1] ?? 'Doctor'); ?></h3>

                    <?php if (!$is_logged_in): ?>
                        <div class="login-prompt-message" id="login-prompt">
                            <span class="prompt-text">Please <strong>Log In</strong> or <strong>Register</strong> to submit your review.</span>

                            <a href="login.php" class="auth-btn btn-login">
                                <i class="fa-solid fa-right-to-bracket" style="margin-right:8px;"></i> Log In
                            </a>
                            <a href="register.php" class="auth-btn btn-register">
                                <i class="fa-solid fa-user-plus" style="margin-right:8px;"></i> Register
                            </a>
                        </div>
                    <?php endif; ?>

                    <form id="review-form" <?php echo !$is_logged_in ? 'style="display: none;"' : ''; ?>>
                        <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
                        <input type="hidden" name="user_name" value="<?php echo htmlspecialchars($current_user_name); ?>">

                        <label style="font-weight: bold; display: block; margin-bottom: 5px;">Your Rating:</label>
                        <div class="star-rating-input" dir="rtl">
                            <input type="radio" id="star5" name="rating" value="5" required><label for="star5" title="5 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 star"><i class="fa-solid fa-star"></i></label>
                        </div>

                        <label for="review_text" style="font-weight: bold; display: block; margin-bottom: 5px;">Your Review:</label>
                        <textarea id="review_text" name="review_text" rows="4" placeholder="Share your experience with this doctor..." required></textarea>

                        <button type="submit" class="auth-btn btn-login" id="submitReviewButton">Submit Review</button>
                        <p id="review-submit-status" style="display: none; margin-top:15px; font-weight:bold;"></p>
                    </form>
                </div>

            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const is_logged_in = <?php echo json_encode($is_logged_in); ?>;
            const reviewForm = document.getElementById('review-form');
            const submitButton = document.getElementById('submitReviewButton');
            const statusMessage = document.getElementById('review-submit-status');
            const reviewsList = document.getElementById('reviews-list');
            const reviewCountDisplay = document.getElementById('review-count-display');
            const noReviewsMessage = document.getElementById('no-reviews-message');
            const loginPrompt = document.getElementById('login-prompt');

            // --- Tab Functionality ---
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.add('hidden'));
                    button.classList.add('active');
                    const targetId = button.getAttribute('data-tab');
                    document.getElementById(targetId).classList.remove('hidden');
                });
            });

            // Ensure state is correct on load
            if (!is_logged_in) {
                if (reviewForm) reviewForm.style.display = 'none';
                if (loginPrompt) loginPrompt.style.display = 'block';
            } else {
                if (reviewForm) reviewForm.style.display = 'block';
                if (loginPrompt) loginPrompt.style.display = 'none';
            }

            // --- Helper to Sanitize HTML ---
            function escapeHtml(text) {
                if (!text) return '';
                return text
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            // --- Review Submission Logic ---
            if (reviewForm) {
                reviewForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (!is_logged_in) {
                        statusMessage.style.display = 'block';
                        statusMessage.style.color = 'red';
                        statusMessage.textContent = 'Submission failed: Please Log In or Register.';
                        return;
                    }

                    const formData = new FormData(reviewForm);

                    statusMessage.style.display = 'block';
                    statusMessage.style.color = '#1e3a8a';
                    statusMessage.textContent = 'Submitting review...';

                    // Loading State
                    reviewForm.classList.add('is-submitting');

                    fetch('submit_review.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            reviewForm.classList.remove('is-submitting');

                            if (data.success) {
                                statusMessage.textContent = 'Review submitted successfully!';
                                statusMessage.style.color = '#57c95a';
                                reviewForm.reset();
                                document.querySelectorAll('.star-rating-input input[type="radio"]').forEach(radio => radio.checked = false);
                                addNewReviewToDOM(data.review);
                            } else {
                                statusMessage.textContent = 'Error: ' + data.message;
                                statusMessage.style.color = 'red';
                            }
                        })
                        .catch(error => {
                            reviewForm.classList.remove('is-submitting');
                            console.error('Fetch Error:', error);
                            statusMessage.textContent = 'An unexpected error occurred. Please try again.';
                            statusMessage.style.color = 'red';
                        });
                });
            }

            function addNewReviewToDOM(reviewData) {
                let starHtml = '';
                for (let i = 1; i <= 5; i++) {
                    starHtml += (i <= reviewData.rating) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>';
                }

                const safeName = escapeHtml(reviewData.user_name);
                const safeText = escapeHtml(reviewData.review_text).replace(/\n/g, '<br>');

                const newReviewHtml = `
                    <div class="review-card" style="animation: fadeIn 0.5s;">
                        <div class="review-header">
                            <span class="review-author">${safeName}</span>
                            <div class="review-rating">${starHtml}</div>
                        </div>
                        <p class="review-date">Reviewed on: ${new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })} (Just Now)</p>
                        <p class="review-text">${safeText}</p>
                    </div>
                `;

                reviewsList.insertAdjacentHTML('afterbegin', newReviewHtml);

                if (noReviewsMessage) {
                    noReviewsMessage.style.display = 'none';
                }

                if (reviewCountDisplay) {
                    let currentCount = parseInt(reviewCountDisplay.textContent) || 0;
                    reviewCountDisplay.textContent = currentCount + 1;
                }
            }
        });
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>