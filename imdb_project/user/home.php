<?php
session_start();
include '../includes/db_connection.php';
include '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

$stmt = $conn->query("SELECT * FROM movies");
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    <style>
        /* Background */
        body {
            background: url('background.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
            color: white;
        }

        /* Main movie list container */
        .movie-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        /* Glassmorphic Movie Card */
        .movie-card {
            width: 300px;
            height: 500px;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .movie-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
        }

        /* Image Container */
        .image-container {
            width: 100%;
            height: 70%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Content Container */
        .content-container {
            width: 100%;
            height: 30%;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
        }

        /* Title and rating section */
        .title-rating {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .title-rating h3 {
            margin: 0;
            font-size: 18px;
            color: white;
        }

        .title-rating .rating {
            color: gold;
            font-size: 16px;
        }

        /* Button styling */
        .buttons-container {
            display: flex;
            justify-content: center;
        }

        .buttons-container .full-length-button {
            width: 100%;
            padding: 8px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 6px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease, border 0.3s ease;
        }

        .buttons-container .full-length-button:hover {
            background: rgba(255, 255, 255, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <h1>Welcome to IMDB</h1>

    <div class="movie-list">
        <?php foreach ($movies as $movie): ?>
            <div class="movie-card">
                <!-- Image div -->
                <div class="image-container">
                    <img src="<?= htmlspecialchars($movie['imageLink']) ?>" alt="<?= htmlspecialchars($movie['name']) ?>">
                </div>

                <!-- Content div -->
                <div class="content-container">
                    <!-- Title and rating -->
                    <div class="title-rating">
                        <h3><?= htmlspecialchars($movie['name']) ?></h3>
                        <div class="rating">Rating: <?= htmlspecialchars($movie['rating']) ?></div>
                    </div>

                    <!-- Button -->
                    <div class="buttons-container">
                        <a href="movie_details.php?id=<?= $movie['id'] ?>" class="full-length-button">View Full Length</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
