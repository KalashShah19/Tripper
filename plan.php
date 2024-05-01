<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Planning</title>
    <style>
        /* Reset default browser styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        input[type="text"],
        textarea,
        select {
            width: 250px;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
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

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block; /* Added to display each checkbox on a new line */
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            font-size: 2em;
        }

        nav ul {
            list-style-type: none;
            text-align: center;
            margin-top: 20px;
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
            padding: 20px 0;
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
            bottom: 0;
            width: 100%;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <?php include ('header.php') ?>

    <div class="container">
        <div class="hero">
            <h1>Plan Your Trip</h1>
        </div>
        <center>
            <form id="savePlanForm" method="POST">
                <label>Select Locations :</label><br>
                <?php

                include("db.php");
                
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT DISTINCT location FROM places";
                $result = $conn->query($sql);

                // Check if locations exist
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<label><input type="checkbox" class="locationCheckbox" name="locations[]" value="' . $row["location"] . '"> ' . $row["location"] . '</label>';
                    }
                } else {
                    echo "No locations found.";
                }

                $conn->close();
                ?>
                <br>
                <label for="">Places :-</label>
                <div id="placesList"></div><br>
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name">
                <br>
                <label for="instructions">Instructions:</label><br>
                <textarea id="instructions" name="instructions" rows="4" cols="50"></textarea>
                <br>
                <label for="">
                    Total Cost: <span id="totalCost">0 </span> Rs
                </label> <br>
                <input class="btn" type="submit" value="Save">
            </form>
        </center>
    </div> <br>

    <footer>
        <p>&copy; 2024 Tripper by Kalash Shah</p>
    </footer>

    <script>
        $(document).ready(function () {
            $('.locationCheckbox').change(function () {
                var selectedLocations = $('.locationCheckbox:checked').map(function () {
                    return this.value;
                }).get();
                $('#planLocation').val(selectedLocations.join(', '));
                if (selectedLocations.length > 0) {
                    // Clear existing placesList content
                    $('#placesList').html('');
                    selectedLocations.forEach(function (locationName) {
                        $.ajax({
                            url: 'fetchPlaces.php',
                            type: 'POST',
                            data: { location: locationName },
                            success: function (response) {
                                var places = JSON.parse(response);
                                places.forEach(function (place) {
                                    $('#placesList').append('<label><input type="checkbox" class="placeCheckbox" data-price="' + place.price + '" value="' + place.place_id + '"> ' + place.name + ' - ' + place.price + ' Rs </label><input type="hidden" name="placeIds[]" value="' + place.id + '">');
                                });
                            }
                        });
                    });
                } else {
                    $('#placesList').html('');
                    $('#totalCost').text('0');
                }
            });


            // Listen for checkbox changes
            $(document).on('change', '.placeCheckbox', function () {
                var totalCost = 0;
                $('.placeCheckbox:checked').each(function () {
                    totalCost += parseFloat($(this).data('price'));
                });
                $('#totalCost').text(totalCost.toFixed(2));
            });

            $('#savePlanForm').submit(function (event) {
                event.preventDefault();
                var selectedLocations = $('.locationCheckbox:checked').map(function () {
                    return this.value;
                }).get();
                var totalCost = $('#totalCost').text();
                var name = $('#name').val();
                var instructions = $('#instructions').val();
                if (instructions.trim() === '') {
                    instructions = "-"
                }
                var checkedPlaces = $('.placeCheckbox:checked').map(function () {
                    return this.value;
                }).get();
                $.ajax({
                    url: 'savePlan.php',
                    type: 'POST',
                    data: {
                        name: name,
                        instructions: instructions,
                        locations: selectedLocations,
                        totalCost: totalCost,
                        places: checkedPlaces
                    },
                    success: function (response) {
                        alert(response);
                        location.href='plans.php';
                    }
                });
            });
        });

    </script>
<!--
</body>

</html>
