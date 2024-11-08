<?php
// Initialize success message
$successMessage = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $company = htmlspecialchars($_POST['company']);
    $message = htmlspecialchars($_POST['message']);

    // Perform validation or send an email here
    // For demonstration, we'll just simulate a success message
    $successMessage = "Your message has been sent successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Contact our sales team for inquiries about the Print Management System.">
    <title>Contact Sales - Print Management System</title>
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
            color: white;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1% 3%;
            background-color: rgba(0, 0, 0, 0.7);
            border-bottom: 3px solid #00AEEF;
        }

        .logo img {
            margin-left: 10px;
            border-radius: 20%;
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav ul {
            display: flex;
            align-items: center;
        }

        nav ul li {
            margin-right: 20px;
            list-style: none;
            position: relative;
        }

        nav ul li a {
            text-decoration: none;
            font-size: 18px;
            color: white;
            cursor: pointer;
        }

        nav ul li a:hover {
            color: #00AEEF;
            transition: color 0.3s;
        }

        nav button {
            height: 40px;
            font-size: 18px;
            border-radius: 10px;
            background-color: #00AEEF;
            border: none;
            color: white;
            margin-left: 20px;
        }

        nav button:hover {
            background-color: white;
            color: black;
            cursor: pointer;
        }

        .content {
            padding: 2% 5%;
        }

        .section {
            margin: 2px 0;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 20px;
            color: white;
        }

        footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1% 3%;
            background-color: rgba(0, 0, 0, 0.7);
            border-top: 3px solid #00AEEF;
        }

        .footer-content {
            display: flex;
            align-items: center;
        }

        .footer-content img {
            margin-right: 10px;
            border-radius: 50%;
        }

        .footer-content a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
        }

        .footer-content a:hover {
            color: #00AEEF;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }

        form label {
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
            color: white;
        }

        form input,
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
            outline: none;
            background-color: #fff;
            color: #333;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #00AEEF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: white;
            color: black;
        }

        #success-message {
            display: <?php echo $successMessage ? 'block' : 'none'; ?>;
            text-align: center;
            margin-top: 20px;
            color: green;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="./logo.jpg" alt="Print Management Logo" width="60" height="60">
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Features</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <button>Get Started</button>
        </nav>
    </header>

    <main class="content">
        <section class="section">
            <h2>Contact Sales</h2>
            <p>If you have any questions or inquiries, feel free to contact our sales team by filling out the form below:</p>

            <form id="contact-form" method="POST" action="">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>

                <label for="company">Company Name:</label>
                <input type="text" id="company" name="company">

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Submit</button>
            </form>

            <div id="success-message"><?php echo $successMessage; ?></div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <img src="./logo.jpg" alt="Footer Logo" width="40" height="40">
            <a href="#">Terms</a>
            <a href="#">Privacy</a>
        </div>
        <p>&copy; 2024 Print Management System</p>
    </footer>
</body>
</html>


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Sales - Print Management System</title>
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
            color: white;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1% 3%;
            background-color: rgba(0, 0, 0, 0.7);
            border-bottom: 3px solid #00AEEF;
        }

        .logo img {
            margin-left: 10px;
            border-radius: 20%;
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav ul {
            display: flex;
            align-items: center;
        }

        nav ul li {
            margin-right: 20px;
            list-style: none;
            position: relative;
        }

        nav ul li a {
            text-decoration: none;
            font-size: 18px;
            color: white;
            cursor: pointer;
        }

        nav ul li a:hover {
            color: #00AEEF;
            transition: color 0.3s;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: rgba(0, 0, 0, 0.8);
            min-width: 120px;
            border-radius: 10px;
            z-index: 1;
            top: 40px;
        }

        .dropdown-content a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            border-radius: 10px;
        }

        .dropdown-content a:hover {
            background-color: #00AEEF;
            color: black;
        }

        nav button {
            height: 40px;
            font-size: 18px;
            border-radius: 10px;
            background-color: #00AEEF;
            border: none;
            color: white;
            margin-left: 20px;
        }

        nav button:hover {
            background-color: white;
            color: black;
            cursor: pointer;
        }

        .content {
            padding: 2% 5%;
        }

        .section {
            margin: 2px 0;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 20px;
            color: white;
        }

        .features {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .feature-item {
            width: 30%;
            margin: 10px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            text-align: center;
        }

        footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1% 3%;
            background-color: rgba(0, 0, 0, 0.7);
            border-top: 3px solid #00AEEF;
        }

        .footer-content {
            display: flex;
            align-items: center;
        }

        .footer-content img {
            margin-right: 10px;
            border-radius: 50%;
        }

        .footer-content a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
        }

        .footer-content a:hover {
            color: #00AEEF;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }

        form label {
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
            color: white;
        }

        form input,
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
            outline: none;
            background-color: #fff;
            color: #333;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #00AEEF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: white;
            color: black;
        }

        #success-message {
            display: none;
            text-align: center;
            margin-top: 20px;
            color: green;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="./logo.jpg" alt="Print Management Logo" width="60" height="60">
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Features</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <button>Get Started</button>
        </nav>
    </header>

    <div class="content">
        <section class="section">
            <h2>Contact Sales</h2>
            <p>If you have any questions or inquiries, feel free to contact our sales team by filling out the form below:</p>

            <form id="contact-form" onsubmit="return validateForm()">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>

                <label for="company">Company Name:</label>
                <input type="text" id="company" name="company">

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Submit</button>
            </form>

            <div id="success-message">Your message has been sent successfully!</div>
        </section>
    </div>

    <footer>
        <div class="footer-content">
            <img src="./logo.jpg" alt="Footer Logo" width="40" height="40">
            <a href="#">Terms</a>
            <a href="#">Privacy</a>
        </div>
        <p>&copy; 2024 Print Management System</p>
    </footer>

    <script>
        function validateForm() {
            var name = document.getElementById('name').value.trim();
            var email = document.getElementById('email').value.trim();
            var message = document.getElementById('message').value.trim();

            if (name === '' || email === '' || message === '') {
                alert('Please fill out all required fields.');
                return false;
            }

            // Show success message
            document.getElementById('contact-form').style.display = 'none';
            document.getElementById('success-message').style.display = 'block';

            return false; // Prevent page reload
        }
    </script>
</body>
</html> -->
