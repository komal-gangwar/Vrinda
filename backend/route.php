<?php
// backend/buses.php

header('Content-Type: application/json');
include 'conn.php'; // Your DB connection script

$result = mysqli_query($conn, "SELECT ROUTE_ID, DESCRIPTION FROM route");

$routes = [];
while($row = mysqli_fetch_assoc($result)) {
  $routes[] = $row; // ['id' => ..., 'BUS_NUMBER' => ...]
}

echo json_encode($routes);
?>
