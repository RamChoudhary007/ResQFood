<?php
include("login.php");
if ($_SESSION['name'] == '') {
    header("location: signin.php");
}
$emailid = $_SESSION['email'];
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'demo');

$fid = isset($_GET['fid']) ? intval($_GET['fid']) : 0;
if ($fid == 0) {
    header("location: profile.php");
    exit();
}

// Check if the record belongs to the user
$query = "SELECT * FROM food_donations WHERE Fid = $fid AND email = '$emailid'";
$result = mysqli_query($connection, $query);
if (mysqli_num_rows($result) == 0) {
    echo "Unauthorized access.";
    exit();
}

if (isset($_POST['confirm_delete'])) {
    $delete_query = "DELETE FROM food_donations WHERE Fid = $fid AND email = '$emailid'";
    $query_run = mysqli_query($connection, $delete_query);
    if ($query_run) {
        echo '<script type="text/javascript">alert("Record deleted successfully"); window.location.href="profile.php";</script>';
    } else {
        echo '<script type="text/javascript">alert("Failed to delete record")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Food Donation</title>
    <link rel="stylesheet" href="loginstyle.css">
</head>

<body style="background-color: #06C167;">
    <div class="container">
        <div class="regformf">
            <p class="logo">Delete From ResQ<b style="color: #06C167; ">Food</b></p>
            <p>Are you sure you want to delete this food donation record?</p>
            <form action="" method="post">
                <div class="btn">
                    <button type="submit" name="confirm_delete">Yes, Delete</button>
                    <button <a href="profile.php" style="margin-left: 10px; padding: 10px; background-color: #ccc; color: black; text-decoration: none;"></a>No, Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>