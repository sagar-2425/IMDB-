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
$user_id = $_SESSION['user_id'];

// Check if the movie is already in the watchlist
$stmt = $conn->prepare("SELECT id FROM watchlist WHERE user_id = ? AND movie_id = ?");
$stmt->execute([$user_id, $movie_id]);
$existing = $stmt->fetchColumn();

if ($existing) {
    echo json_encode(['success' => false, 'message' => 'Movie already in watchlist']);
    exit;
}

// Add the movie to the watchlist
$stmt = $conn->prepare("INSERT INTO watchlist (user_id, movie_id) VALUES (?, ?)");
$stmt->execute([$user_id, $movie_id]);

echo json_encode(['success' => true]);
?>