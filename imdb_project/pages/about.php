<?php
session_start();
include '../includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMDB Landing Page</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: white;
            text-align: center;
            background: url('https://wallpaperaccess.com/full/2564866.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h1 {
            font-size: 50px;
            font-weight: 700;
            text-shadow: 3px 3px 8px rgba(255, 204, 41, 0.7);
            margin-bottom: 10px;
        }

        p {
            font-size: 20px;
            margin-bottom: 30px;
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            border-radius: 8px;
            display: inline-block;
            backdrop-filter: blur(10px);
        }

        .login-options {
            display: flex;
            gap: 20px;
        }

        .btn {
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            background: linear-gradient(135deg, #ffcc29, #ff9900);
            box-shadow: 0px 5px 15px rgba(255, 204, 41, 0.7);
        }

        .btn:hover {
            transform: scale(1.1);
            box-shadow: 0px 10px 25px rgba(255, 204, 41, 1);
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 36px;
            }

            p {
                font-size: 16px;
            }

            .btn {
                font-size: 16px;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>

    <?php include '../includes/header.php'; ?>
    
    <h1>Welcome to IMDB</h1>
    <p>Explore your favorite movies and manage your watchlist and wishlist.</p>

    <div class="login-options">
        <a href="/imdb_project/user/login.php" class="btn">User Login</a>
        <a href="/imdb_project/admin/index.php" class="btn">Admin Login</a>
    </div>

</body>
</html>
