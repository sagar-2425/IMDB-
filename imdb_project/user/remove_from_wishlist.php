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

// Remove the movie from the wishlist
$stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND movie_id = ?");
$stmt->execute([$user_id, $movie_id]);

echo json_encode(['success' => true]);
?>