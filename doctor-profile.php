<?php
// doctor-profile.php

// Include the database connection file
include 'db_connect.php';

// Start the session for user tracking
session_start();

// --- AUTHENTICATION CHECK ---
// Checks if the user is logged in using session variables set by login.php
$is_logged_in = isset($_SESSION['user_id']);
$current_user_id = $is_logged_in ? $_SESSION['user_id'] : 0;
$current_user_name = $is_logged_in ? $_SESSION['user_name'] : 'Guest';
// ----------------------------


// 1. Get Doctor Slug from URL
$doctor_slug = $_GET['slug'] ?? null;
if (!$doctor_slug) {
    // Redirect if no slug is provided
    header('Location: find_doctor.php');
    exit;
}

// 2. Fetch Doctor Details (using the fixed database schema)
$stmt = $conn->prepare("SELECT id, name, title, specialty, image_url, bio, qualifications, schedule FROM doctors WHERE slug = ?");
$stmt->bind_param("s", $doctor_slug);
$stmt->execute();
$doctor_result = $stmt->get_result();
$doctor = $doctor_result->fetch_assoc();
$stmt->close();

if (!$doctor) {
    // Show a 404 error if the doctor is not found
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Doctor Profile Not Found</h1><p>The doctor profile you requested could not be found.</p>";
    exit;
}

$doctor_id = $doctor['id'];

