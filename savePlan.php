<?php

include("db.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$locations = $_POST['locations'];
$totalCost = $_POST['totalCost'];
$places = $_POST['places'];
$name = $_POST['name']; 
$instructions = $_POST['instructions']; 

$sql = "INSERT INTO plans (plan_name, instructions, total_cost) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $instructions, $totalCost);

if ($stmt->execute()) {
    $planId = $stmt->insert_id;

    foreach ($places as $placeId) {
        $sql2 = "INSERT INTO planplaces (plan_id, place_id) VALUES (?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ii", $planId, $placeId);

        if (!$stmt2->execute()) {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
    }

    echo "Plan saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
