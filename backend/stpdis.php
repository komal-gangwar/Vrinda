<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "conn.php";
include "distance.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stop = trim($_POST["stop"]);
    $bus = $_POST["bus"];

    if (!$stop) {
        echo json_encode(["error" => "Stop is empty"]);
        exit;
    }

    $qu = "SELECT LATITUDE, LONGITUDE FROM bus_status WHERE BUS_NUMBER='$bus'";
    $ans = $conn->query($qu)->fetch_assoc();

    if (!$ans) {
        echo json_encode(["error" => "Bus not found"]);
        exit;
    }

    $lat2 = (float)$ans["LATITUDE"];
    $lon2 = (float)$ans["LONGITUDE"];

    $result = mysqli_query($conn, "SELECT LATITUDE, LONGITUDE FROM stop WHERE STOP_NAME='$stop'");
    $ans2 = mysqli_fetch_assoc($result);

    if (!$ans2) {
        echo json_encode(["error" => "Stop not found in DB: " . $stop]);
        exit;
    }

    $lat1 = (float)$ans2["LATITUDE"];
    $lon1 = (float)$ans2["LONGITUDE"];

    $distance = haversineDistance($lat1, $lon1, $lat2, $lon2); // in kilometers

    echo json_encode([
        "key" => $distance <= 0.1 ? "1" : "0",
        "distance" => $distance,
        "bus_coords" => [$lat2, $lon2],
        "stop_coords" => [$lat1, $lon1],
        "stop_name" => $stop
    ]);
    
}
?>
