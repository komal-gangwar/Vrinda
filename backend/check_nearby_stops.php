<?php
include "conn.php";
session_start();

function haversineDistance($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371; // km
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $earthRadius * $c;
}

function sendNotification($stopName) {
    // 🔔 Replace this with real notification logic
    echo "Notification sent for stop: $stopName<br>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    set_time_limit(0); // Remove time limit (⚠️ careful with this)

    $bus_id = $_POST['bus'];

    // Get route ID of the bus
    $stmt = $conn->prepare('SELECT ROUTE_ID FROM bus WHERE BUS_NUMBER=?');
    $stmt->bind_param("i", $bus_id);
    $stmt->execute();
    $result1 = $stmt->get_result();
    $ans1 = $result1->fetch_assoc();
    $route_id = $ans1['ROUTE_ID'];
    $stmt->close();

    // Get all stops for this route
    $stop_query = "SELECT STOP_NAME, LATITUDE, LONGITUDE FROM stop WHERE ROUTE_ID='$route_id'";
    $result = $conn->query($stop_query);
    $stops = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $stops[] = [
                "stop_name" => $row["STOP_NAME"],
                "lat" => $row["LATITUDE"],
                "long" => $row["LONGITUDE"]
            ];
        }

        // Loop until all stops are cleared
        while (!empty($stops)) {
            // Get current bus location
            $bus_query = "SELECT LATITUDE, LONGITUDE FROM bus_status WHERE BUS_NUMBER='$bus_id'";
            $bus_result = $conn->query($bus_query);
            if ($bus_result && $bus_result->num_rows == 1) {
                $bus = $bus_result->fetch_assoc();
                $busLat = $bus['LATITUDE'];
                $busLong = $bus['LONGITUDE'];

                foreach ($stops as $index => $stop) {
                    $distance = haversineDistance($busLat, $busLong, $stop['lat'], $stop['long']);
                    if ($distance <= 1.5) {
                        sendNotification($stop['stop_name']);
                        unset($stops[$index]);
                    }
                }

                // Re-index the array
                $stops = array_values($stops);
            }

            // Wait 10 seconds before next location check (adjust as needed)
            sleep(10);
        }

        echo "✅ All nearby stops notified.";
    }
}

$conn->close();
?>