// 3. Fetch Reviews and Calculate Average Rating
// This query now relies on the corrected 'reviews' table structure
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
$pageKey = 'doctor_profile';
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
        /* --- ENHANCED PROFESSIONAL CSS --- */

        /* --- 1. GLOBAL BODY STYLES --- */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f0f3f5;
            line-height: 1.6;
            color: #333;
        }

        /* --- 2. LAYOUT & CONTAINER STYLES --- */
        .profile-container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 40px;
        }

        /* --- 3. DOCTOR SIDEBAR STYLES --- */
        .doctor-sidebar {
            text-align: center;
            padding: 20px;
            border-right: 1px solid #e0e0e0;
        }

        .doctor-sidebar img {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid #1e3a8a;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
            margin-bottom: 25px;
        }

        .doctor-sidebar h2 {
            font-size: 2em;
            color: #1e3a8a;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .doctor-title {
            font-size: 1.3em;
            font-weight: 600;
            color: #57c95a;
            margin-bottom: 5px;
        }

        .doctor-specialty {
            font-size: 1.1em;
            color: #777;
            margin-bottom: 25px;
        }

        .profile-rating {
            font-size: 1.3em;
            color: #555;
            margin-bottom: 30px;
            padding: 10px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        .profile-rating .fa-star,
        .profile-rating .fa-star-half-stroke {
            color: #f0ad4e;
        }


        /* --- 4. MAIN CONTENT STYLES --- */
        .doctor-main-content {
            padding-top: 10px;
        }

        .doctor-main-content h1 {
            font-size: 2.8em;
            color: #1e3a8a;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 4px solid #57c95a;
            font-weight: 700;
        }

        .doctor-main-content h3 {
            color: #1e3a8a;
            font-size: 1.6em;
            margin-top: 30px;
            margin-bottom: 15px;
            border-left: 5px solid #57c95a;
            padding-left: 15px;
            font-weight: 600;
        }

        /* --- 5. TABS STYLING --- */
        .tabs {
            display: flex;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
        }

        .tab-button {
            padding: 12px 25px;
            cursor: pointer;
            border: none;
            background-color: transparent;
            border-bottom: 3px solid transparent;
            font-size: 1.1em;
            font-weight: 600;
            color: #555;
            transition: all 0.3s;
        }

        .tab-button:hover {
            color: #1e3a8a;
        }

        .tab-button.active {
            border-bottom: 3px solid #1e3a8a;
            color: #1e3a8a;
            background-color: #f7f7f7;
            border-radius: 5px 5px 0 0;
        }

        .tab-content {
            padding: 15px 10px;
            border: 1px solid #eee;
            border-radius: 0 8px 8px 8px;
            background-color: #fcfcfc;
        }

        .tab-content p {
            padding: 0 10px;
        }

        /* --- 6. BUTTON STYLES --- */
        .button {
            display: inline-block;
            background-color: #57c95a;
            color: #fff;
            padding: 10px 25px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1em;
            border-radius: 50px;
            margin-top: 15px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        /* --- 7. REVIEWS STYLES --- */
        .review-card {
            border: 1px solid #e0e0e0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            background-color: #fcfcfc;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .review-author {
            font-weight: bold;
            color: #1e3a8a;
        }

        .review-date {
            font-size: 0.85em;
            color: #999;
        }

        .review-rating .fa-star,
        .review-rating .fa-star-half-stroke {
            color: #f0ad4e;
        }

        /* --- 8. REVIEW FORM / LOGIN PROMPT --- */
        #review-form-container {
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-top: 40px;
            background-color: #f8f9fa;
            text-align: left;
        }

        #review-form-container a.button {
            display: inline-block;
            padding: 6px 15px;
            margin: 5px 5px 5px 0;
            font-size: 0.9em;
            border-radius: 5px;
        }

        #review-form-container a.button.register {
            background-color: #1e3a8a;
        }

        #review-form-container a.button.register:hover {
            background-color: #152d6a;
        }

        .star-rating-input input[type="radio"] {
            display: none;
        }

        .star-rating-input label {
            font-size: 2em;
            color: #ccc;
            cursor: pointer;
            padding: 5px;
            transition: color 0.2s;
        }

        .star-rating-input label:hover,
        .star-rating-input label:hover~label,
        .star-rating-input input[type="radio"]:checked~label {
            color: #f0ad4e;
        }

        #review-form textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: vertical;
            min-height: 100px;
            margin-bottom: 15px;
        }

        #review-submit-status {
            margin-top: 10px;
            font-weight: bold;
        }

        /* --- 9. RESPONSIVE STYLES --- */
        @media screen and (max-width: 900px) {
            .profile-container {
                grid-template-columns: 1fr;
                gap: 20px;
                width: 95%;
                padding: 20px;
            }

            .doctor-sidebar {
                border-right: none;
                border-bottom: 1px solid #e0e0e0;
                padding-bottom: 20px;
            }

            .tabs {
                overflow-x: auto;
                white-space: nowrap;
            }

            .tab-button {
                flex-shrink: 0;
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
                    // Display calculated average rating
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
                    <span><?php echo number_format($average_rating, 1); ?> (<?php echo $total_ratings; ?> Reviews)</span>
                </div>

                <a href="#review-form-container" class="button">Submit a Review</a>
            </div>

            <div class="doctor-main-content">
                <h1><?php echo htmlspecialchars($doctor['name']); ?> Profile</h1>

                <div class="tabs">
                    <button class="tab-button active" data-tab="bio">Biography</button>
                    <button class="tab-button" data-tab="qualifications">Qualifications & Experience</button>
                    <button class="tab-button" data-tab="schedule">Schedule</button>
                    <button class="tab-button" data-tab="reviews">Patient Reviews</button>
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
                    <h3>Latest Patient Reviews (<span id="review-count-display"><?php echo $total_ratings; ?></span>)</h3>
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
                                    <p class="review-date">Reviewed on: <?php echo date('F j, Y', strtotime($review['review_date'])); ?></p>
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

                    <?php if ($is_logged_in): ?>
                        <form id="review-form">
                            <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
                            <input type="hidden" name="user_name" value="<?php echo htmlspecialchars($current_user_name); ?>">

                            <label>Your Rating:</label>
                            <div class="star-rating-input" dir="rtl">
                                <input type="radio" id="star5" name="rating" value="5" required><label for="star5" title="5 stars"><i class="fa-solid fa-star"></i></label>
                                <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 stars"><i class="fa-solid fa-star"></i></label>
                                <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 stars"><i class="fa-solid fa-star"></i></label>
                                <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 stars"><i class="fa-solid fa-star"></i></label>
                                <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 star"><i class="fa-solid fa-star"></i></label>
                            </div>

                            <label for="review_text">Your Review:</label>
                            <textarea id="review_text" name="review_text" rows="4" placeholder="Share your experience..." required></textarea>

                            <button type="submit" class="button">Submit Review</button>
                            <p id="review-submit-status" style="display: none;"></p>
                        </form>
                    <?php else: ?>
                        <p>You must be **logged in** to submit a review. Please
                            <a href="login.php" class="button">Log In</a> or
                            <a href="register.php" class="button register">Register</a>.
                        </p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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


            // --- Review Submission (AJAX) ---
            const reviewForm = document.getElementById('review-form');
            const statusMessage = document.getElementById('review-submit-status');
            const reviewsList = document.getElementById('reviews-list');
            const reviewCountDisplay = document.getElementById('review-count-display');
            const noReviewsMessage = document.getElementById('no-reviews-message');

            if (reviewForm) {
                reviewForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(reviewForm);

                    statusMessage.style.display = 'block';
                    statusMessage.style.color = '#1e3a8a';
                    statusMessage.textContent = 'Submitting review...';

                    fetch('submit_review.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                statusMessage.textContent = 'Review submitted successfully!';
                                statusMessage.style.color = '#57c95a';
                                reviewForm.reset();

                                // Re-check rating radio buttons (workaround for some browsers)
                                document.querySelectorAll('.star-rating-input input[type="radio"]').forEach(radio => radio.checked = false);

                                // Dynamically add the new review to the list
                                addNewReviewToDOM(data.review);
                            } else {
                                statusMessage.textContent = 'Error: ' + data.message;
                                statusMessage.style.color = 'red';
                            }
                        })
                        .catch(error => {
                            console.error('Fetch Error:', error);
                            statusMessage.textContent = 'An unexpected error occurred.';
                            statusMessage.style.color = 'red';
                        });
                });
            }

            function addNewReviewToDOM(reviewData) {
                let starHtml = '';
                for (let i = 1; i <= 5; i++) {
                    starHtml += (i <= reviewData.rating) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>';
                }

                const newReviewHtml = `
                    <div class="review-card">
                        <div class="review-header">
                            <span class="review-author">${reviewData.user_name}</span>
                            <div class="review-rating">${starHtml}</div>
                        </div>
                        <p class="review-date">Reviewed on: ${new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })} (Just Now)</p>
                        <p class="review-text">${reviewData.review_text.replace(/\n/g, '<br>')}</p>
                    </div>
                `;

                reviewsList.insertAdjacentHTML('afterbegin', newReviewHtml);

                if (noReviewsMessage) {
                    noReviewsMessage.style.display = 'none';
                }

                // Update the review count display
                let currentCount = parseInt(reviewCountDisplay.textContent);
                reviewCountDisplay.textContent = currentCount + 1;

                // Note: Updating the average star rating requires another AJAX call 
                // or a more complex calculation, which is left out for simplicity.
            }
        });
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>