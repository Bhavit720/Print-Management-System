<?php
// Start the session
session_start();

// Check if the admin is logged in
if (isset($_SESSION['admin_logged_in'])) {
    // Unset all session variables related to admin login
    unset($_SESSION['admin_logged_in']);
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_username']);
    
    // Destroy the session completely (optional but recommended)
    session_destroy();
}

// Redirect to the admin login page after logging out
header("Location: login_admin.php");
exit();

