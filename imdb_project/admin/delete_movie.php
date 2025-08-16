<?php
session_start();
include '../includes/db_connection.php';
include '../includes/functions.php';

if (!isset($_SESSION['admin_id'])) {
    redirect('index.php');
}

if (!isset($_GET['id'])) {
    redirect('view_movies.php');
}

$movie_id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM movies WHERE id = ?");
$stmt->execute([$movie_id]);

redirect('view_movies.php');
?>