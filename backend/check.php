<?php
include "conn.php";

header('Content-Type: application/json'); // Ensure proper content-type

if (isset($_COOKIE["user_id"])) {
    $user_id = $_COOKIE["user_id"];

    // Debugging: log or print the user_id
    // echo "User ID from cookie: " . $user_id;

    $stmt = $conn->prepare("SELECT login_status FROM student WHERE student_id = ?");
    $stmt->bind_param("s", $user_id); // Use "i" if student_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(["login_status" => "false"]);
    }

    $stmt->close();
} else {
    echo json_encode(["login_status" => "false"]);
}

$conn->close();
?>
