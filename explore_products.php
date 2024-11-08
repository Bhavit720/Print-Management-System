<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Explore Print Management Solutions</title>
    <style>
        /* Basic styles for the layout and structure */
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

        nav ul {
            display: flex;
            align-items: center;
        }

        nav ul li {
            margin-right: 20px;
            list-style: none;
        }

        nav ul li a {
            text-decoration: none;
            font-size: 18px;
            color: white;
            cursor: pointer;
        }

        .explore-products {
            text-align: center;
            margin-top: 50px;
        }

        .hero {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 50px 20px;
            border-radius: 10px;
        }

        .features {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        .feature {
            width: 30%;
            margin: 10px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            text-align: center;
            transition: transform 0.3s;
        }

        .feature h2 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .feature p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .feature .cta-button {
            background-color: #00AEEF;
            padding: 10px;
            text-decoration: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #008CBA;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="./logo.jpg" alt="Logo" width="50" height="50">
        </div>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <div class="explore-products">
        <section class="hero">
            <h1>Explore Our Print Management Solutions</h1>
            <p>Increase efficiency, reduce costs, and enhance productivity with our print software.</p>
            <a href="#product-features" class="cta-button">Learn More</a>
        </section>

        <section id="product-features" class="features">
            <?php
            // Define products array in PHP
            $products = [
                [
                    "title" => "Print Monitoring",
                    "description" => "Track and manage all print jobs with real-time data.",
                    "link" => "#"
                ],
                [
                    "title" => "Cost Recovery",
                    "description" => "Easily allocate printing costs to departments or clients.",
                    "link" => "#"
                ],
                [
                    "title" => "Secure Printing",
                    "description" => "Ensure confidential documents are printed securely with user authentication.",
                    "link" => "#"
                ],
                [
                    "title" => "Mobile Printing",
                    "description" => "Print documents directly from mobile devices seamlessly.",
                    "link" => "#"
                ],
                [
                    "title" => "Analytics Dashboard",
                    "description" => "Gain insights into printing habits and reduce waste through analytics.",
                    "link" => "#"
                ],
                [
                    "title" => "User Management",
                    "description" => "Manage users and their permissions effectively within the system.",
                    "link" => "#"
                ],
                [
                    "title" => "Cloud Printing",
                    "description" => "Enable printing from anywhere with cloud integration.",
                    "link" => "#"
                ],
                [
                    "title" => "Document Capture",
                    "description" => "Capture and digitize documents for easy access and management.",
                    "link" => "#"
                ]
            ];

            // Loop through the products array to display each product
            foreach ($products as $product) {
                echo '<div class="feature">';
                echo '<h2>' . $product['title'] . '</h2>';
                echo '<p>' . $product['description'] . '</p>';
                echo '<a href="' . $product['link'] . '" class="cta-button">Learn More</a>';
                echo '</div>';
            }
            ?>
        </section>
    </div>

    <footer>
        <p>&copy; 2024 Print Management Solutions</p>
    </footer>
</body>

</html>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Explore Print Management Solutions</title>
    <style>
        /* Basic styles for the layout and structure */
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

        nav ul {
            display: flex;
            align-items: center;
        }

        nav ul li {
            margin-right: 20px;
            list-style: none;
        }

        nav ul li a {
            text-decoration: none;
            font-size: 18px;
            color: white;
            cursor: pointer;
        }

        .explore-products {
            text-align: center;
            margin-top: 50px;
        }

        .hero {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 50px 20px;
            border-radius: 10px;
        }

        .features {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        .feature {
            width: 30%;
            margin: 10px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            text-align: center;
            transition: transform 0.3s;
        }

        .feature h2 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .feature p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .feature .cta-button {
            background-color: #00AEEF;
            padding: 10px;
            text-decoration: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #008CBA;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="./logo.jpg" alt="Logo" width="50" height="50">
        </div>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <div class="explore-products">
        <section class="hero">
            <h1>Explore Our Print Management Solutions</h1>
            <p>Increase efficiency, reduce costs, and enhance productivity with our print software.</p>
            <a href="#product-features" class="cta-button">Learn More</a>
        </section>

        <section id="product-features" class="features">
            <!-- Product features will be populated dynamically here -->
        <!-- </section>
    </div>

    <footer>
        <p>&copy; 2024 Print Management Solutions</p>
    </footer> 

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const featuresContainer = document.getElementById('product-features');

            // Example of static product data that can be replaced with an API call
            const products = [
                {
                    title: "Print Monitoring",
                    description: "Track and manage all print jobs with real-time data.",
                    link: "#"
                },
                {
                    title: "Cost Recovery",
                    description: "Easily allocate printing costs to departments or clients.",
                    link: "#"
                },
                {
                    title: "Secure Printing",
                    description: "Ensure confidential documents are printed securely.",
                    link: "#"
                }
            ];

            // Clear the container before populating
            featuresContainer.innerHTML = '';

            // Dynamically create product sections
            products.forEach(product => {
                const featureDiv = document.createElement('div');
                featureDiv.classList.add('feature');

                featureDiv.innerHTML = `
                    <h2>${product.title}</h2>
                    <p>${product.description}</p>
                    <a href="${product.link}" class="cta-button">Learn More</a>
                `;

                featuresContainer.appendChild(featureDiv);
            });
        });
    </script>
</body>

</html> -->
