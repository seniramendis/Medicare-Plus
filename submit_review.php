<?php
// submit_review.php
include 'db_connect.php';

session_start();

// Set the response header to JSON
header('Content-Type: application/json');

// --- AUTHENTICATION CHECK ---
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User is not logged in. You must log in to submit a review.']);
    exit;
}
// ----------------------------

// Check if form data is present and method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Sanitize and validate inputs
$doctor_id = filter_input(INPUT_POST, 'doctor_id', FILTER_VALIDATE_INT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
// Use session data for safety, not user-submitted data, but check the submitted value
$user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_SPECIAL_CHARS);
$rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
$review_text = trim(filter_input(INPUT_POST, 'review_text', FILTER_SANITIZE_SPECIAL_CHARS));

if (!$doctor_id || !$user_id || $user_id != $_SESSION['user_id'] || !$rating || $rating < 1 || $rating > 5 || empty($review_text)) {
    echo json_encode(['success' => false, 'message' => 'Invalid or missing data (Doctor ID, User ID, Rating, or Review Text).']);
    exit;
}

// Check if the user has already reviewed this doctor (optional but recommended)
$check_stmt = $conn->prepare("SELECT id FROM reviews WHERE doctor_id = ? AND user_id = ?");
$check_stmt->bind_param("ii", $doctor_id, $user_id);
$check_stmt->execute();
if ($check_stmt->get_result()->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'You have already submitted a review for this doctor.']);
    $check_stmt->close();
    exit;
}
$check_stmt->close();


// Prepare SQL statement to insert the review
$stmt = $conn->prepare("INSERT INTO reviews (doctor_id, user_id, user_name, rating, review_text) VALUES (?, ?, ?, ?, ?)");

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'SQL prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("iisds", $doctor_id, $user_id, $user_name, $rating, $review_text);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Review submitted successfully.',
        'review' => [
            'user_name' => $user_name,
            'rating' => $rating,
            'review_text' => $review_text
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error during insertion: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
