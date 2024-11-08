<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "print_management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the user is logged in and their ID is stored in session
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch user's print jobs
$sql = "SELECT * FROM print_jobs WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$jobsResult = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f7fafc;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Sidebar -->
    <div class="flex">
        <aside class="w-64 bg-gray-800 text-white h-screen p-4">
            <h2 class="text-2xl font-semibold mb-6">User Dashboard</h2>
            <ul>
                <li class="mb-4">
                    <a href="user_dashboard.php" class="hover:bg-gray-700 p-2 block rounded">Dashboard</a>
                </li>
                <li class="mb-4">
                    <a href="user_logout.php" class="hover:bg-red-500 p-2 block rounded">Logout</a>
                </li>
            </ul>
        </aside>

        <!-- Main content -->
        <div class="flex-1 p-6">
            <h2 class="text-3xl font-semibold mb-6">Your Print Jobs</h2>
            <div class="bg-white p-6 shadow rounded-lg mb-6">
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Job ID</th>
                            <th class="px-4 py-2">File Name</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Date Submitted</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($job = $jobsResult->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2"><?= $job['id'] ?></td>
                            <td class="border px-4 py-2"><?= $job['file_name'] ?></td>
                            <td class="border px-4 py-2"><?= ucfirst($job['status']) ?></td>
                            <td class="border px-4 py-2"><?= date('Y-m-d H:i:s', strtotime($job['created_at'])) ?></td>
                            <td class="border px-4 py-2">
                                <?php if ($job['status'] == 'Pending'): ?>
                                    <button class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-400" onclick="cancelJob(<?= $job['id'] ?>)">Cancel</button>
                                <?php else: ?>
                                    <span class="text-gray-500">No action available</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if ($jobsResult->num_rows == 0): ?>
                        <tr>
                            <td colspan="5" class="border px-4 py-2 text-center">No print jobs found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Upload Document Form -->
            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-semibold mb-2">Upload a New Document</h3>
                <form action="upload_document.php" method="POST" enctype="multipart/form-data" class="mt-4">
                    <label for="document" class="block mb-2">Select Document:</label>
                    <input type="file" name="document" id="document" required class="mb-4">
                    
                    <label for="number_of_pages" class="block mb-2">Number of Pages:</label>
                    <input type="number" name="number_of_pages" id="number_of_pages" required min="1" class="mb-4">
                    
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-400">Submit Print Job</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function cancelJob(jobId) {
            if (confirm("Are you sure you want to cancel this print job?")) {
                // Redirect to cancel_job.php with job_id as a query parameter
                window.location.href = 'cancel_job.php?job_id=' + jobId;
            }
        }
    </script>

</body>
</html>

<?php
$conn->close();
?>
