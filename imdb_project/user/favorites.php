<?php
session_start();
include '../includes/db_connection.php';
include '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT movies.* FROM movies JOIN watchlist ON movies.id = watchlist.movie_id WHERE watchlist.user_id = ?");
$stmt->execute([$user_id]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_movie_id'])) {
    $remove_id = $_POST['remove_movie_id'];
    $remove_stmt = $conn->prepare("DELETE FROM watchlist WHERE user_id = ? AND movie_id = ?");
    $remove_stmt->execute([$user_id, $remove_id]);
    header("Location: favorites.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Favorites</title>
    <style>
               * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: url('background.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
        }

        h1 {
            margin: 20px 0;
            font-size: 36px;
            text-shadow: 2px 2px 10px rgba(255, 204, 41, 0.7);
        }

        .movie-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .movie-card {
            width: 300px;
            height: 400px;
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

        .content-container {
            width: 100%;
            height: 30%;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
        }

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

        .buttons-container {
            display: flex;
            justify-content: center;
        }

        .full-length-button, .remove-button {
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
            transition: all 0.3s ease-in-out;
        }

        .full-length-button:hover {
            background: rgba(0, 123, 255, 0.4);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.5);
        }

        .remove-button {
            background: rgba(220, 53, 69, 0.2);
        }

        .remove-button:hover {
            background: rgba(220, 53, 69, 0.4);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.5);
        }


    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h1>Your Watchlist</h1>
    <div class="movie-list">
        <?php if (!empty($favorites)): ?>
            <?php foreach ($favorites as $movie): ?>
                <div class="movie-card">
                    <div class="image-container">
                        <img src="<?= $movie['imageLink'] ?>" alt="<?= htmlspecialchars($movie['name']) ?>">
                    </div>
                    <div class="content-container">
                        <div class="title-rating">
                            <h3><?= htmlspecialchars($movie['name']) ?></h3>
                            <div class="rating">⭐ <?= $movie['rating'] ?>/10</div>
                        </div>
                        <div class="buttons-container">
                            <a href="movie_details.php?id=<?= $movie['id'] ?>" class="full-length-button">View Full Length</a>
                            <form method="POST" style="margin: 0; display:flex; gap: 2px;">
                                <input type="hidden" name="remove_movie_id" value="<?= $movie['id'] ?>">
                                <button type="submit" class="remove-button">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No favorite movies yet. <a href="movies.php" class="full-length-button">Browse Movies</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
