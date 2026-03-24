<?php
include "conn.php";
 include "send_not.php";
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus = $_POST['bus']; 
 $ans = mysqli_query($conn, "SELECT auth FROM student WHERE BUS_NUMBER_ID='$bus'");

 $tokens = [];
 while ($student = mysqli_fetch_assoc($ans)) {
     $tokens[] = $student['auth']; // only add token string
 }
 // Send FCM notification
 $title = "Bus Update";
 $body = "Your bus has started";
 sendFCMNotification($tokens, $title, $body);
 echo json_encode("sucess");
}else{
    echo json_encode("error");
}