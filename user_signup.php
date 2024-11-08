<?php
// Include the database connection
$servername = "localhost"; // or your server IP
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "print_management"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = $_POST['name']; // Get the name
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate input data
    $errors = [];

    // Check if name is valid
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    // Check if password is at least 8 characters
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // If there are no errors, proceed to insert the data
    if (empty($errors)) {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL query to insert the user data into the database
        $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"; // Include name in the query
        $stmt = $conn->prepare($query);

        // Bind the parameters and execute the statement
        if ($stmt->bind_param("sss", $name, $email, $hashedPassword)) {
            $stmt->execute();

            // Check if the insertion was successful
            if ($stmt->affected_rows > 0) {
                $successMessage = "Sign-up successful! You can now <a href='login_user.php'>login</a>.";
            } else {
                $errorMessage = "There was an error during sign-up. Please try again.";
            }

            $stmt->close();
        } else {
            $errorMessage = "There was an error in preparing the statement.";
        }
    } else {
        // Collect validation errors
        $errorMessage = implode('<br>', $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign Up Page</title>
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
        .form .success {
            color: green;
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
    <h1 style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;"><center>User Signup Form</center></h1>
    <div class="container">
        <form class="form" id="signUpForm" action="user_signup.php" method="POST">
            <div class="tab-container">
                <div class="tab inactive"><a href="./login_user.php" style="text-decoration: none; color: inherit;">Login</a></div>
                <div class="tab active">Sign Up</div>
            </div>

            <label for="name">Name</label> <!-- New name input -->
            <input type="text" id="name" name="name" placeholder="Enter Your Name" required>
            <span class="error" id="nameError"></span>

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter Your Email" required>
            <span class="error" id="emailError"></span>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Your Password" required>
            <span class="error" id="passwordError"></span>

            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Your Password" required>
            <span class="error" id="confirmPasswordError"></span>

            <input type="submit" value="Sign Up">

            <?php if (isset($errorMessage)): ?>
                <p class="error"><?= $errorMessage; ?></p>
            <?php elseif (isset($successMessage)): ?>
                <p class="success"><?= $successMessage; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign Up Page</title>
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
    <h1 style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;"><center>User Signup Form</center></h1>
    <div class="container">
        <form class="form" id="signUpForm" onsubmit="return validateForm()">
            <div class="tab-container">
                <div class="tab inactive"><a href="./login_user.html" style="text-decoration: none; color: inherit;">Login</a></div>
                <div class="tab active">Sign Up</div>
            </div>

            <!-- <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter The Username" required>
            <span class="error" id="usernameError"></span> -->

            <!-- <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter The Email" required>
            <span class="error" id="emailError"></span>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter The Password" required>
            <span class="error" id="passwordError"></span>

            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm The Password" required>
            <span class="error" id="confirmPasswordError"></span>

            <input type="submit" value="Sign Up">
        </form>
    </div>

    <script>
        function validateForm() {
            // var username = document.getElementById('username').value;
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;

            // var usernameError = document.getElementById('usernameError');
            var emailError = document.getElementById('emailError');
            var passwordError = document.getElementById('passwordError');
            var confirmPasswordError = document.getElementById('confirmPasswordError');

            var isValid = true; -->

            <!-- // Username validation
            // if (username.length < 5) {
            //     usernameError.textContent = 'Username must be at least 5 characters long.';
            //     isValid = false;
            // } else {
            //     usernameError.textContent = '';
            // }

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

            // Confirm Password validation
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
</html> --> -->
