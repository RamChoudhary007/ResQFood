<?php
// Include login session management
include("login.php");

// Check if user is logged in, redirect to signin if not
if ($_SESSION['name'] == '') {
    header("location: signin.php");
    exit();
}

// Get user email from session
$emailid = $_SESSION['email'];

// Establish database connection
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'demo');

// Handle form submission
if (isset($_POST['submit'])) {
    // Sanitize and validate input data
    $foodname = mysqli_real_escape_string($connection, $_POST['foodname']);
    $meal = mysqli_real_escape_string($connection, $_POST['meal']);
    $category = $_POST['image-choice'];
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $phoneno = mysqli_real_escape_string($connection, $_POST['phoneno']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $city = mysqli_real_escape_string($connection, $_POST['city']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);

    // Use prepared statement for secure database insertion
    $stmt = mysqli_prepare($connection, "INSERT INTO food_donations(email, food, type, category, phoneno, location, address, city, name, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssssssss", $emailid, $foodname, $meal, $category, $phoneno, $city, $address, $city, $name, $quantity);

    if (mysqli_stmt_execute($stmt)) {
        echo '<script type="text/javascript">alert("Data saved successfully!")</script>';
        header("location:delivery.html");
        exit();
    } else {
        echo '<script type="text/javascript">alert("Failed to save data. Please try again.")</script>';
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
    <title>ResQFood</title>
    <link rel="stylesheet" href="loginstyle.css">
</head>

<body style="    background-color: #06C167;">
    <div class="container">
        <div class="regformf">
            <form action="" method="post">
                <p class="logo">ResQ<b style="color: #06C167; ">Food</b></p>

                <!-- Food Name Input -->
                <div class="input">
                    <label for="foodname">Food Name:</label>
                    <input type="text" id="foodname" name="foodname" required />
                </div>

                <!-- Meal Type Selection -->
                <div class="radio">
                    <label for="meal">Meal Type:</label>
                    <br><br>
                    <input type="radio" name="meal" id="veg" value="veg" required />
                    <label for="veg" style="padding-right: 40px;">Veg</label>
                    <input type="radio" name="meal" id="Non-veg" value="Non-veg">
                    <label for="Non-veg">Non-Veg</label>
                </div>
                <br>

                <!-- Food Category Selection with Images -->
                <div class="input">
                    <label for="food">Select the Category:</label>
                    <br><br>
                    <div class="image-radio-group">
                        <input type="radio" id="raw-food" name="image-choice" value="raw-food">
                        <label for="raw-food">
                            <img src="img/raw-food.png" alt="Raw Food">
                        </label>
                        <input type="radio" id="cooked-food" name="image-choice" value="cooked-food" checked>
                        <label for="cooked-food">
                            <img src="img/cooked-food.png" alt="Cooked Food">
                        </label>
                        <input type="radio" id="packed-food" name="image-choice" value="packed-food">
                        <label for="packed-food">
                            <img src="img/packed-food.png" alt="Packed Food">
                        </label>
                    </div>
                    <br>
                </div>

                <!-- Quantity Input -->
                <div class="input">
                    <label for="quantity">Quantity (Kg / Person):</label>
                    <input type="text" id="quantity" name="quantity" required />
                </div>
                <b>
                    <p style="text-align: center;">Contact Details</p>
                </b>
                <div class="input">
                    <!-- <div>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email">
          </div> -->
                    <div>
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo "" . $_SESSION['name']; ?>" required />
                    </div>
                    <div>
                        <label for="phoneno">PhoneNo:</label>
                        <input type="text" id="phoneno" name="phoneno" maxlength="10" pattern="[0-9]{10}" required />

                    </div>
                </div>
                <div class="input">
                    <label for="location"></label>


                    <label for="address" style="padding-left: 10px;">Address:</label>
                    <input type="text" id="address" name="address" required /><br>

                    <label for="city" style="padding-left: 10px;"></label>
                    <select id="city" name="city" required>
                        <option value="Adajan">Adajan</option>
                        <option value="Althan">Althan</option>
                        <option value="Anjana">Anjana</option>
                        <option value="Athwa">Athwa</option>
                        <option value="Bamroli">Bamroli</option>
                        <option value="Begumpura">Begumpura</option>
                        <option value="Bhatar">Bhatar</option>
                        <option value="Bhedvad">Bhedvad</option>
                        <option value="Bhestan">Bhestan</option>
                        <option value="Dabholi">Dabholi</option>
                        <option value="Dindoli">Dindoli</option>
                        <option value="Dumbhal">Dumbhal</option>
                        <option value="Fulpada">Fulpada</option>
                        <option value="Gopipura">Gopipura</option>
                        <option value="Haripura">Haripura</option>
                        <option value="Jahangirabad">Jahangirabad</option>
                        <option value="Jahangirpura">Jahangirpura</option>
                        <option value="Kapadra">Kapadra</option>
                        <option value="Karanj">Karanj</option>
                        <option value="Katargam">Katargam</option>
                        <option value="Katargam Gotalawadi">Katargam Gotalawadi</option>
                        <option value="Khatodara">Khatodara</option>
                        <option value="Laldarwaja">Laldarwaja</option>
                        <option value="Limbayat">Limbayat</option>
                        <option value="Magob">Magob</option>
                        <option value="Mahidharpura">Mahidharpura</option>
                        <option value="Majura">Majura</option>
                        <option value="Nanavat">Nanavat</option>
                        <option value="Nanavarachha">Nanavarachha</option>
                        <option value="Nanpura">Nanpura</option>
                        <option value="Navagam">Navagam</option>
                        <option value="Pandesara">Pandesara</option>
                        <option value="Piplod">Piplod</option>
                        <option value="Pisad">Pisad</option>
                        <option value="Rander">Rander</option>
                        <option value="Sagrampura">Sagrampura</option>
                        <option value="Saiyadpura">Saiyadpura</option>
                        <option value="Salabatpura">Salabatpura</option>
                        <option value="Shahpor">Shahpor</option>
                        <option value="Singanpor">Singanpor</option>
                        <option value="Sonifalia">Sonifalia</option>
                        <option value="Tunki">Tunki</option>
                        <option value="Udhana">Udhana</option>
                        <option value="Umara">Umara</option>
                        <option value="Umarwada">Umarwada</option>
                        <option value="Vadod">Vadod</option>
                        <option value="Ved">Ved</option>
                        <option value="Wadifalia">Wadifalia</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="btn">
                    <button type="submit" name="submit">Submit Donation</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>