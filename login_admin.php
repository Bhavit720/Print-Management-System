<?php
// Start session
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "print_management"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before connecting to the database
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM admins WHERE email = ?"; // Changed to 'admins' table

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;

                            // Redirect admin to the admin dashboard page
                            header("location: admin_section.php");
                            exit();
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Page</title>
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
            width: 300px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 2px 6px 10px pink;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 0px solid rgba(255, 255, 255, 0.3);
            display: flex;
            flex-direction: column;
        }
        .form label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            margin-left: 5px;
            font-family: 'Lucida Sans', Geneva, Verdana, sans-serif;
        }
        .form input[type="text"],
        .form input[type="password"] {
            margin-bottom: 15px;
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
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; font-family: 'Lucida Sans', Geneva, Verdana, sans-serif;">Admin Login Form</h1>
    <div class="container">
        <form class="form" id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="email">Email Address</label>
            <input type="text" id="email" name="email" placeholder="Enter Your Email" required>
            <span class="error"><?php echo $email_err; ?></span>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Your Password" required>
            <span class="error"><?php echo $password_err; ?></span>

            <input type="submit" value="Login">
            <a href="#">Forgot Password?</a>
        </form>
    </div>
</body>
</html>



<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Page</title>
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
            width: 300px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 2px 6px 10px pink;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 0px solid rgba(255, 255, 255, 0.3);
            display: flex;
            flex-direction: column;
        }
        .form label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            margin-left: 5px;
            font-family: 'Lucida Sans', Geneva, Verdana, sans-serif;
        }
        .form input[type="text"],
        .form input[type="password"] {
            margin-bottom: 15px;
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
        .error {
            color: red;
            font-size: 14px;
        }
        .tab-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .tab {
            width: 45%;
            padding: 10px;
            text-align: center;
            border-radius: 20px;
            font-size: 18px;
        }
        .tab.active {
            background-color: #a600d8;
            color: white;
        }
        .tab.inactive {
            background-color: #ffffff;
            color: #a600d8;
            border: 1px solid #a600d8;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; font-family: 'Lucida Sans', Geneva, Verdana, sans-serif;">Admin Login Form</h1>
    <div class="container">
        <form class="form" id="loginForm" method="POST" action="login.php" onsubmit="return validateLoginForm()">
            <div class="tab-container">
                <div class="tab active">Login</div>
                <div class="tab inactive"><a href="admin_sign_up.php" style="text-decoration: none; color: inherit;">Sign Up</a></div>
            </div>

            <label for="email">Email Address</label>
            <input type="text" id="email" name="email" placeholder="Enter Your Email" required>
            <span class="error" id="emailError"></span>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Your Password" required>
            <span class="error" id="passwordError"></span>

            <input type="submit" value="Login">
            <a href="#">Forgot Password?</a>
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
