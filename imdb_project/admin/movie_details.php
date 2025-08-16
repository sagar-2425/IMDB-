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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $movie['name'] ?> | Movie Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to right, #0f0c29, #302b63, #24243e);
            font-family: 'Poppins', sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: left;
            padding: 20px;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            width: 90%;
            max-width: 1200px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 30px;
        }
        .movie-image {
            flex: 0 0 40%;
            display: flex;
            justify-content: center;
        }
        .movie-image img {
            width: 100%;
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            transition: 0.3s;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
        }
        .movie-image img:hover {
            transform: scale(1.05);
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.4);
        }
        .movie-info {
            flex: 0 0 60%;
        }
        .title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #f9a826;
            margin-bottom: 10px;
        }
        .movie-info p {
            font-size: 1.2rem;
            margin: 8px 0;
            padding: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
        }
        .movie-info strong {
            color: #ffcc29;
        }
        .btn {
            background-color: #f9a826;
            color: #1a1a2e;
            padding: 12px;
            width: 200px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #ffcc29;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="movie-image">
            <img src="<?= $movie['imageLink'] ?>" alt="<?= $movie['name'] ?>">
        </div>
        <div class="movie-info">
            <h1 class="title"><?= $movie['name'] ?></h1>
            <p><strong>Release Date:</strong> <?= $movie['release_date'] ?></p>
            <p><strong>Genre:</strong> <?= $movie['genre'] ?></p>
            <p><strong>Plot:</strong> <?= $movie['plot'] ?></p>
            <p><strong>Hero:</strong> <?= $movie['hero'] ?></p>
            <p><strong>Heroine:</strong> <?= $movie['heroine'] ?></p>
            <p><strong>Director:</strong> <?= $movie['director'] ?></p>
            <p><strong>Villain:</strong> <?= $movie['villain'] ?></p>
            <p><strong>Rating:</strong> ⭐ <?= $movie['rating'] ?> / 10</p>
            <a href="view_movies.php"><button class="btn">Back to Movies</button></a>
        </div>
    </div>
</body>
</html>
