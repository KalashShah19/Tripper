<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tripper</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
        }

        header h1 {
            font-size: 2em;
        }

        nav ul {
            list-style-type: none;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        .hero {
            text-align: center;
            padding: 100px 0;
        }

        .hero h2 {
            font-size: 3em;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background-color: #f44336;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #ff6f61;
        }

        .features {
            padding: 50px 0;
        }

        .feature {
            text-align: center;
            margin-bottom: 20px;
        }

        .feature h3 {
            font-size: 1.5em;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        .add-place {
            background-color: #fff;
            padding: 50px;
            margin-top: 50px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .add-place h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .add-place form {
            max-width: 600px;
            margin: 0 auto;
        }

        .add-place label {
            display: block;
            margin-bottom: 10px;
        }

        .add-place input[type="text"],
        .add-place textarea,
        .add-place input[type="url"],
        .add-place input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .add-place textarea {
            height: 100px;
        }

        .add-place button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #f44336;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-place button[type="submit"]:hover {
            background-color: #ff6f61;
        }
    </style>
</head>

<body>
    <?php include('header.php') ?>
    <section class="add-place">
        <div class="container">
            <h2>Add New Place</h2>
            <form method="post">
                <label for="name"> Name :</label>
                <input type="text" id="name" name="name" required>

                <label for="location"> Location :</label>
                <input type="text" id="location" name="location" required>

                <label for="price"> Price:</label>
                <input type="number" id="price" name="price" required>

                <button type="submit" class="btn">Add</button>
            </form>
        </div>
    </section>
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Tripper";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $name = $_POST["name"];
        $location = $_POST["location"];
        $price = $_POST["price"];

        if (empty($name) || empty($location) || empty($price)) {
            echo "All fields are required.";
        } else {
            $sql = "INSERT INTO places (name, location, price) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $location, $price);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<center> New record inserted successfully. </center>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $stmt->close();
            $conn->close();
        }
    }
    ?>

    <footer>
        <div class="container">
            <p>&copy; 2024 Tripper by Kalash Shah</p>
        </div>
    </footer>
</body>

</html>