<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Places List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            text-transform: capitalize;
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

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            text-transform: uppercase;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
            text-transform: uppercase;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        td:first-child {
            text-transform: capitalize;
        }

        .btn-edit,
        .btn-delete {
            padding: 6px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-edit {
            background-color: #4CAF50;
            color: white;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        .btn {
            display: inline-block;
            background-color: blue;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php include ('header.php') ?>

    <h2>Places List</h2>
    <center>
        <a class="btn" href="add.php"> Add New Place </a>
    </center>
    <table>
        <tr>
            <th>Name</th>
            <th>Location</th>
            <th>Price</th>
            <th>Action</th>
        </tr>

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

        // Fetch data from database
        $sql = "SELECT * FROM places";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["location"] . "</td>";
                echo "<td>" . $row["price"] . " Rs </td>";
                echo "<td>";
                echo "<button class='btn-edit' onclick='editPlace(" . $row['id'] . ")'>Edit</button>";
                echo "<button class='btn-delete' onclick='deletePlace(" . $row['id'] . ")'>Delete</button>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No places found.</td></tr>";
        }

        // Close connection
        $conn->close();
        ?>

    </table>

    <footer>
        <p>&copy; 2024 Tripper by Kalash Shah</p>
    </footer>

    <script>
        function editPlace(id) {
            window.location.href = "edit.php?id=" + id;
        }

        function deletePlace(id) {
            if (confirm("Are you sure you want to delete this place?")) {
                window.location.href = "delete.php?id=" + id;
            }
        }
    </script>

</body>

</html>