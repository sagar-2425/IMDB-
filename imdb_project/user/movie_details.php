<?php
session_start();
include '../includes/db_connection.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

if (!isset($_GET['id'])) {
    redirect('home.php');
}

$movie_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$movie_id]);
$movie = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$movie) {
    redirect('home.php');
}

// Fetch the user's rating for this movie (if any)
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT rating FROM user_ratings WHERE user_id = ? AND movie_id = ?");
$stmt->execute([$user_id, $movie_id]);
$user_rating = $stmt->fetchColumn();

// Check if the movie is in the user's watchlist
$stmt = $conn->prepare("SELECT id FROM watchlist WHERE user_id = ? AND movie_id = ?");
$stmt->execute([$user_id, $movie_id]);
$in_watchlist = $stmt->fetchColumn();

// Check if the movie is in the user's wishlist
$stmt = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND movie_id = ?");
$stmt->execute([$user_id, $movie_id]);
$in_wishlist = $stmt->fetchColumn();
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
            margin-top: 280px;
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
        .stars {
            font-size: 30px;
            cursor: pointer;
            margin-top: 20px;
        }
        .stars .star {
            color: #ddd;
            transition: color 0.3s;
        }
        .stars .star.active {
            color: gold;
        }
        .rate-button {
            display: none;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .actions {
            margin-top: 20px;
        }
        .actions button {
            margin: 5px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .actions button.watchlist {
            background-color: #2196F3;
            color: white;
        }
        .actions button.wishlist {
            background-color: #FF9800;
            color: white;
        }
        .actions button:hover {
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
            <div class="stars" data-movie-id="<?= $movie['id'] ?>">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span class="star <?= ($i <= $user_rating) ? 'active' : '' ?>" data-rating="<?= $i ?>">★</span>
                <?php endfor; ?>
            </div>
            <button class="rate-button" onclick="submitRating()">Rate</button>
            <div class="actions">
                <button class="watchlist" onclick="toggleWatchlist()">
                    <?= $in_watchlist ? 'Remove from Watchlist' : 'Add to Watchlist' ?>
                </button>
                <button class="wishlist" onclick="toggleWishlist()">
                    <?= $in_wishlist ? 'Remove from Wishlist' : 'Add to Wishlist' ?>
                </button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.stars .star');
            const rateButton = document.querySelector('.rate-button');
            let selectedRating = 0;

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    selectedRating = this.dataset.rating;

                    // Update the stars UI
                    stars.forEach((s, index) => {
                        if (index < selectedRating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });

                    // Show the "Rate" button
                    rateButton.style.display = 'block';
                });
            });

            window.submitRating = function () {
                const movieId = document.querySelector('.stars').dataset.movieId;

                // Send the rating to the server
                fetch('/imdb_project/user/rate_movie.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ movie_id: movieId, rating: selectedRating })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the movie rating displayed
                        document.querySelector('.movie-info p:nth-child(9)').textContent = `Rating: ⭐ ${data.new_rating} / 10`;

                        // Hide the "Rate" button after submission
                        rateButton.style.display = 'none';
                    } else {
                        alert('Failed to update rating.');
                    }
                });
            };

            window.toggleWatchlist = function () {
                const movieId = document.querySelector('.stars').dataset.movieId;
                const watchlistButton = document.querySelector('.watchlist');
                const isInWatchlist = watchlistButton.textContent.includes('Remove');

                // Toggle between adding and removing from watchlist
                fetch(`/imdb_project/user/${isInWatchlist ? 'remove_from_watchlist.php' : 'add_to_watchlist.php'}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ movie_id: movieId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the button text
                        watchlistButton.textContent = isInWatchlist ? 'Add to Watchlist' : 'Remove from Watchlist';
                        alert(isInWatchlist ? 'Removed from Watchlist!' : 'Added to Watchlist!');
                    } else {
                        alert('Failed to update watchlist.');
                    }
                });
            };

            window.toggleWishlist = function () {
                const movieId = document.querySelector('.stars').dataset.movieId;
                const wishlistButton = document.querySelector('.wishlist');
                const isInWishlist = wishlistButton.textContent.includes('Remove');

                // Toggle between adding and removing from wishlist
                fetch(`/imdb_project/user/${isInWishlist ? 'remove_from_wishlist.php' : 'add_to_wishlist.php'}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ movie_id: movieId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the button text
                        wishlistButton.textContent = isInWishlist ? 'Add to Wishlist' : 'Remove from Wishlist';
                        alert(isInWishlist ? 'Removed from Wishlist!' : 'Added to Wishlist!');
                    } else {
                        alert('Failed to update wishlist.');
                    }
                });
            };
        });
    </script>
</body>
</html>