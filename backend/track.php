<?php
include "conn.php";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $bus = $_POST['bus'];
    $qu = "SELECT LATITUDE, LONGITUDE FROM bus_status WHERE BUS_NUMBER='$bus'";
    $ans = $conn->query($qu);
    
    if ($ans->num_rows > 0) {
        echo json_encode($ans->fetch_assoc());
    } else {
        echo json_encode(["latitude" => 0, "longitude" => 0]); // Default values
    }
}
$conn->close();
?>
