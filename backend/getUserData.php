<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "conn.php";

// Safely get user_id from cookie
$id = $_COOKIE['user_id'] ?? null;

if (!$id) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

// ✅ FIX: Correct variable inside SQL query
$result = mysqli_query($conn, "SELECT NAME, EMAIL, BUS_NUMBER_ID, STOP_ID FROM student WHERE STUDENT_ID='$id'");
$row = mysqli_fetch_assoc($result);

$busNumber = "Choose your bus";
$stopDesc = "Choose your stop";
$busNumber=null;
$stopp=null;
if (!empty($row["BUS_NUMBER_ID"])) {
    $B = $row["BUS_NUMBER_ID"];
    $bus = mysqli_query($conn, "SELECT BUS_NUMBER FROM bus WHERE BUS_ID='$B'");
    $row1 = mysqli_fetch_assoc($bus);
        $busNumber = $row1["BUS_NUMBER"];
}
if (!empty($row["STOP_ID"])) {
    $s = $row["STOP_ID"];
    $stop = mysqli_query($conn, "SELECT STOP_NAME FROM stop WHERE STOP_ID='$s'");
    $row2 = mysqli_fetch_assoc($stop);
        $stopp = $row2["STOP_NAME"];
}

// Return final JSON
echo json_encode([
    "name" => $row["NAME"],
    "email" => $row["EMAIL"],
    "bus_number" => ($busNumber===null) ? -1 : $busNumber,
    "stops" => ($stopp===null) ? -1: $stopp,
]);
?>
