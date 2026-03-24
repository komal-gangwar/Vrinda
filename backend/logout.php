<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "conn.php"; // Ensure this sets up $conn properly
?>
<div class='logouthuma'>
  <div class='message-box'>
<?php
if (isset($_COOKIE["user_id"])) {
    $user_id = $_COOKIE["user_id"];

    // 🔁 Update login_status and clear auth
    $sql = "UPDATE student SET login_status = 'false', auth = NULL WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->close();

    // 🧹 Delete cookie
    setcookie("user_id", "", time() - 3600, "/");
    ?>
      <h2>Successfully Logged Out</h2>
      <p>You are being redirected to the login page...</p>
      <div class='loader'></div>
      <script>
        setTimeout(() => {
          document.getElementById('login').click();
        }, 2500);
      </script>
    <?php
} else {
    ?>
      <h2>Logged Out</h2>
      <p>Something went wrong. Redirecting to login page...</p>
      <div class='loader'></div>
      <script>
        setTimeout(() => {
          document.getElementById('login').click();
        }, 2500);
      </script>
    <?php
}
?>
  </div>
</div>
