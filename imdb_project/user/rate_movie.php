<?php
session_start();
include '../includes/db_connection.php';
include '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$movie_id = $data['movie_id'];
$rating = $data['rating'];
$user_id = $_SESSION['user_id'];

// Check if the user has already rated this movie
$stmt = $conn->prepare("SELECT id FROM user_ratings WHERE user_id = ? AND movie_id = ?");
$stmt->execute([$user_id, $movie_id]);
$existing_rating = $stmt->fetchColumn();

if ($existing_rating) {
    // Update the existing rating
    $stmt = $conn->prepare("UPDATE user_ratings SET rating = ? WHERE id = ?");
    $stmt->execute([$rating, $existing_rating]);
} else {
    // Insert a new rating
    $stmt = $conn->prepare("INSERT INTO user_ratings (user_id, movie_id, rating) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $movie_id, $rating]);
}

// Calculate the new average rating for the movie
$stmt = $conn->prepare("SELECT AVG(rating) FROM user_ratings WHERE movie_id = ?");
$stmt->execute([$movie_id]);
$new_rating = $stmt->fetchColumn();

// Update the movie's rating in the movies table
$stmt = $conn->prepare("UPDATE movies SET rating = ? WHERE id = ?");
$stmt->execute([$new_rating, $movie_id]);

echo json_encode(['success' => true, 'new_rating' => $new_rating]);
?>