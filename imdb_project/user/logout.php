<?php
// Include the functions file
include '../includes/functions.php';

// Start the session
session_start();

// Destroy the session
session_destroy();

// Redirect to the landing page
redirect('../index.php');
?>