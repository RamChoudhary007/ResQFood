<?php

use Soap\Url;

session_start();
include 'connection.php';

$showThankYou = false;

if (isset($_POST['send'])) {
  $email = $_POST['email'];
  $name = $_POST['name'];
  $msg = $_POST['message'];
  $sanitized_emailid =  mysqli_real_escape_string($connection, $email);
  $sanitized_name =  mysqli_real_escape_string($connection, $name);
  $sanitized_msg =  mysqli_real_escape_string($connection, $msg);
  $query = "insert into user_feedback(name,email,message) values('$sanitized_name','$sanitized_emailid','$sanitized_msg')";
  $query_run = mysqli_query($connection, $query);
  if ($query_run) {
    $showThankYou = true;
  } else {
    echo '<script type="text/javascript">alert("data not saved")</script>';
  }
}
?>


<?php if ($showThankYou): ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        text-align: center;
        background: #f4f8fb;
        color: #333;
        margin: 0;
        padding: 0;
      }

      .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        flex-direction: column;
      }

      .thank-you-box {
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        max-width: 500px;
      }

      h1 {
        color: #28a745;
        margin-bottom: 15px;
      }

      p {
        font-size: 18px;
        margin-bottom: 25px;
      }

      a {
        display: inline-block;
        text-decoration: none;
        background: #007bff;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        transition: background 0.3s;
      }

      a:hover {
        background: #0056b3;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <div class="thank-you-box">
        <h1>🎉 Thank You!</h1>
        <p>Your response has been recorded successfully.<br> We appreciate your contribution.</p>
        <a href="home.html">Back to Home</a>
      </div>
    </div>
  </body>

  </html>
<?php endif; ?>