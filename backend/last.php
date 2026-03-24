<?php
include "conn.php";
if (isset($_COOKIE['name'])) {
    $dname = $_COOKIE['dname'];
    
$result = mysqli_query($conn, "SELECT bus from driver where NAME='$dname'");

$ans2 = mysqli_fetch_assoc($result);
echo json_encode($ans2);
} else {
    echo "Name cookie is not set.";
}