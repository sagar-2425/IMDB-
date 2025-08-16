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

        nav {
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
        }

        nav .logo {
            font-size: 28px;
            font-weight: 700;
            color: #ffcc29;
            text-decoration: none;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 18px;
            transition: 0.3s ease-in-out;
        }

        nav a:hover {
            color: #ffcc29;
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

        .features {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            width: 250px;
            backdrop-filter: blur(10px);
            text-align: center;
            transition: all 0.3s ease-in-out;
        }

        .feature-card:hover {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.2);
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
            display: inline-block;
            margin-top: 20px;
        }

        .btn:hover {
            transform: scale(1.1);
            box-shadow: 0px 10px 25px rgba(255, 204, 41, 1);
        }

        footer {
            position: absolute;
            bottom: 0;
            color: white;
        }

        .social-icons {
            margin-top: 10px;
        }

        .social-icons a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 24px;
            transition: 0.3s ease-in-out;
        }

        .social-icons a:hover {
            color: #ffcc29;
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

            .features {
                flex-direction: column;
            }

            .feature-card {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <?php include '../includes/header.php'; ?>

    <nav>
        <a href="#" class="logo">IMDB</a>
        <div>
            <a href="/imdb_project/user/register.php">Register</a>
            <a href="/imdb_project/user/login.php">Login</a>
            <a href="/imdb_project/pages/about.php">About</a>
        </div>
    </nav>

    <h1>Welcome to IMDB</h1>
    <p>Explore your favorite movies and manage your watchlist and wishlist.</p>

    <div class="features">
        <div class="feature-card">
            <h3>Top Rated Movies</h3>
            <p>Discover the best-rated movies of all time.</p>
        </div>
        <div class="feature-card">
            <h3>Watchlist</h3>
            <p>Save movies to watch later.</p>
        </div>
        <div class="feature-card">
            <h3>Reviews & Ratings</h3>
            <p>See what others think before watching.</p>
        </div>
    </div>

    <a href="/imdb_project/user/login.php" class="btn">Explore Now</a>

    <!-- <footer>
        <p>&copy; 2025 IMDB | All Rights Reserved</p>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </footer> -->

</body>
</html>
