<?php
include "conn.php";

$query = "SELECT STOP_ID, STOP_NAME FROM stop WHERE LATITUDE IS NULL OR LONGITUDE IS NULL";
$result = $conn->query($query);

$stops = [];
while ($row = $result->fetch_assoc()) {
    $stops[] = $row;
}

echo json_encode($stops);

$conn->close();
?>
