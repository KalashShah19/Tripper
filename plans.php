<!DOCTYPE html>
<html>

<head>
    <title>Plans</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            text-transform: capitalize;
        }

        .btn-delete {
            color: white;
            padding: 6px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: red;
        }

        .btn-details {
            color: white;
            padding: 6px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: green;
        }

        .btn-edit {
            color: white;
            padding: 6px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: blue;
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

        .plan-card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .plan-card h1 {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .plan-details {
            margin-bottom: 10px;
            text-align: center;
        }

        .plan-details ul {
            list-style: none;
            padding: 0;
        }

        .plan-details ul li {
            margin-bottom: 5px;
        }

        @media only screen and (max-width: 768px) {
            .container {
                width: 100%;
            }

            .plan-card {
                padding: 10px;
                margin-bottom: 10px;
            }

            header h1 {
                font-size: 1.5em;
            }
        }
    </style>
</head>

<body>

    <?php include ('header.php') ?>
    <div class="container">
        <div class="hero">
            <center>
                <h1>Your Planned Trips</h1>
            </center>
        </div>
        <?php

        include ("db.php");

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM plans";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="plan-card">';
                echo "<h1>" . $row["plan_name"] . "</h1>";
                $planId = $row["plan_id"];
                $sql_places = "SELECT places.name, places.price FROM places
                       INNER JOIN planplaces ON places.place_id = planplaces.place_id
                       WHERE planplaces.plan_id = $planId";
                $result_places = $conn->query($sql_places);

                if ($result_places->num_rows > 0) {
                    echo '<div class="plan-details">';
                    echo "<ul> <span style='font-size:larger;font-weight: bold;'> Places :- </span>";
                    while ($place_row = $result_places->fetch_assoc()) {
                        echo "<li>" . $place_row["name"] . " - " . $place_row["price"] . " Rs</li>";
                    }
                    echo "<p> <span style='font-size:larger;font-weight: bold;'> Places Cost: </span> " . $row["total_cost"] . " Rs</p>";
                    echo "<p> <span style='font-size:larger;font-weight: bold;'>Instructions : </span> " . $row["instructions"] . "</p>";
                    echo "</ul>";
                    echo "<button class='btn-details' onclick='details(" . $row['plan_id'] . ")'>Details</button>";
                    echo "<button class='btn-delete' onclick='deletePlan(" . $row['plan_id'] . ")'>Delete</button>";
                    echo "<button class='btn-edit' onclick='budget(" . $row['plan_id'] . ")'>Budget</button>";
                    echo "</div>";
                } else {
                    echo "<p>No places associated with this plan.</p>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>No plans found.</p>";
        }

        $conn->close();
        ?>
    </div>
    <script>
        function deletePlan(id) {
            if (confirm("Are you sure you want to delete this Plan?")) {
                window.location.href = "deletePlan.php?id=" + id;
            }
        }

        function budget(id) {
            window.location.href = "expenses.php?id=" + id;
        }

        function details(id) {
            window.location.href = "details.php?id=" + id;
        }
    </script>
    <footer>
        <p>&copy; 2024 Tripper by Kalash Shah</p>
    </footer>

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