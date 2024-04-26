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

// Retrieve data from the form
$locations = $_POST['locations'];
$totalCost = $_POST['totalCost'];
$places = $_POST['places'];

// Insert the plan into the database
$sql = "INSERT INTO plans (total_cost) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $totalCost);
$stmt->execute();

// Get the ID of the inserted plan
$planId = $stmt->insert_id;

// Insert places into the database for the plan
foreach ($places as $placeId) {
    $placeId = (int) $placeId;
    echo "place id = $placeId";
    echo "plan id = $planId";
    $sql = "INSERT INTO plan_places (plan_id, place_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters with 'i' (integer) type
    $stmt->bind_param("ii", $planId, $placeId);
    $stmt->execute();
}

// Close connection
$conn->close();

echo "Plan saved successfully!";
?>