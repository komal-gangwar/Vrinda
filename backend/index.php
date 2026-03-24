<?php
include "conn.php";

$sql = "SELECT BUS_ID, BUS_NUMBER, ROUTE_ID FROM bus WHERE running = 'y' AND ROUTE_ID IS NOT NULL";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $route_id = $row['ROUTE_ID'];
        $que = "SELECT DESCRIPTION, NAME FROM route WHERE ROUTE_ID = $route_id";
        $routeResult = $conn->query($que);

        if ($routeResult && $routeResult->num_rows > 0) {
            $ans = $routeResult->fetch_assoc();

            $data[] = [
                "bus_id" => $row["BUS_ID"],
                "bus_number" => $row["BUS_NUMBER"],
                "route_name" => $ans["NAME"],
                "stops" => $ans["DESCRIPTION"]
            ];
        }
    }
}

// Send only JSON response
header('Content-Type: application/json');
echo json_encode($data);
