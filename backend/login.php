<?php
session_start();
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $authToken = $_POST['auth'] ?? null;

    $stmt = $conn->prepare("SELECT STUDENT_ID, NAME, PASSWORD FROM student WHERE EMAIL = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['PASSWORD'])) {
            $studentId = $user['STUDENT_ID'];
            $name = $user['NAME'];

            // ✅ Update login status and auth token
            $updateStmt = $conn->prepare("UPDATE student SET login_status = 'true', auth = ? WHERE student_id = ?");
            $updateStmt->bind_param("ss", $authToken, $studentId);
            $updateStmt->execute();
            $updateStmt->close();

            // ✅ Set cookies (7-day expiry)
            setcookie("user_id", $studentId, time() + (86400 * 7), "/");
            setcookie("name", $name, time() + (86400 * 7), "/");

            echo "1"; // success
        } else {
            echo "-1"; // wrong password
        }
    } else {
        echo "0"; // email not found
    }

    $stmt->close();
}

$conn->close();
?>
