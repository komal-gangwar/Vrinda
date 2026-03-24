<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "conn.php";
include "distance.php";
include "send_not.php";


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

    $result = mysqli_query($conn, "SELECT STOP_ID, LATITUDE, LONGITUDE FROM stop WHERE STOP_NAME='$stop'");
    $ans2 = mysqli_fetch_assoc($result);

    if (!$ans2) {
        echo json_encode(["error" => "Stop not found in DB: " . $stop]);
        exit;
    }
    $result1 = mysqli_query($conn, "SELECT BUS_NUMBER FROM bus WHERE BUS_ID='$bus'");
    $ans3 = mysqli_fetch_assoc($result1);
    $busn = $ans3["BUS_NUMBER"];

    $lat1 = (float)$ans2["LATITUDE"];
    $lon1 = (float)$ans2["LONGITUDE"];

    $distance = haversineDistance($lat1, $lon1, $lat2, $lon2); // in kilometers

    if($distance<=1.5){
        $SID = $ans2["STOP_ID"];
        $ans11 = mysqli_query($conn, "SELECT auth FROM student WHERE STOP_ID='$SID'");

        $tokens = [];
        while ($student = mysqli_fetch_assoc($ans11)) {
            $tokens[] = $student['auth'];
        }

        sendFCMNotification(
            $tokens,
            "Bus Update!",
            "Bus-$busn is arriving at your stop soon!"
        );
        echo json_encode([
            "key" => 1,
            "distance" => "notified"
        ]);
    }else{
        echo json_encode([
            "key" => 0,
            "distance" => "not notified"
        ]);
    }
    
}
?>