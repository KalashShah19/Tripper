<?php

include("db.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and sanitize the input
$location = $_POST['location']; // No need for sanitization since it's used directly in a SQL query

// Prepare the SQL statement
$sql = "SELECT * FROM places WHERE location = ? ORDER BY price ASC";
$stmt = $conn->prepare($sql);

// Bind the parameter
$stmt->bind_param("s", $location);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if places exist
if ($result->num_rows > 0) {
    // Prepare an array to hold the results
    $places = array();

    // Fetch places and add them to the array
    while ($row = $result->fetch_assoc()) {
        $places[] = $row;
    }

    // Encode the array as JSON and send it as the response
    echo json_encode($places);
} else {
    echo "No places found for this location.";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>