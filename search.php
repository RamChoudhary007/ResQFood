<?php
include("connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $_POST['location'];
    $category = $_POST['category'];

    $connection = mysqli_connect("localhost", "root", "", "demo");
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $location = mysqli_real_escape_string($connection, $location);
    $category = mysqli_real_escape_string($connection, $category);

    $sql = "SELECT * FROM food_donations WHERE location='$location' AND category='$category'";
    $result = mysqli_query($connection, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Food Donations</title>
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <div class="search-section" style="max-width: 900px; margin: 20px auto; padding: 20px; background-color: #06C167; color: white; border-radius: 10px;">
        <h2 style="color: white; text-align: center;">Search Results</h2>
        <?php
        if (isset($result)) {
            if (mysqli_num_rows($result) > 0) {
                echo "<div class='table-container'>";
                echo "<table class='search-results' style='background-color: white; color: black; margin: 0 auto;'>";
                echo "<thead><tr><th>Name</th><th>Food</th><th>Type</th><th>Category</th><th>Phone No</th><th>Date/Time</th><th>Address</th><th>Quantity</th></tr></thead><tbody>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td data-label='Name'>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td data-label='Food'>" . htmlspecialchars($row['food']) . "</td>";
                    echo "<td data-label='Type'>" . htmlspecialchars($row['type']) . "</td>";
                    echo "<td data-label='Category'>" . htmlspecialchars($row['category']) . "</td>";
                    echo "<td data-label='Phone No'>" . htmlspecialchars($row['phoneno']) . "</td>";
                    echo "<td data-label='Date/Time'>" . htmlspecialchars($row['date']) . "</td>";
                    echo "<td data-label='Address'>" . htmlspecialchars($row['address']) . "</td>";
                    echo "<td data-label='Quantity'>" . htmlspecialchars($row['quantity']) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "<p style='text-align: center; color: white;'>No food donations found for the selected location and category.</p>";
            }
        } else {
            echo "<p style='text-align: center; color: white;'>Please submit the search form.</p>";
        }
        ?>
        <div style="text-align: center; margin-top: 20px;">
            <button onclick="window.location.href='home.html'" style="background-color: white; color: #06C167; padding: 10px 30px; font-size: 18px; border: none; border-radius: 5px; cursor: pointer;">Back to Main Menu</button>
        </div>
    </div>
</body>

</html>