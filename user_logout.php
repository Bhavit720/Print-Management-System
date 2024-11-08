<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_logged_in'])) {
    // Unset all session variables related to user login
    unset($_SESSION['user_logged_in']);
    unset($_SESSION['user_id']);
    unset($_SESSION['user_username']);
    
    // Destroy the session completely (optional but recommended)
    session_destroy();
}

// Redirect to the user login page after logging out
header("Location: login_user.php");
exit();

