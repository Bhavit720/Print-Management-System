<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit();
}

$userId = $_SESSION['user_id']; // Get user ID from session

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "print_management";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Static wallet balance for testing
$userBalance = 500.00; // Static wallet balance (for testing purposes)

// Fetch the print cost per page from the settings table
$sql = "SELECT print_cost FROM settings WHERE id = 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $settings = $result->fetch_assoc();
    $printCostPerPage = isset($settings['print_cost']) ? $settings['print_cost'] : 0;
} else {
    echo "Error: No settings found or database issue. Please ensure the settings table has valid data.";
    $printCostPerPage = 0; // Default value
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the number of pages from the form submission
    $numberOfPages = (int)$_POST['number_of_pages'];
    $totalCost = $numberOfPages * $printCostPerPage; // Calculate total cost for printing

    // Check if the user has sufficient balance
    if ($userBalance >= $totalCost) {
        // Deduct the total cost from the user's wallet (Static for now)
        $newBalance = $userBalance - $totalCost;

        // Simulate updating the wallet (no need to run a database update for testing)
        // $sql = "UPDATE wallets SET balance = ? WHERE user_id = ?";
        // $stmt = $conn->prepare($sql);
        // $stmt->bind_param("di", $newBalance, $userId);
        // $stmt->execute();
        // $stmt->close();

        echo "<script>alert('Your print job has been submitted successfully! Total cost: ₹" . number_format($totalCost, 2) . ". Remaining balance: ₹" . number_format($newBalance, 2) . "');</script>";

        // Proceed with file upload if balance is sufficient
        if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
            $fileName = $_FILES['document']['name'];
            $fileTmpPath = $_FILES['document']['tmp_name'];
            $uploadDir = 'uploads/';

            // Ensure 'uploads' directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generate a unique file path
            $filePath = $uploadDir . time() . "_" . basename($fileName);
            $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $allowedTypes = ['pdf', 'doc', 'docx', 'txt']; // Allowed file types

            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($fileTmpPath, $filePath)) {
                    // Insert print job details into the database
                    $sql = "INSERT INTO print_jobs (user_id, file_name, file_path, status) VALUES (?, ?, ?, 'pending')";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iss", $userId, $fileName, $filePath);

                    if ($stmt->execute()) {
                        // Successful print job submission
                    } else {
                        echo "Database error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Failed to upload file.";
                }
            } else {
                echo "Invalid file type. Only PDF, DOC, DOCX, and TXT files are allowed.";
            }
        } else {
            echo "No file uploaded or there was an error during the upload.";
        }
    } else {
        echo "<script>alert('Insufficient balance! You need ₹" . number_format($totalCost - $userBalance, 2) . " more to complete this print job.');</script>";
    }
}

$conn->close(); // Close the database connection
?>
