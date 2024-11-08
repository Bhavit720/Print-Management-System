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

// Handle job approval
if (isset($_POST['approve_job'])) {
    $jobId = $_POST['job_id'];
    $sql = "UPDATE print_jobs SET status='Approved' WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $jobId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    $stmt->close();
    exit;
}

// Handle job disapproval
if (isset($_POST['disapprove_job'])) {
    $jobId = $_POST['job_id'];
    $sql = "UPDATE print_jobs SET status='Disapproved' WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $jobId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    $stmt->close();
    exit;
}

// Handle user deletion via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Check if delete_user is set and valid user ID is provided
    if (isset($input['delete_user']) && isset($input['user_id'])) {
        $userId = $input['user_id'];

        // Prepare the DELETE query
        $sql = "DELETE FROM users WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            // Return a success response in JSON
            echo json_encode(['success' => true]);
        } else {
            // Return a failure response in JSON
            echo json_encode(['success' => false]);
        }

        $stmt->close();
        exit;
    }
}
// Fetch report data (example: total print jobs, approved, disapproved)
$totalJobsResult = $conn->query("SELECT COUNT(*) AS total_jobs FROM print_jobs");
$approvedJobsResult = $conn->query("SELECT COUNT(*) AS approved_jobs FROM print_jobs WHERE status='Approved'");
$disapprovedJobsResult = $conn->query("SELECT COUNT(*) AS disapproved_jobs FROM print_jobs WHERE status='Disapproved'");
$totalJobs = $totalJobsResult->fetch_assoc()['total_jobs'];
$approvedJobs = $approvedJobsResult->fetch_assoc()['approved_jobs'];
$disapprovedJobs = $disapprovedJobsResult->fetch_assoc()['disapproved_jobs'];

// Handle settings update
if (isset($_POST['update_settings'])) {
    $printCost = $_POST['print_cost'];
    $maxPages = $_POST['max_pages'];
    $sql = "UPDATE settings SET print_cost=?, max_pages=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $printCost, $maxPages);
    if ($stmt->execute()) {
        echo "<script>alert('Settings updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating settings!');</script>";
    }
    $stmt->close();
}

// Fetch current settings
$settingsResult = $conn->query("SELECT * FROM settings LIMIT 1");
if ($settingsResult->num_rows > 0) {
    $settings = $settingsResult->fetch_assoc();
} else {
    echo "No settings found!";
}

// Fetch users
$usersResult = $conn->query("SELECT * FROM users");

// Fetch print jobs
$jobsResult = $conn->query("SELECT * FROM print_jobs");

