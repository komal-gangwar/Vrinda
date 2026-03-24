<?php
// backend/save_selection.php

include 'conn.php';

$std_id = $_COOKIE["user_id"] ?? null;

if (!$std_id) {
    http_response_code(401);
    echo "User not logged in.";
    exit;
}

$bus_id = $_POST["bus_id"];
$stop_name = $_POST["stop_name"];

$sql = "INSERT INTO student (STUDENT_ID,BUS_NUMBER_ID, STOP_ID) 
        VALUES (?, ?, ?) 
        ON DUPLICATE KEY UPDATE BUS_NUMBER_ID=?, STOP_ID=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisss", $std_id, $bus_id, $stop_name, $bus_id, $stop_name);

if ($stmt->execute()) {
    echo "Selection saved successfully.";
} else {
    echo "Error: " . $stmt->error;
}
?>
