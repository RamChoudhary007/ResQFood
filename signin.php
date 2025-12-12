<?php
session_start();
include 'connection.php';
// $connection = mysqli_connect("localhost:3307", "root", "");
// $db = mysqli_select_db($connection, 'demo');
$msg = 0;
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
      $msg = 1;
    }
  } else {
    echo "<h1><center>Account does not exists </center></h1>";
  }

  mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>resQFood</title>
  <link rel="stylesheet" href="loginstyle.css">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

</head>

<body>
  <style>
    .uil {

      top: 42%;
    }
  </style>
  <div class="container">
    <div class="regform">

      <form action=" " method="post">

        <p class="logo" >ResQ<b style="color:#06C167; ">Food</b></p>
        <p id="heading" style="padding-left: 1px;"> Welcome back ! <img src="" alt=""> </p>

        <div class="input">
          <input type="email" placeholder="Email address" name="email" value="" required />
        </div>
        <div class="password">
          <input type="password" placeholder="Password" name="password" id="password" required />


          <i class="uil uil-eye-slash showHidePw"></i>

          <?php
          if ($msg == 1) {
            echo ' <i class="bx bx-error-circle error-icon"></i>';
            echo '<p class="error">Password not match.</p>';
          }
          ?>

        </div>


        <div class="btn">
          <button type="submit" name="sign"> Sign in</button>
        </div>
        <div class="signin-up">
          <p id="signin-up">Don't have an account? <a href="signup.php">Register</a></p>
        </div>
      </form>
    </div>


  </div>
  <script src="login.js"></script>
  <script src="admin/login.js"></script>
</body>

</html>