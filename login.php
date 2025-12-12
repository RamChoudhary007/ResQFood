<?php
session_start();
include 'connection.php';
// $connection = mysqli_connect("localhost:3307", "root", "");
// $db = mysqli_select_db($connection, 'demo');
if (isset($_POST['sign'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Use prepared statement to prevent SQL injection
  $stmt = mysqli_prepare($connection, "SELECT * FROM login WHERE email = ?");
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $num = mysqli_num_rows($result);

  if ($num == 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
      $_SESSION['email'] = $email;
      $_SESSION['name'] = $row['name'];
      $_SESSION['gender'] = $row['gender'];
      header("location:home.html");
      exit();
    } else {
      // echo "<h1><center> Login Failed incorrect password</center></h1>";
    }
  } else {
    echo "<h1><center>Account does not exists </center></h1>";
  }

  mysqli_stmt_close($stmt);
}
