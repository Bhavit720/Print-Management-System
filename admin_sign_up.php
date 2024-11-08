<?php
session_start(); // Start the session for user login tracking

// Database connection (replace with your actual DB credentials)
$host = 'localhost';
$dbname = 'print_management';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$emailError = $adminCodeError = $passwordError = $confirmPasswordError = $signupError = "";
$email = $adminCode = $password = $confirmPassword = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $adminCode = trim($_POST['adminCode']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Please enter a valid email address.";
    }

    // Validate admin code
    if ($adminCode !== '12345678') { // Replace 'expectedCode' with your actual expected admin code
        $adminCodeError = "Invalid Admin Code.";
    }

    // Validate password
    if (strlen($password) < 8) {
        $passwordError = "Password must be at least 8 characters long.";
    }

    // Validate confirm password
    if ($password !== $confirmPassword) {
        $confirmPasswordError = "Passwords do not match.";
    }

    // If there are no errors, proceed to register the admin
    if (empty($emailError) && empty($adminCodeError) && empty($passwordError) && empty($confirmPasswordError)) {
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT id FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $signupError = "Email is already registered.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new admin into the database
            $stmt = $conn->prepare("INSERT INTO admins (email, admin_code, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $adminCode, $hashed_password);

            if ($stmt->execute()) {
                // Redirect to login page or display success message
                header("Location: login_admin.php");
                exit;
            } else {
                $signupError = "Error in signing up. Please try again.";
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign Up Page</title>
    <style>
        body {
            background-image: url('photo.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
        }
        .form {
            height: auto;
            width: 300px;
            border: 2px solid pink;
            padding: 20px;
            box-shadow: 2px 6px pink;
            display: flex;
            flex-direction: column;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 0px solid rgba(255, 255, 255, 0.3);
        }
        .form label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            margin-left: 5px;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }
        .form input[type="text"],
        .form input[type="password"],
        .form input[type="email"] {
            margin-bottom: 25px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 12px;
            font-size: 16px;
        }
        .form input[type="submit"] {
            padding: 10px;
            border: none;
            border-radius: 12px;
            background-color: #ff69b4;
            color: white;
            font-size: 16px;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form input[type="submit"]:hover {
            background-color: #ff1493;
        }
        .form a {
            text-align: center;
            display: block;
            margin-top: 5px;
            color: #ff69b4;
            text-decoration: none;
            transition: color 0.3s;
        }
        .form a:hover {
            color: #ff1493;
        }
        .form .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1 style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
        <center>Admin Signup Form</center>
    </h1>
    <div class="container">
        <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter The Email" value="<?php echo htmlspecialchars($email); ?>" required>
            <span class="error"><?php echo $emailError; ?></span>

            <label for="adminCode">Admin Code</label>
            <input type="text" id="adminCode" name="adminCode" placeholder="Enter Admin Code" required>
            <span class="error"><?php echo $adminCodeError; ?></span>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter The Password" required>
            <span class="error"><?php echo $passwordError; ?></span>

            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm The Password" required>
            <span class="error"><?php echo $confirmPasswordError; ?></span>

            <input type="submit" value="Sign Up">
            <span class="error"><?php echo $signupError; ?></span>
            <a href="./login_admin.php">Already have an account? Login here.</a>
        </form>
    </div>
</body>
</html>


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign Up Page</title>
    <style>
        body {
            background-image: url('photo.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
        }
        .form {
            height: auto;
            width: 300px;
            border: 2px solid pink;
            padding: 20px;
            box-shadow: 2px 6px pink;
            display: flex;
            flex-direction: column;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 0px solid rgba(255, 255, 255, 0.3);
        }
        .form label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            margin-left:5px;
            font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;

        }
        .form input[type="text"],
        .form input[type="password"],
        .form input[type="email"] {
            margin-bottom: 25px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius:12px;
            font-size: 16px;
        }
        .form input[type="submit"] {
            padding: 10px;
            border: none;
            border-radius: 12px;
            background-color: #ff69b4;
            color: white;
            font-size: 16px;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form input[type="submit"]:hover {
            background-color: #ff1493;
        }
        .form a {
            text-align: center;
            display: block;
            margin-top: 5px;
            color: #ff69b4;
            text-decoration: none;
            transition: color 0.3s;
        }
        .form a:hover {
            color: #ff1493;
        }
        .form .error {
            color: red;
            font-size: 14px;
        }
        .tab-container {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .tab {
            width: 50%;
            padding: 10px;
            text-align: center;
            border-radius: 20px;
        }
        .tab.active {
            background-color: #a600d8;
            color: white;
            margin-left:4px;
        }
        .tab.inactive {
            background-color: #ffffff;
            color: #a600d8;
            border: 1px solid #a600d8;
        }
    </style>
</head>
<body>
    <h1 style="font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;"><center>Admin Signup Form</center></h1>
    <div class="container">
        <form class="form" id="signUpForm" onsubmit="return validateForm()">
            <!-- <h3><center>Sign Up Form</center></h3> -->
            <!-- <div class="tab-container">
                <div class="tab inactive"><a href="./login_admin.html " style="text-decoration: none; color: inherit;">Login</a></div>
                <div class="tab active">Sign Up</div>
            </div>
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter The Email" required>
            <span class="error" id="emailError"></span>

             <label for="adminCode">Admin Code</label>
            <input type="text" id="adminCode" name="adminCode" placeholder="Enter Admin Code" required>
            <span class="error" id="adminCodeError"></span> -->

            <!-- <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter The Password" required>
            <span class="error" id="passwordError"></span>

            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm The Password" required>
            <span class="error" id="confirmPasswordError"></span>

            <input type="submit" value="Sign Up">
        </form>
    </div>
 -->
    <!-- <script>
        function validateForm() {
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
            var adminCode = document.getElementById('adminCode').value;

            var emailError = document.getElementById('emailError');
            var passwordError = document.getElementById('passwordError');
            var confirmPasswordError = document.getElementById('confirmPasswordError');
            var adminCodeError = document.getElementById('adminCodeError');

            var isValid = true;

            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                emailError.textContent = 'Please enter a valid email address.';
                isValid = false;
            } else {
                emailError.textContent = '';
            }

            if (adminCode !== 'expectedCode') {
                adminCodeError.textContent = 'Invalid Admin Code.';
                isValid = false;
            } else {
                adminCodeError.textContent = '';
            }

            if (password.length < 8) {
                passwordError.textContent = 'Password must be at least 8 characters long.';
                isValid = false;
            } else {
                passwordError.textContent = '';
            }

            if (password !== confirmPassword) {
                confirmPasswordError.textContent = 'Passwords do not match.';
                isValid = false;
            } else {
                confirmPasswordError.textContent = '';
            }

            return isValid;
        }
    </script>
</body>
</html> --> 
