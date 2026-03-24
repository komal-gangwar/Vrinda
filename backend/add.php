<?php
include "conn.php";

$data1 = [];
$data2 = [];
$data3 = [];
$sql1 = $conn->query("SELECT NAME FROM driver");
while ($row1 = $sql1->fetch_assoc()){
    $data1[] =  $row1["NAME"];
}
$sql2 = $conn->query("SELECT NAME FROM route");
while ($row2 = $sql2->fetch_assoc()){
    $data2[] =  $row2["NAME"];
}
$sql3 = $conn->query("SELECT DESCRIPTION FROM route");
while ($row3 = $sql3->fetch_assoc()){
    $data3[] =  $row3["DESCRIPTION"];
}
$out=[];
$out["drivers"] = $data1;
$out["routes"] = $data2;
$out["descriptions"] = $data3;
header('Content-Type: application/json');
echo json_encode($out);
?>
