<?php
include("db.php");
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$expenseId = $_GET['id'];

$sql = "DELETE FROM places WHERE place_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $expenseId);

if ($stmt->execute() === TRUE) {
    echo "<script> alert('Place Deleted Successfully.'); window.history.back(); </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>