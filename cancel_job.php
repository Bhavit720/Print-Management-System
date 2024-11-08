<?php
session_start();

// Database connection (modify the values based on your setup)
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";      // Replace with your MySQL password
$dbname = "print_management";  // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a job_id is provided in the URL query parameter
if (isset($_GET['job_id'])) {
    $jobId = $_GET['job_id'];

    // Prepare the DELETE query to remove the job from the printing_jobs table
    $sql = "DELETE FROM print_jobs WHERE id = ?";  // Changed from 'job_id' to 'id'
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $jobId);

    if ($stmt->execute()) {
        // If the deletion is successful, redirect to the user's dashboard (or any other page)
        echo "Print job successfully canceled.";

        // Redirect the user to the dashboard page (adjust based on user/admin context)
        header("Location: user_dashboard.php");  // Adjust this based on your setup
        exit(); // Ensure the script stops after redirection
    } else {
        // If there was an error during deletion
        echo "Error: Unable to cancel print job.";
    }

    $stmt->close();
} else {
    // If no job_id was provided in the URL, handle the error
    echo "No print job specified for cancellation.";
}

// Close the database connection
$conn->close();
?>
