<?php
// backend/buses.php

header('Content-Type: application/json');
include 'conn.php'; // Your DB connection script

$result = mysqli_query($conn, "SELECT BUS_ID, BUS_NUMBER FROM bus");

$buses = [];
while($row = mysqli_fetch_assoc($result)) {
  $buses[] = $row; // ['id' => ..., 'BUS_NUMBER' => ...]
}

echo json_encode($buses);
?>
