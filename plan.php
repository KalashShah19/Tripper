<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Planning</title>
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
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>

    <header>
        <h1>Travel Planner</h1>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">

        <div class="hero">
            <h1>Plan Your Travel</h1>
        </div>

        <center>
            <form id="savePlanForm" method="POST">
                <p> Select Locations :</p>
                <?php
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

                // Fetch locations from the database
                $sql = "SELECT DISTINCT location FROM places";
                $result = $conn->query($sql);

                // Check if locations exist
                if ($result->num_rows > 0) {
                    echo '<select id="location" multiple>';
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["location"] . '">' . $row["location"] . '</option>';
                    }
                    echo '</select>';
                } else {
                    echo "No locations found.";
                }

                $conn->close();
                ?>
                <br><br>
                <div id="placesList"></div>

                <br>
                Total Cost: <span id="totalCost">0 </span> Rs
                <br>
                <input class="btn" type="submit" value="Save">
            </form>
        </center>

    </div>

    <footer>
        <p>&copy; 2024 Travel Planner</p>
    </footer>

    <script>
        $(document).ready(function () {
            $('#location').change(function () {
                var selectedLocations = $(this).val();
                $('#planLocation').val(selectedLocations.join(', '));
                if (selectedLocations.length > 0) {
                    // Fetch and display places for each selected location
                    selectedLocations.forEach(function (locationName) {
                        $.ajax({
                            url: 'fetchPlaces.php',
                            type: 'POST',
                            data: { location: locationName },
                            success: function (response) {
                                // Parse the JSON response
                                var places = JSON.parse(response);
                                // Loop through the places and create checkboxes
                                places.forEach(function (place) {
                                    $('#placesList').append('<label><input type="checkbox" class="placeCheckbox" data-price="' + place.price + '" value="' + place.id + '"> ' + place.name + ' - ' + place.price + ' Rs </label><input type="hidden" name="placeIds[]" value="' + place.id + '"><br>');
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

            // Submit the form to save the plan
            $('#savePlanForm').submit(function (event) {
                event.preventDefault();
                var selectedLocations = $('#location').val();
                var totalCost = $('#totalCost').text();
                var checkedPlaces = $('.placeCheckbox:checked').map(function () {
                    return this.value;
                }).get();
                $.ajax({
                    url: 'savePlan.php',
                    type: 'POST',
                    data: {
                        locations: selectedLocations,
                        totalCost: totalCost,
                        places: checkedPlaces
                    },
                    success: function (response) {
                        alert(response);
                    }
                });
            });
        });

    </script>

</body>

</html>
