<?php
include("db.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$location = $_POST['location'];
$totalCost = $_POST['totalCost'];
$places = $_POST['places']; // Array of checked places

// Prepare the SQL statement to insert the plan
$sql = "INSERT INTO plans (location, cost) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $location, $totalCost);

// Execute the SQL statement to insert the plan
if ($stmt->execute()) {
    // Get the ID of the inserted plan
    $planId = $conn->insert_id;
    
    // Prepare the SQL statement to insert the checked places
    $sql = "INSERT INTO planPlaces (pid, pname) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $planId, $placeName);

    // Insert each checked place into the database
    foreach ($places as $placeName) {
        $stmt->execute();
    }

    echo "Plan saved successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
