<?php
include '../includes/db_connection.php';
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);
    $confirm_password = sanitizeInput($_POST['confirm_password']);

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (name, username, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $username, $hashed_password]);
        redirect('login.php');
    } else {
        $error = "Passwords do not match.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        /* Glassmorphism Effect */
        .registration-container {
            background: rgba(9, 3, 3, 0.34); /* Semi-transparent white */
            backdrop-filter: blur(10px); /* Blur effect */
            border: 1px solid rgba(255, 255, 255, 0.2); /* Light border */
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2); /* Soft shadow */
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: #ffeb3b; /* Yellow */
        }

        .error-message {
            color: #ff5252;
            margin-bottom: 1rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-size: 1rem;
            color: #fff;
            text-align: left;
        }

        input[type="text"],
        input[type="password"] {
            padding: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.3); /* Light border */
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1); /* Semi-transparent background */
            color: #fff;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #ffeb3b; /* Yellow */
        }

        button[type="submit"] {
            padding: 0.75rem;
            background: #ffeb3b; /* Yellow */
            color: #000;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button[type="submit"]:hover {
            background: #fdd835; /* Darker Yellow */
        }

        .login-link {
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .login-link a {
            color: #ffeb3b; /* Yellow */
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #fdd835; /* Darker Yellow */
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <h1>User Registration</h1>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
        <form method="post">
            <label>Name:</label>
            <input type="text" name="name" required>
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required>
            <button type="submit">Register</button>
        </form>
        <p class="login-link">Already have an account? <a href="/imdb_project/user/login.php">Login here</a></p>
    </div>
</body>
</html>