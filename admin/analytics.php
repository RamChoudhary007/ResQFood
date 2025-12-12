<?php
// Start output buffering to prevent header issues
ob_start();

// Include database connection file
include("connect.php");

// Check if admin is logged in, redirect to signin if not
if ($_SESSION['name'] == '') {
    header("location:signin.php");
    exit(); // Ensure script stops after redirect
}

// Establish database connection for analytics queries
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'demo');

// Function to get count from a table
function getCount($connection, $table)
{
    $query = "SELECT count(*) as count FROM $table";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

// Get analytics data
$totalUsers = getCount($connection, 'login');
$totalFeedbacks = getCount($connection, 'user_feedback');
$totalDonations = getCount($connection, 'food_donations');

// Get gender distribution for chart
$queryMale = "SELECT count(*) as count FROM login WHERE gender='male'";
$queryFemale = "SELECT count(*) as count FROM login WHERE gender='female'";
$resultMale = mysqli_query($connection, $queryMale);
$resultFemale = mysqli_query($connection, $queryFemale);
$rowMale = mysqli_fetch_assoc($resultMale);
$rowFemale = mysqli_fetch_assoc($resultFemale);
$maleCount = $rowMale['count'];
$femaleCount = $rowFemale['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard Panel</title>

    <!-- External CSS and JS libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <!--<img src="images/logo.png" alt="">-->
            </div>

            <span class="logo_name">ADMIN</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dahsboard</span>
                    </a></li>
                <!-- <li><a href="#">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Content</span>
                </a></li> -->
                <li><a href="#">
                        <i class="uil uil-chart"></i>
                        <span class="link-name">Analytics</span>
                    </a></li>
                <li><a href="donate.php">
                        <i class="uil uil-heart"></i>
                        <span class="link-name">Donates</span>
                    </a></li>
                <li><a href="feedback.php">
                        <i class="uil uil-comments"></i>
                        <span class="link-name">Feedbacks</span>
                    </a></li>
                <li><a href="adminprofile.php">
                        <i class="uil uil-user"></i>
                        <span class="link-name">Profile</span>
                    </a></li>
                <!-- <li><a href="#">
                    <i class="uil uil-share"></i>
                    <span class="link-name">Share</span>
                </a></li> -->
            </ul>

            <ul class="logout-mode">
                <li><a href="../logout.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                    </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                        <span class="link-name">Dark Mode</span>
                    </a>

                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">

        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <!-- <p>Food Donate</p> -->
            <p class="logo">ResQ<b style="color: #06C167; ">Food</b></p>
            <p class="user"></p>
            <!-- <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div> -->

            <!--<img src="images/profile.jpg" alt="">-->
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-chart"></i>
                    <span class="text">Analytics</span>
                </div>

                <!-- Analytics boxes displaying key metrics -->
                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-user"></i>
                        <span class="text">Total users</span>
                        <span class="number"><?php echo $totalUsers; ?></span>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-comments"></i>
                        <span class="text">Feedbacks</span>
                        <span class="number"><?php echo $totalFeedbacks; ?></span>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-heart"></i>
                        <span class="text">Total donations</span>
                        <span class="number"><?php echo $totalDonations; ?></span>
                    </div>
                </div>
                <br>
                <br>

                <canvas id="myChart" style="width:100%;max-width:600px"></canvas>

                <script>
                    <?php
                    $query = "SELECT count(*) as count FROM  login where gender=\"male\"";
                    $q2 = "SELECT count(*) as count FROM  login where gender=\"female\"";
                    $result = mysqli_query($connection, $query);
                    $res2 = mysqli_query($connection, $q2);
                    $row = mysqli_fetch_assoc($result);
                    $ro2 = mysqli_fetch_assoc($res2);
                    $female = $ro2['count'];
                    $male = $row['count'];


                    ?>
                    var xValues = ["Male", "Female"];
                    var yValues = [<?php echo json_encode($male, JSON_HEX_TAG); ?>, <?php echo json_encode($female, JSON_HEX_TAG); ?>, 30];
                    var barColors = ["#06C167", "blue"];

                    new Chart("myChart", {
                        type: "bar",
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                            }]
                        },
                        options: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: "User details"
                            }
                        }
                    });
                </script>

            </div>
        </div>
    </section>
    <script src="admin.js"></script>
</body>

</html>