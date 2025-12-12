<?php
// $connection = mysqli_connect("localhost:3307", "root", "");
// $db = mysqli_select_db($connection, 'demo');
include("connect.php");
if ($_SESSION['name'] == '') {
    header("location:signin.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Document</title>
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
                <li><a href="analytics.php">
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
                <li><a href="#">
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
            <p class="logo">Your <b style="color: #06C167; ">History</b></p>
            <p class="user"></p>
            <!-- <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div> -->

            <!--<img src="images/profile.jpg" alt="">-->
        </div>
        <br>
        <br>
        <br>
        <div class="admin-details">
            <h2>Admin Details</h2>
            <p><strong>Name:</strong> <?php echo $_SESSION['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
        </div>
        <br>
        <div class="activity">
            <div class="table-container">

                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Food</th>
                                <th>Category</th>
                                <th>Phone No</th>
                                <th>Date/Time</th>
                                <th>Address</th>
                                <th>Quantity</th>
                                <th>Actions</th>



                            </tr>
                        </thead>
                        <?php



                        // Check if admin email matches a user email
                        $admin_email = $_SESSION['email'];
                        $check_user = "SELECT * FROM login WHERE email = '$admin_email'";
                        $user_result = mysqli_query($connection, $check_user);

                        if (mysqli_num_rows($user_result) > 0) {
                            // Fetch donations for the matching user
                            $sql = "SELECT * FROM food_donations WHERE email = '$admin_email'";
                            $result = mysqli_query($connection, $sql);

                            if (!$result) {
                                die("Error executing query: " . mysqli_error($connection));
                            }

                            // Fetch the data as an associative array
                            $data = array();
                            while ($row = mysqli_fetch_assoc($result)) {
                                $data[] = $row;
                            }
                        } else {
                            $data = array(); // No matching user, no donations
                        }




                        ?>

                        <tbody>
                            <?php foreach ($data as $row) { ?>
                                <?php echo "<tr><td data-label=\"name\">" . $row['name'] . "</td><td data-label=\"food\">" . $row['food'] . "</td><td data-label=\"category\">" . $row['category'] . "</td><td data-label=\"phoneno\">" . $row['phoneno'] . "</td><td data-label=\"date\">" . $row['date'] . "</td><td data-label=\"Address\">" . $row['address'] . "</td><td data-label=\"quantity\">" . $row['quantity'] . "</td><td><a href='../update_food.php?fid=" . $row['Fid'] . "'>Update</a> | <a href='../delete_food.php?fid=" . $row['Fid'] . "' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a></td>";
                                ?>
                            <?php } ?>
                    </table>
                </div>
            </div>



        </div>
        <!-- <P>Your history</P> -->



    </section>
    <script src="admin.js"></script>
</body>

</html>