<?php
// backend/stops.php

header('Content-Type: application/json');
include 'conn.php';

$result = mysqli_query($conn, "SELECT STOP_NAME,STOP_ID FROM stop");

$stops = [];
while($row = mysqli_fetch_assoc($result)) {
  $stops[] = $row;
}

echo json_encode($stops);
?>
