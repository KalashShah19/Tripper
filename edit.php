<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Place</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            bottom: 0;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            text-transform: uppercase;
        }

        form {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <header>
        <h1>Edit Place</h1>
    </header>

    <h2>Edit Place</h2>

    <?php
    include("db.php");
        
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM places WHERE place_id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<form method='post'>";
            echo "<input type='hidden' name='place_id' value='" . $row['place_id'] . "'>";
            echo "<label for='name'>Name:</label>";
            echo "<input type='text' id='name' name='name' value='" . $row['name'] . "' required>";
            echo "<label for='location'>Location:</label>";
            echo "<input type='text' id='location' name='location' value='" . $row['location'] . "' required>";
            echo "<label for='price'>Price:</label>";
            echo "<input type='number' id='price' name='price' value='" . $row['price'] . "' required>";
            echo "<input type='submit' value='Save'>";
            echo "</form>";
        } else {
            echo "Place not found.";
        }
    }

    // Close connection
    $conn->close();
    ?>

    <?php
    include("db.php");
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_id'])) {
        $id = $_POST['place_id'];
        $name = $_POST["name"];
        $location = $_POST["location"];
        $price = $_POST["price"];

        // Update data in the database
        $sql = "UPDATE places SET name='$name', location='$location', price='$price' WHERE place_id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "<script> alert('Place Updated Successfully!'); location.href='destinations.php'; </script>";
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    // Close connection
    $conn->close();
    ?>

    <footer>
        <p>&copy; 2024 Tripper by Kalash Shah</p>
    </footer>
<!--
</body>

</html>