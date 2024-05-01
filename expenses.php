<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations</title>
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
            background-color: red;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php
    include ('header.php');
    $id = $_GET["id"];
    ?>

    <h2>Trip Expenses</h2>
    <center>
        <a class="btn" href="budget.php?id=<?php echo $id; ?>"> Add New Expense </a>
    </center>
    <table>
    <tr>
        <th>Name</th>
        <th>Amount</th>
        <th>Action</th>
    </tr>
    <?php
    include ("db.php");

    $id = $_GET["id"];
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $totalExpenses = 0; // Initialize total expenses variable

    $sql = "SELECT * FROM expenses WHERE plan_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result(); 
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Add expense amount to total expenses
            $totalExpenses += $row["amount"];

            echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["amount"] . " Rs </td>";
            echo "<td>";
            echo "<button class='btn-edit' onclick='editExpense(" . $row['expense_id'] . ")'>Edit</button>";
            echo "<button class='btn-delete' onclick='deleteExpense(" . $row['expense_id'] . ")'>Delete</button>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No Expenses yet.</td></tr>";
    }

    // Display total expenses row
    echo "<tr><td colspan='2' style='text-align: right;'>Total Expenses:</td><td>" . $totalExpenses . " Rs</td></tr>";

    $conn->close();
    ?>
</table>


    <footer>
        <p>&copy; 2024 Tripper by Kalash Shah</p>
    </footer>

    <script>
        function editExpense(id) {
            window.location.href = "editExpense.php?id=" + id;
        }

        function deleteExpense(id) {
            if (confirm("Are you sure you want to delete this Expense?")) {
                window.location.href = "deleteExpense.php?id=" + id;
            }
        }

    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(window).bind("pageshow", function (event) {
            if (event.originalEvent.persisted) {
                console.log("Back!");
                location.reload();
            }
        });
    </script>
    <!--
</body>

</html>