<?php
include "conn.php";

$userId = $_COOKIE['user_id'] ?? null;

if (!$userId) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$busId = $data['bus_id'] ?? null;
$stop = $data['stop'] ?? null;

if (!$busId || !$stop) {
    echo json_encode(["status" => "error", "message" => "Missing fields"]);
    exit;
}



$update = mysqli_query($conn, "UPDATE student SET BUS_NUMBER_ID='$busId', STOP_ID='$stop' WHERE STUDENT_ID='$userId'");

if ($update) {
    echo json_encode(["status" => "1"]);
}else{
    echo json_encode(["status" => "0"]);
}
?>
