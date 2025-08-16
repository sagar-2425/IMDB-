<?php
session_start();
include '../includes/db_connection.php';
include '../includes/functions.php';

if (!isset($_SESSION['admin_id'])) {
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $imageLink = filter_var($_POST['imageLink'], FILTER_SANITIZE_URL);
    $release_date = sanitizeInput($_POST['release_date']);
    $genre = sanitizeInput($_POST['genre']);
    $plot = sanitizeInput($_POST['plot']);
    $hero = sanitizeInput($_POST['hero']);
    $heroine = sanitizeInput($_POST['heroine']);
    $director = sanitizeInput($_POST['director']);
    $villain = sanitizeInput($_POST['villain']);
    $rating = filter_var($_POST['rating'], FILTER_VALIDATE_FLOAT);

    if (!$rating || $rating < 0 || $rating > 10) {
        die("Invalid rating. Please enter a value between 0 and 10.");
    }

    try {
        $stmt = $conn->prepare("INSERT INTO movies 
            (name, imageLink, release_date, genre, plot, hero, heroine, director, villain, rating) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([$name, $imageLink, $release_date, $genre, $plot, $hero, $heroine, $director, $villain, $rating]);

        redirect('view_movies.php?success=Movie added successfully');
    } catch (PDOException $e) {
        die("Error adding movie: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Movie</title>
    <link rel="stylesheet" href="/imdb_project/assets/css/styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            color: white;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            font-size: 26px;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            display: block;
            margin-top: 10px;
            text-align: left;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: none;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 14px;
            transition: 0.3s ease;
        }

        input:focus, textarea:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.3);
        }

        textarea {
            resize: none;
            height: 100px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            background: #ff416c;
            color: white;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0px 5px 10px rgba(255, 65, 108, 0.4);
        }

        button:hover {
            background: #ff4b2b;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container">
        <h1>Add a New Movie 🎬</h1>
        <form method="post">
            <label>Movie Name:</label>
            <input type="text" name="name" required>

            <label>Image Link:</label>
            <input type="url" name="imageLink" required>

            <label>Release Date:</label>
            <input type="date" name="release_date" required>

            <label>Genre:</label>
            <input type="text" name="genre" required>

            <label>Plot:</label>
            <textarea name="plot" required></textarea>

            <label>Hero:</label>
            <input type="text" name="hero" required>

            <label>Heroine:</label>
            <input type="text" name="heroine" required>

            <label>Director:</label>
            <input type="text" name="director" required>

            <label>Villain:</label>
            <input type="text" name="villain" required>

            <label>Rating (0 - 10):</label>
            <input type="number" step="0.1" name="rating" min="0" max="10" required>

            <button type="submit">🎬 Add Movie</button>
        </form>
    </div>
</body>
</html>