// Fetch feedback data
$feedbackResult = $conn->query("SELECT * FROM feedback");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-image: url('./photo.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            font-family: Arial, sans-serif;
        }
        .hidden { display: none; }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Top Navbar -->
    <nav class="bg-black bg-opacity-60 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-2xl">Admin Dashboard</div>
            <div>
                <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-400" onclick="window.location.href='logout_admin.php'">Logout</button>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-black bg-opacity-50 h-screen shadow-md text-white">
            <ul class="py-6">
                <li class="px-6 py-2 hover:bg-black hover:bg-opacity-70 hover:text-white cursor-pointer" onclick="showSection('dashboard')">Dashboard</li>
                <li class="px-6 py-2 hover:bg-black hover:bg-opacity-70 hover:text-white cursor-pointer" onclick="showSection('users')">Users</li>
                <li class="px-6 py-2 hover:bg-black hover:bg-opacity-70 hover:text-white cursor-pointer" onclick="showSection('printJobs')">Printing Jobs</li>
                <li class="px-6 py-2 hover:bg-black hover:bg-opacity-70 hover:text-white cursor-pointer" onclick="showSection('reports')">Reports</li>
                 <li class="px-6 py-2 hover:bg-black hover:bg-opacity-70 hover:text-white cursor-pointer" onclick="showSection('settings')">Settings</li>
                <!-- <li class="px-6 py-2 hover:bg-black hover:bg-opacity-70 hover:text-white cursor-pointer" onclick="showSection('feedback')">Feedback</li>  -->
            </ul>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            <!-- Dashboard Section -->
            <section id="dashboard" class="hidden">
                <h2 class="text-3xl font-semibold mb-4">Dashboard Overview</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-6 shadow rounded-lg">
                        <h3 class="text-xl font-medium">Total Users</h3>
                        <p class="text-2xl"><?= $usersResult->num_rows ?></p>
                    </div>
                    <div class="bg-white p-6 shadow rounded-lg">
                        <h3 class="text-xl font-medium">Active Print Jobs</h3>
                        <p class="text-2xl"><?= $jobsResult->num_rows ?></p>
                    </div>
                </div>
            </section>

   <!-- Users Management Section -->
   <section id="users" class="hidden">
                <h2 class="text-3xl font-semibold mb-4">Users Management</h2>
                <div class="bg-white p-6 shadow rounded-lg">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">User ID</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($user = $usersResult->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-100" id="user-row-<?= $user['id'] ?>">
                                <td class="border px-4 py-2"><?= $user['id'] ?></td>
                                <td class="border px-4 py-2"><?= $user['name'] ?></td>
                                <td class="border px-4 py-2"><?= $user['email'] ?></td>
                                <td class="border px-4 py-2">
                                    <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-400" onclick="deleteUser(<?= $user['id'] ?>)">Delete</button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Print Jobs Section -->
            <section id="printJobs" class="hidden">
                <h2 class="text-3xl font-semibold mb-4">Print Jobs</h2>
                <div class="bg-white p-6 shadow rounded-lg">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Job ID</th>
                                <th class="px-4 py-2">User ID</th>
                                <th class="px-4 py-2">File Name</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($job = $jobsResult->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-100" id="job-row-<?= $job['id'] ?>">
                                <td class="border px-4 py-2"><?= $job['id'] ?></td>
                                <td class="border px-4 py-2"><?= $job['user_id'] ?></td>
                                <td class="border px-4 py-2"><?= $job['file_name'] ?></td>
                                <td class="border px-4 py-2"><?= $job['status'] ?></td>
                                <td class="border px-4 py-2">
                                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400" onclick="approveJob(<?= $job['id'] ?>)">Approve</button>
                                    <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-400" onclick="disapproveJob(<?= $job['id'] ?>)">Disapprove</button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>

              <!-- Reports Section -->
              <section id="reports" class="hidden">
                <h2 class="text-3xl font-semibold mb-4">Reports</h2>
                <div class="bg-white p-6 shadow rounded-lg">
                    <p>Total Jobs: <?= $totalJobs ?></p>
                    <p>Approved Jobs: <?= $approvedJobs ?></p>
                    <p>Disapproved Jobs: <?= $disapprovedJobs ?></p>
                </div>
            </section>

            <!-- Settings Section -->
            <section id="settings" class="hidden">
                <h2 class="text-3xl font-semibold mb-4">Settings</h2>
                <form method="POST" action="">
                    <div class="bg-white p-6 shadow rounded-lg">
                        <div class="mb-4">
                            <label class="block text-gray-700">Print Cost:</label>
                            <input type="number" name="print_cost" value="<?= $settings['print_cost'] ?>" class="border rounded w-full px-4 py-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Max Pages Per User Per Day:</label>
                            <input type="number" name="max_pages" value="<?= $settings['max_pages'] ?>" class="border rounded w-full px-4 py-2">
                        </div>
                        <button type="submit" name="update_settings" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-400">Update Settings</button>
                    </div>
                </form>
            </section>





    <script>
        // Show section function
        function showSection(sectionId) {
            const sections = document.querySelectorAll('main > section');
            sections.forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById(sectionId).classList.remove('hidden');
        }

        function deleteUser(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            fetch('admin_section.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ delete_user: true, user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the user row from the table
                    document.getElementById('user-row-' + userId).remove();
                    alert('User deleted successfully!');
                } else {
                    alert('Failed to delete user.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the user.');
            });
        }
    }

        // Approve job function
        function approveJob(jobId) {
            if (confirm("Are you sure you want to approve this job?")) {
                const formData = new FormData();
                formData.append('approve_job', true);
                formData.append('job_id', jobId);
                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                  .then(data => {
                    if (data.success) {
                        alert('Job approved successfully!');
                        location.reload();
                    } else {
                        alert('Error approving job!');
                    }
                });
            }
        }

        // Disapprove job function
        function disapproveJob(jobId) {
            if (confirm("Are you sure you want to disapprove this job?")) {
                const formData = new FormData();
                formData.append('disapprove_job', true);
                formData.append('job_id', jobId);
                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                  .then(data => {
                    if (data.success) {
                        alert('Job disapproved successfully!');
                        location.reload();
                    } else {
                        alert('Error disapproving job!');
                    }
                });
            }
        }
    </script>

</body>
</html>
