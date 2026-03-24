<?php
include "conn.php";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $long = $_POST['long'];
    $lati = $_POST['lati'];
    $bus_id = $_POST['bus'];
        $qu = "UPDATE bus_status SET LATITUDE='$lati', LONGITUDE='$long' WHERE BUS_NUMBER='$bus_id'";
        if ($conn->query($qu)) {} else {
            echo "Error updating location: " . $conn->error;
        }
}

$conn->close();
?>
