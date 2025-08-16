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
$stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$movie_id]);
$movie = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$movie) {
    redirect('view_movies.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $imageLink = sanitizeInput($_POST['imageLink']);
    $release_date = sanitizeInput($_POST['release_date']);
    $genre = sanitizeInput($_POST['genre']);
    $plot = sanitizeInput($_POST['plot']);
    $hero = sanitizeInput($_POST['hero']);
    $heroine = sanitizeInput($_POST['heroine']);
    $director = sanitizeInput($_POST['director']);
    $villain = sanitizeInput($_POST['villain']);
    $rating = sanitizeInput($_POST['rating']);

    $stmt = $conn->prepare("UPDATE movies SET name = ?, imageLink = ?, release_date = ?, genre = ?, plot = ?, hero = ?, heroine = ?, director = ?, villain = ?, rating = ? WHERE id = ?");
    $stmt->execute([$name, $imageLink, $release_date, $genre, $plot, $hero, $heroine, $director, $villain, $rating, $movie_id]);

    redirect('view_movies.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Movie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white flex flex-col items-center min-h-screen">

    <?php include '../includes/header.php'; ?>

    <h1 class="text-4xl font-bold text-yellow-400 mt-10">Edit Movie</h1>

    <div class="bg-gray-800 shadow-lg rounded-xl p-8 mt-6 w-full max-w-lg text-center">
        <img src="<?= $movie['imageLink'] ?>" alt="<?= $movie['name'] ?>" class="w-full rounded-lg border-4 border-yellow-400 shadow-md">
        <h3 class="text-2xl font-semibold mt-4"><?= $movie['name'] ?></h3>

        <div class="flex justify-center mt-2">
            <?php for ($i = 0; $i < $movie['rating']; $i++): ?>
                <span class="text-yellow-400 text-xl">★</span>
            <?php endfor; ?>
        </div>

        <form method="post" class="mt-6 space-y-4">
            <label class="block text-left font-medium">Movie Name:</label>
            <input type="text" name="name" value="<?= $movie['name'] ?>" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">

            <label class="block text-left font-medium">Image Link:</label>
            <input type="text" name="imageLink" value="<?= $movie['imageLink'] ?>" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md">

            <label class="block text-left font-medium">Release Date:</label>
            <input type="date" name="release_date" value="<?= $movie['release_date'] ?>" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md">

            <label class="block text-left font-medium">Genre:</label>
            <input type="text" name="genre" value="<?= $movie['genre'] ?>" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md">

            <label class="block text-left font-medium">Plot:</label>
            <textarea name="plot" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md"><?= $movie['plot'] ?></textarea>

            <label class="block text-left font-medium">Hero:</label>
            <input type="text" name="hero" value="<?= $movie['hero'] ?>" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md">

            <label class="block text-left font-medium">Heroine:</label>
            <input type="text" name="heroine" value="<?= $movie['heroine'] ?>" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md">

            <label class="block text-left font-medium">Director:</label>
            <input type="text" name="director" value="<?= $movie['director'] ?>" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md">

            <label class="block text-left font-medium">Villain:</label>
            <input type="text" name="villain" value="<?= $movie['villain'] ?>" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md">

            <label class="block text-left font-medium">Rating:</label>
            <input type="number" step="0.1" name="rating" value="<?= $movie['rating'] ?>" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md">

            <div class="flex justify-between mt-6">
                <button type="submit" class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded-md transition">Update Movie</button>
                <a href="delete_movie.php?id=<?= $movie['id'] ?>" class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white font-bold rounded-md transition" onclick="return confirm('Are you sure you want to delete this movie?')">Delete Movie</a>
            </div>
        </form>
    </div>
</body>
</html>
