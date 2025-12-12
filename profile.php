<?php
// Include login session management
include("login.php");

// Check if user is logged in, redirect to signup if not
if ($_SESSION['name'] == '') {
    header("location: signup.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResQFood</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<body>
    <header>
        <div class="logo"><a href="home.html">ResQ<b style="color: #06C167;">Food</b></a></div>
        <div class="hamburger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <nav class="nav-bar">
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Feedback</a></li>
                <li><a href="home.html#help">Help</a></li>
                <li><a href="profile.php" class="active">Profile</a></li>

            </ul>
        </nav>
    </header>
    <!-- Navigation Toggle Script -->
    <script>
        // Hamburger menu toggle functionality
        const hamburger = document.querySelector(".hamburger");
        hamburger.onclick = function() {
            const navBar = document.querySelector(".nav-bar");
            navBar.classList.toggle("active");
        }

        // Confirm logout before redirecting
        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php";
            }
        }
    </script>






    <div class="profile">
        <div class="profilebox" >

            <p class="headingline" style="text-align: left;font-size:30px;">Profile</p>

            <!-- <img src="img/IMG_20240730_102846.jpg" alt="" style="  width: 90px;
            height: 90px;
            /* border-radius:50% ;  */
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding-top: 10px;
             /* border: 1px solid #06C167; */
            ">
            <br> -->
            <p style="font-size: 28px;">Welcome</p>
            <!-- <p style="color: #06C167;">username</p> -->
            <br>
            <div class="info" style="padding-left:30px;">
                <p style=""><b>Name:</b> <?php echo "" . $_SESSION['name']; ?> </p><br>
                <p style=""><b>Email:</b> <?php echo "" . $_SESSION['email']; ?> </p><br>
                <p style=""><b>Gender:</b> <?php echo isset($_SESSION['gender']) ? $_SESSION['gender'] : 'Not specified'; ?> </p><br>
                <!-- <p style="font-family: 'Times New Roman', Times, serif;">gender  :<?php echo "" . $_SESSION['gender']; ?> </p><br>  -->

                <button onclick="confirmLogout()" class="logout-btn" style="float: left;margin-top: 6px ;border-radius:5px; background-color: #06C167; color: white;padding-left: 15px;padding-right: 15px;width: 100px;height: 30px;font-size:20px">Logout</button>
                <!-- <a href="logout.php" style="float: left;margin-top: 6px ;border-radius:10px; background-color: #06C167; color: white;padding: ;padding-left: 10px;padding-right: 10px;">Logout</a> -->
            </div>
            <br>
            <br>



            <hr>
            <br>
            <div class="donations-section" style="padding: 20px 10px; margin-top: 20px;">
                <p class="heading">Your Donations</p>
                <form method="GET" action="profile.php" style="margin-bottom: 15px;">
                    <input type="text" name="search_food" placeholder="Search your food..." value="<?php echo isset($_GET['search_food']) ? htmlspecialchars($_GET['search_food']) : ''; ?>" />
                    <button type="submit">Search</button>
                </form>
                <!-- Donations Table Container -->
                <div class="table-container">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Food</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Date/Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Get user email from session
                                $email = $_SESSION['email'];
                                $search_food = isset($_GET['search_food']) ? mysqli_real_escape_string($connection, $_GET['search_food']) : '';

                                // Prepare query for fetching donations
                                $query = "SELECT * FROM food_donations WHERE email = ?";
                                $params = [$email];
                                $types = "s";

                                if ($search_food != '') {
                                    $query .= " AND food LIKE ?";
                                    $params[] = "%$search_food%";
                                    $types .= "s";
                                }

                                $stmt = mysqli_prepare($connection, $query);
                                mysqli_stmt_bind_param($stmt, $types, ...$params);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                // Display donations in table
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['food']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                                        echo "<td><a href='update_food.php?fid=" . $row['Fid'] . "'>Update</a> | <a href='delete_food.php?fid=" . $row['Fid'] . "' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No donations found.</td></tr>";
                                }

                                mysqli_stmt_close($stmt);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>





</body>

</html>