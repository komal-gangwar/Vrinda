<?php
include "conn.php";

$sql = "SELECT BUS_ID,BUS_NUMBER, ROUTE_ID,running FROM bus ";
$result = $conn->query($sql);

$data = [];
// "bus_id" =>$row["BUS_NUMBER"], "driver" =>$ans1["NAME"], "route" =>$ans["NAME"], "description" =>$ans["DESCRIPTION"],"status" =>$row["running"]
if ($result->num_rows > 0) { 
    while ($row = $result->fetch_assoc()) {
        $route_id = $row['ROUTE_ID'];
        if ($route_id == null) {
            $ans=0;
        }else{
            $que = "SELECT DESCRIPTION, NAME FROM route WHERE ROUTE_ID = $route_id";
        $ans = $conn->query($que)->fetch_assoc();
        }
        
        $bus = $row['BUS_ID'];
        $que1 = "SELECT NAME FROM driver WHERE bus = '$bus'";
        $ans1 = $conn->query($que1)->fetch_assoc();
        
        $data[] = [
            "id" =>$row["BUS_NUMBER"], "driver" =>($ans1==null?"":$ans1["NAME"]), "route" =>($ans==0?"ROUTE : not selected":$ans["NAME"]), "description" =>($ans==0?"DESCRIPTION : not selected":$ans["DESCRIPTION"]),"status" =>$row["running"]
        ];
    }
}

// Send only JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
