<?php
session_start();
include '../includes/db_connection.php';
include '../includes/functions.php';

$showOTP = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    if ($username === 'guna@admin.in' && $password === 'Guna@1301') {
        $showOTP = true;
    } else {
        $error = "Invalid username or password.";
    }

    if (isset($_POST['otp'])) {
        $otp = sanitizeInput($_POST['otp']);
        if ($otp === '741963') {
            $_SESSION['admin_id'] = 1;
            redirect('home.php');
        } else {
            $error = "Invalid OTP.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | MovieVerse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to right, #1a1a2e, #16213e);
            font-family: 'Poppins', sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            width: 200px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }
        .title {
            font-size: 2rem;
            font-weight: 700;
            color: #f9a826;
        }
        .input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            color:black;
        }
        .btn {
            background-color: #f9a826;
            color: #1a1a2e;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn:hover {
            background-color: #ffcc29;
            transform: scale(1.05);
        }
        .otp-field {
            display: none;
            margin-top: 10px;
        }
        .error {
            color: #ff4d4d;
            font-size: 0.9rem;
        }
    </style>
    <script>
        function showOTPField() {
            document.querySelector('.otp-field').style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 class="title">Admin Login</h1>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="username" value="guna@admin.in" readonly class="input"><br>
            <input type="password" name="password" required class="input" placeholder="Enter Password"><br>
            <button type="submit" class="btn" onclick="showOTPField()">Login</button>
            
            <div class="otp-field">
                <input type="text" name="otp" required class="input" placeholder="Enter OTP"><br>
                <button type="submit" class="btn">Verify OTP</button>
            </div>
        </form>
    </div>
</body>
</html>
