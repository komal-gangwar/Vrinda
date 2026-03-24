<?php

include "conn.php";

// Handle different requests based on the 'key' parameter
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = $_POST['key'];

    switch ($key) {
        case 'update':
            updateBus($conn);
            break;

        case 'addbus':
            addBus($conn);
            break;

        case 'adddriver':
            addDriver($conn);
            break;

        case 'addroute':
            addRoute($conn);
            break;

        case 'deletebus':
            deletebus($conn);
            break;

        case 'deletedriver':
            deletedriver($conn);
            break;

        case 'deleteroute':
            deleteroute($conn);
            break;

        default:
            echo "Invalid request";
            break;
    }
}

function updateBus($conn)
{
    $id = $_POST['id'];
    $driver = $_POST['driver'];
    $route = $_POST['route'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    // Validate input
    if (empty($id) || empty($driver) || empty($route) || empty($description) || empty($status)) {
        echo "All fields are required.";
        return;
    }

    $stmt = $conn->prepare("SELECT BUS_ID FROM bus WHERE BUS_NUMBER = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result1 = $stmt->get_result();
    $ans1 = $result1->fetch_assoc();
    $bus_id = $ans1['BUS_ID'];
    $stmt->close();


    // Get ROUTE_ID from route table using route name
    $stmt = $conn->prepare("SELECT ROUTE_ID FROM route WHERE NAME = ?");
    $stmt->bind_param("s", $route);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Route not found.";
        return;
    }

    $ans = $result->fetch_assoc();
    $route_id = $ans['ROUTE_ID'];
    $stmt->close();

    // Update driver's assigned bus
    $nullno = 0;
    $stmt = $conn->prepare("UPDATE driver SET BUS = ? WHERE BUS = ?");
    $stmt->bind_param("ii", $nullno, $bus_id);
    $stmt->execute();
    $stmt->close();


    $stmt = $conn->prepare("UPDATE driver SET BUS = ? WHERE NAME = ?");
    $stmt->bind_param("is", $bus_id, $driver);
    $stmt->execute();
    $stmt->close();

    // Update bus details
    $stmt = $conn->prepare("UPDATE bus SET ROUTE_ID = ?, running = ? WHERE BUS_NUMBER = ?");
    $stmt->bind_param("isi", $route_id, $status, $id);

    if ($stmt->execute()) {
        echo "Bus updated successfully.";
    } else {
        echo "Error updating bus: " . $stmt->error;
    }

    $stmt->close();
}


function addBus($conn)
{
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Validate input
    if (empty($id) || empty($status)) {
        echo "All fields are required.";
        return;
    }

    $stmt = $conn->prepare("INSERT INTO bus (BUS_NUMBER, running) VALUES (?, ?)");
    $stmt->bind_param("is", $id, $status);

    if ($stmt->execute()) {
        echo "Bus added successfully";
    } else {
        echo "Error adding bus: " . $stmt->error;
    }

    $stmt->close();
}

function addDriver($conn)
{
    $driver = $_POST['driver'];
    $pass = $_POST['pass'];

    // Validate input
    if (empty($driver)) {
        echo "Driver name is required.";
        return;
    }

    $stmt = $conn->prepare("INSERT INTO driver (NAME , PASSWORD) VALUES (?,?)");
    $stmt->bind_param("ss", $driver, $pass);

    if ($stmt->execute()) {
        echo "Driver added successfully";
    } else {
        echo "Error adding driver: " . $stmt->error;
    }

    $stmt->close();
}
function addRoute($conn)
{
    $route = $_POST['route'];
    $description = $_POST['description'];
    $stops = json_decode($_POST['stops'], true);

    if (empty($route) || empty($description) || empty($stops)) {
        echo "All fields are required.";
        return;
    }

    // 1. Insert route into `route` table
    $stmt = $conn->prepare("INSERT INTO route (NAME, DESCRIPTION) VALUES (?, ?)");
    if (!$stmt) {
        echo "Prepare failed: " . $conn->error;
        return;
    }
    $stmt->bind_param("ss", $route, $description);
    if (!$stmt->execute()) {
        echo "Error adding route: " . $stmt->error;
        $stmt->close();
        return;
    }
    $stmt->close();

    // 2. Get inserted ROUTE_ID
    $stmt = $conn->prepare("SELECT ROUTE_ID FROM route WHERE NAME = ?");
    $stmt->bind_param("s", $route);
    $stmt->execute();
    $result = $stmt->get_result();
    $ans = $result->fetch_assoc();
    $route_id = $ans['ROUTE_ID'];
    $stmt->close();


    foreach ($stops as $stop) {
        $lat = null;
        $lng = null;

        // Insert into `stop` table
        $stmt = $conn->prepare("INSERT INTO stop (ROUTE_ID, STOP_NAME, LATITUDE, LONGITUDE) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            echo "Prepare failed for stop '$stop': " . $conn->error;
            return;
        }
        $stmt->bind_param("isss", $route_id, $stop, $lat, $lng);
        if (!$stmt->execute()) {
            echo "Error adding stop '$stop': " . $stmt->error;
            $stmt->close();
            return;
        }
        $stmt->close();
    }

    echo "Route and stops added successfully.";
}

function deletebus($conn){
    $id = $_POST['id'];
    {
        $stmt = $conn->prepare("SELECT BUS_ID FROM bus WHERE BUS_NUMBER = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result1 = $stmt->get_result();
    $ans1 = $result1->fetch_assoc();
    $bus_id = $ans1['BUS_ID'];
    $stmt->close();
    $nullno = null;
    $stmt = $conn->prepare("UPDATE driver SET BUS = ? WHERE BUS = ?");
    $stmt->bind_param("si", $nullno, $bus_id);
    $stmt->execute();
    $stmt->close();
    $stmt = $conn->prepare("UPDATE student SET BUS_NUMBER_ID = ? WHERE BUS_NUMBER_ID = ?");
    $stmt->bind_param("si", $nullno, $bus_id);
    $stmt->execute();
    $stmt->close();
    $stmt = $conn->prepare("DELETE FROM bus_status WHERE BUS_NUMBER = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    }
    $stmt = $conn->prepare("DELETE FROM bus WHERE BUS_NUMBER = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "Bus $id deleted successfully";
}

function deletedriver($conn){
    $driver = $_POST['driver'];
    $stmt = $conn->prepare("DELETE FROM driver WHERE NAME = ?");
    $stmt->bind_param("s", $driver);
    $stmt->execute();
    echo "Driver $driver deleted successfully";
    exit;
}

function deleteroute($conn){
    $route = $_POST['route'];
    {
        $stmt = $conn->prepare('select ROUTE_ID FROM route WHERE NAME=?');
        $stmt->bind_param("s", $route);
        $stmt->execute();
        $result1 = $stmt->get_result();
    $ans1 = $result1->fetch_assoc();
    $route_id = $ans1['ROUTE_ID'];
    $stmt->close();
    $nullno = null;
    $stmt = $conn->prepare("UPDATE bus SET ROUTE_ID = ? WHERE ROUTE_ID = ?");
    $stmt->bind_param("si", $nullno, $route_id);
    $stmt->execute();
    $stmt->close();
    $stmt = $conn->prepare("DELETE FROM stop WHERE ROUTE_ID = ?");
    $stmt->bind_param("i", $route_id);
    $stmt->execute();
    $stmt->close();
}
    $stmt = $conn->prepare("DELETE FROM route WHERE NAME = ?");
    $stmt->bind_param("s", $route);
    $stmt->execute();
    echo "Route $route deleted successfully";
    exit;
}


$conn->close();
?>