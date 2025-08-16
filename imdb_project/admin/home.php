<?php
session_start();
include '../includes/db_connection.php';
include '../includes/functions.php';

if (!isset($_SESSION['admin_id'])) {
    redirect('index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Home | MovieVerse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to right, #1a1a2e, #16213e);
            font-family: 'Poppins', sans-serif;
            color: white;
            text-align: center;
            padding: 50px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        .title {
            font-size: 3rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #f9a826;
            margin-bottom: 20px;
            animation: fadeIn 1s ease-in-out;
        }
        .subtitle {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 40px;
        }
        .cta {
            display: inline-block;
            background-color: #f9a826;
            color: #1a1a2e;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: uppercase;
            transition: 0.3s;
            text-decoration: none;
        }
        .cta:hover {
            background-color: #ffcc29;
            transform: scale(1.05);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="container">
        <h1 class="title">Welcome to MovieVerse</h1>
        <p class="subtitle">Your ultimate movie management system. Add, edit, and explore movies with ease.</p>
        <a href="view_movies.php" class="cta">Manage Movies</a>
    </div>
</body>
</html>
