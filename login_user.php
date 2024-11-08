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

$emailError = $passwordError = $loginError = "";
$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Please enter a valid email address.";
    }

    // Validate password
    if (strlen($password) < 8) {
        $passwordError = "Password must be at least 8 characters long.";
    }

    // If there are no errors, proceed to check the credentials
    if (empty($emailError) && empty($passwordError)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $email_db, $hashed_password);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Correct password, set session variables
                $_SESSION['user_id'] = $id;
                $_SESSION['email'] = $email_db;

                // Redirect to user dashboard or homepage
                header("Location: user_dashboard.php");
                exit;
            } else {
                $loginError = "Incorrect password. Please try again.";
            }
        } else {
            $loginError = "No account found with this email.";
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
    <title>User Login Page</title>
    <style>
        /* Styles for the page */
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
            padding: 30px;
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
        .form input[type="password"] {
            margin-bottom: 25px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 12px;
            font-size: 16px;
        }
        .form input[type="submit"] {
            padding: 10px;
            border: none;
            border-radius: 15px;
            background-color: #ff69b4;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }
        .form input[type="submit"]:hover {
            background-color: #ff1493;
        }
        .form a {
            text-align: center;
            display: block;
            margin-top: 5px;
            color: #7193f3;
            font-size: 12px;
            text-decoration: none;
            transition: color 0.3s;
        }
        .form a:hover {
            color: #0d368f;
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
            font-size: 18px;
        }
        .tab.active {
            background-color: #a600d8;
            color: white;
            margin-right: 4px;
        }
        .tab.inactive {
            background-color: #ffffff;
            color: #a600d8;
            border: 1px solid #a600d8;
        }
    </style>
</head>
<body>
    <h1 style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Sans Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
        <center>User Login Form</center>
    </h1>
    <div class="container">
        <form class="form" id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="tab-container">
                <div class="tab active">Login</div>
                <div class="tab inactive">
                    <a href="./user_signup.php" style="text-decoration: none; color: inherit;">Sign Up</a>
                </div>
            </div>
            <label for="Email" class="label">Email Address</label>
            <input type="text" id="email" name="email" placeholder="Enter The Email" value="<?php echo htmlspecialchars($email); ?>" required>
            <span class="error"><?php echo $emailError; ?></span>

            <label for="password" class="label">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter The Password" required>
            <span class="error"><?php echo $passwordError; ?></span>

            <input type="submit" value="Login" class="submit">
            <a href="#" target="_top">Forgot Password?</a>
            <span class="error"><?php echo $loginError; ?></span>
        </form>
    </div>
</body>
</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login Page</title>
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
            padding: 30px;
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
            /* font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; */
            font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;

        }
        .form input[type="text"],
        .form input[type="password"] {
            margin-bottom: 25px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 12px;
            font-size: 16px;
        }
        .form input[type="submit"] {
            padding: 10px;
            border: none;
            border-radius: 15px;
            background-color: #ff69b4;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }
        .form input[type="submit"]:hover {
            background-color: #ff1493;
        }
        .form a {
            text-align: center;
            display: block;
            margin-top: 5px;
            color: #7193f3;
            font-size: 12px;
            text-decoration: none;
            transition: color 0.3s;
        }
        .form a:hover {
            color: #0d368f;
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
            font-size:18px;
        }
        .tab.active {
            background-color: #a600d8;
            color: white;
            margin-right:4px;
        }
        .tab.inactive {
            background-color: #ffffff;
            color: #a600d8;
            border: 1px solid #a600d8;
           
        }
    </style>

</head>
<body>
    <h1 style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;"><center>User Login Form</center></h1>
    <div class="container">
        <form class="form" id="loginForm" onsubmit="return validateLoginForm()">
            <div class="tab-container">
                <div class="tab active">Login</div>
                <div class="tab inactive"><a href="./user_signup.html" style="text-decoration: none; color: inherit;">Sign Up</a></div>
            </div>
            <label for="Email" class="label">Email Address</label>
            <input type="text" id="email" name="email" placeholder="Enter The Email" required>
            <span class="error" id="emailError"></span>

            <label for="password" class="label">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter The Password" required>
            <span class="error" id="passwordError"></span>

            <input type="submit" value="Login" class="submit">
            <a href="#" target="_top">Forget Password?</a>
        </form>
    </div>

    <script>
        function validateLoginForm() {
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;

            var emailError = document.getElementById('emailError');
            var passwordError = document.getElementById('passwordError');

            var isValid = true;

            // Email validation
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                emailError.textContent = 'Please enter a valid email address.';
                isValid = false;
            } else {
                emailError.textContent = '';
            }

            // Password validation
            if (password.length < 8) {
                passwordError.textContent = 'Password must be at least 8 characters long.';
                isValid = false;
            } else {
                passwordError.textContent = '';
            }

            return isValid;
        }
    </script>
</body>
</html> -->
