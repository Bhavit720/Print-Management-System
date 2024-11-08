<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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
            cursor: pointer;
        }

        nav button:hover {
            background-color: white;
            color: black;
        }

        .content {
            padding: 2% 5%;
        }

        .section {
            margin: 10px 0;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 20px;
            color: white;
        }

        .section h2,
        .section p {
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

        .custom-button {
        background-color: #007bff; /* Blue background */
        color: white; /* White text */
        border: none; /* Remove border */
        padding: 12px 24px; /* Button padding */
        font-size: 16px; /* Increase font size */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
        transition: background-color 0.3s ease, box-shadow 0.3s ease; /* Smooth hover transition */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    .custom-button:hover {
        background-color: #0056b3; /* Darker blue on hover */
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15); /* Deeper shadow on hover */
    }

    .custom-button:active {
        background-color: #004085; /* Even darker blue when pressed */
        box-shadow: 0 3px 4px rgba(0, 0, 0, 0.1); /* Reduced shadow when pressed */
    }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="./logo.jpg" alt="logo" height="50px" width="50px">
        </div>
        <nav>
            <ul>
                <li class="dropdown">
                    <a id="signInBtn">Sign in</a>
                    <div class="dropdown-content" id="dropdownMenu">
                        <a href="./login_admin.php">Admin</a>
                        <a href="./login_user.php">User</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <section class="section">
            <h2>Empowering Your Print Environment</h2>
            <p>Our Print Management System is designed to help you streamline your printing operations, reduce waste, and improve productivity. Whether you're a small business or a large enterprise, our solutions are tailored to meet your needs.</p>
            <p>From managing print queues to securing sensitive documents, our software offers comprehensive tools to keep your printing environment under control.</p>
        </section>

        <section class="section features">
            <div class="feature-item">
                <h3>Print Management & Monitoring</h3>
                <p>Efficiently manage print jobs and monitor all printing activities to reduce waste, ensure security, and enhance productivity.</p>
            </div>
            <div class="feature-item">
                <h3>User Management & Access Control</h3>
                <p>Administer user accounts by adding, deleting, and managing login credentials, ensuring controlled access to the printing system.</p>
            </div>
            <div class="feature-item">
                <h3>User Printing Interface</h3>
                <p>Allow users to upload documents, send print requests, track print status, and manage their account balance seamlessly through an intuitive interface.</p>
            </div>
        </section>

        <section class="section">
            <h2>Why Choose Us?</h2>
            <p>With years of experience in the print management industry, we understand the challenges you face. Our solutions are built on a foundation of reliability, security, and efficiency, ensuring that your print environment is always optimized.</p>
            <p>Join thousands of businesses that trust us to manage their printing needs. Experience the difference with our comprehensive print management solutions.</p>
        </section>

        <section class="section">
    <h2>Get Started Today</h2>
    <p>Ready to take control of your print environment? Contact us to learn more about our solutions and find out how we can help you achieve your goals.</p>
    <div>
        <a href="./contant_sales.php">
            <button class="custom-button">Contact Sales</button>
        </a>
        <a href="./explore_products.php">
            <button class="custom-button" style="margin-left: 10px;">Explore Products</button>
        </a>
    </div>
</section>

    <footer>
        <div class="footer-content">
            <img src="./logo.jpg" alt="logo" height="50px" width="50px">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Contact Us</a>
        </div>
        <div class="footer-content">
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">LinkedIn</a>
        </div>
    </footer>

    <script>
        document.getElementById('signInBtn').addEventListener('click', function () {
            var dropdown = document.getElementById('dropdownMenu');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });

        window.addEventListener('click', function (e) {
            var dropdown = document.getElementById('dropdownMenu');
            if (!e.target.matches('#signInBtn') && !e.target.closest('.dropdown-content')) {
                dropdown.style.display = 'none';
            }
        });
    </script>
</body>

</html>
