<?php
session_start();
include '../includes/db_connection.php';
include '../includes/functions.php';

if (!isset($_SESSION['admin_id'])) {
    redirect('index.php');
}

$stmt = $conn->query("SELECT * FROM movies");
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Movies</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            background: radial-gradient(circle at center, #1a1a2e, #16213e);
            font-family: 'Poppins', sans-serif;
            color: white;
            text-align: center;
            padding: 20px;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 700;
            color: #ffcc29;
            text-shadow: 2px 2px 10px rgba(255, 204, 41, 0.8);
        }

        .movie-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            justify-content: center;
            padding: 20px;
        }

        .movie-card {
            width: 300px;
            height: 500px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            cursor: pointer;
        }

        .movie-card:hover {
            transform: scale(1.07);
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(25px);
        }

        .image-container {
            width: 100%;
            height: 60%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #000;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .content-container {
            width: 100%;
            height: 40%;
            padding: 10px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .title-rating {
            display: flex;
            flex-direction: column; /* Display in a column */
            align-items: center;
            text-align: center;
        }

        .title-rating h3 {
            margin: 0;
            font-size: 18px;
            color: #ffcc29;
            text-shadow: 2px 2px 5px rgba(255, 204, 41, 0.7);
        }

        .title-rating .rating {
            color: gold;
            font-size: 16px;
            margin-top: 5px;
        }

        .buttons-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .buttons-container .full-length-button {
            width: 100%;
            padding: 8px;
            background-color: #ffcc29;
            color: #1a1a2e;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .buttons-container .full-length-button:hover {
            background-color: #f9a826;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
        }

        .buttons-container .action-buttons {
            display: flex;
            gap: 8px;
        }

        .buttons-container .action-buttons a {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
        }

        .buttons-container .action-buttons .edit-button {
            background-color: #4CAF50;
            color: white;
        }

        .buttons-container .action-buttons .edit-button:hover {
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
        }

        .buttons-container .action-buttons .delete-button {
            background-color: #f44336;
            color: white;
        }

        .buttons-container .action-buttons .delete-button:hover {
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h1>View Movies</h1>
    <div class="movie-list">
        <?php foreach ($movies as $movie): ?>
            <div class="movie-card">
                <div class="image-container">
                    <img src="<?= $movie['imageLink'] ?>" alt="<?= $movie['name'] ?>">
                </div>

                <div class="content-container">
                    <div class="title-rating">
                        <h3><?= $movie['name'] ?></h3>
                        <div class="rating">
                            <?php for ($i = 0; $i < $movie['rating']; $i++): ?>
                                ★
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div class="buttons-container">
                        <a href="movie_details.php?id=<?= $movie['id'] ?>" class="full-length-button">View Details</a>
                        <div class="action-buttons">
                            <a href="edit_movie.php?id=<?= $movie['id'] ?>" class="edit-button">Edit</a>
                            <a href="delete_movie.php?id=<?= $movie['id'] ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this movie?')">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
