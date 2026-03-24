<?php
// backend/buses.php


header('Content-Type: application/json');
include "distance.php";
include 'conn.php'; // Your DB connection script
 if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $bus = $_POST["bus"];
$result = mysqli_query($conn, "SELECT ROUTE_ID FROM bus where BUS_ID='$bus'");

$row = mysqli_fetch_assoc($result);
$r= $row["ROUTE_ID"];
$ans=mysqli_query($conn,"SELECT DESCRIPTION FROM route where ROUTE_ID='$r'");
$row1 = mysqli_fetch_assoc($ans);
$array = explode("-", $row1["DESCRIPTION"]);
$qu = "SELECT LATITUDE, LONGITUDE FROM bus_status WHERE BUS_NUMBER='$bus'";
    $ans2 = $conn->query($qu)->fetch_assoc();
    $lat1=$ans2["LATITUDE"];
    $lon1=$ans2["LONGITUDE"];
    $distance = haversineDistance($lat1, $lon1, 28.476870982857474, 79.43617058844707);
    if( $distance >= 3) {
        $array=array_reverse($array);
    }
    echo json_encode($array);
}
?>
