<?php
include "conn.php";
session_start(); // Start session at the top

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $pass = $_POST['password'];
    if ($name === "Admin") {
        if($pass==="i m admin"){
            setcookie("admin", "yes", time() + (3600), "/");
            header(header: "Location: ../admin.html");
            exit();
        }else{
            header("Location: ../dlogin.html?error=incorrect+password");
        }
    }else{
    $sql = "SELECT PASSWORD FROM driver WHERE NAME='$name'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($pass === $row['PASSWORD']) {
            setcookie("dname", $name, time() + (86400 * 20), "/");
            $_SESSION['dname'] = $name;
            $_SESSION['loggedin'] = true;

            // Redirect to driver page
            header(header: "Location: /driver.html");
            exit();

        } else {
            header("Location: ../dlogin.html?error=Incorrect+password");
        }
    } else {
        header("Location: ../dlogin.html?error=Email+not+found");
    }
}
}
?>
