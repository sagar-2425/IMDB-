<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMDB | Movie Hub</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            font-family: 'Poppins', sans-serif;
            color: white;
            padding-top: 80px; /* To prevent content from hiding under navbar */
        }

        /* === FIXED NAVBAR DESIGN === */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        /* IMDB LOGO */
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #ffcc29;
            text-shadow: 2px 2px 8px rgba(255, 204, 41, 0.7);
            letter-spacing: 1px;
            transition: 0.3s;
            text-decoration: none;
        }

        .logo:hover {
            text-shadow: 0px 0px 15px rgba(255, 204, 41, 1);
        }

        /* NAV LINKS */
        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-links a {
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        /* Hover Effects */
        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: #ffcc29;
            box-shadow: 0px 4px 15px rgba(255, 204, 41, 0.5);
            transform: translateY(-3px);
        }

        /* === RESPONSIVE DESIGN === */
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                gap: 10px;
                padding: 10px 20px;
            }
            
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .nav-links a {
                font-size: 16px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav>
    <a href="/imdb_project/admin/home.php" class="logo">IMDB</a>
    
    <div class="nav-links">
        <?php if (isLoggedIn()): ?>
            <?php if (isset($_SESSION['admin_id'])): ?>
                <a href="/imdb_project/admin/add_movie.php">Add Movie</a>
                <a href="/imdb_project/admin/view_movies.php">View Movies</a>
                <a href="/imdb_project/admin/logout.php">Logout</a>
            <?php else: ?>
                <a href="/imdb_project/user/home.php">Home</a>
                <a href="/imdb_project/user/favorites.php">Watchlist</a>
                <a href="/imdb_project/user/wishlist.php">Wishlist</a>
                <a href="/imdb_project/user/logout.php">Logout</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="/imdb_project/pages/landing_page.php">Home</a>
            <a href="/imdb_project/user/register.php">Register</a>
            <a href="/imdb_project/user/login.php">Login</a>
            <a href="/imdb_project/pages/about.php">About</a>
        <?php endif; ?>
    </div>
</nav>
