<?php
include "conn.php";

$stopId = $_POST['stopId'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

$stmt = $conn->prepare("UPDATE stop SET LATITUDE = ?, LONGITUDE = ? WHERE STOP_ID = ?");
$stmt->bind_param("dsi", $latitude, $longitude, $stopId);

if ($stmt->execute()) {
    echo "Coordinates saved successfully.";
} else {
    echo "Error saving coordinates: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
