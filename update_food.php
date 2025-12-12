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

// Fetch existing data
$query = "SELECT * FROM food_donations WHERE Fid = $fid AND email = '$emailid'";
$result = mysqli_query($connection, $query);
if (mysqli_num_rows($result) == 0) {
  echo "Unauthorized access.";
  exit();
}
$row = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
  $foodname = mysqli_real_escape_string($connection, $_POST['foodname']);
  $meal = mysqli_real_escape_string($connection, $_POST['meal']);
  $category = $_POST['image-choice'];
  $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
  $phoneno = mysqli_real_escape_string($connection, $_POST['phoneno']);
  $address = mysqli_real_escape_string($connection, $_POST['address']);
  $city = mysqli_real_escape_string($connection, $_POST['city']);
  $name = mysqli_real_escape_string($connection, $_POST['name']);

  $update_query = "UPDATE food_donations SET food='$foodname', type='$meal', category='$category', quantity='$quantity', phoneno='$phoneno', location='$city', address='$address', city='$city', name='$name' WHERE Fid=$fid AND email='$emailid'";
  $query_run = mysqli_query($connection, $update_query);
  if ($query_run) {
    echo '<script type="text/javascript">alert("Data updated successfully"); window.location.href="profile.php";</script>';
  } else {
    echo '<script type="text/javascript">alert("Data not updated")</script>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Food Donation</title>
  <link rel="stylesheet" href="loginstyle.css">
</head>

<body style="background-color: #06C167;">
  <div class="container">
    <div class="regformf">
      <form action="" method="post">
        <p class="logo">Update Food <b style="color: #06C167; ">Donate</b></p>

        <div class="input">
          <label for="foodname"> Food Name:</label>
          <input type="text" id="foodname" name="foodname" value="<?php echo htmlspecialchars($row['food']); ?>" required />
        </div>

        <div class="radio">
          <label for="meal">Meal type :</label>
          <br><br>

          <input type="radio" name="meal" id="veg" value="veg" <?php if ($row['type'] == 'veg') echo 'checked'; ?> required />
          <label for="veg" style="padding-right: 40px;">Veg</label>
          <input type="radio" name="meal" id="Non-veg" value="Non-veg" <?php if ($row['type'] == 'Non-veg') echo 'checked'; ?>>
          <label for="Non-veg">Non-veg</label>

        </div>
        <br>
        <div class="input">
          <label for="food">Select the Category:</label>
          <br><br>
          <div class="image-radio-group">
            <input type="radio" id="raw-food" name="image-choice" value="raw-food" <?php if ($row['category'] == 'raw-food') echo 'checked'; ?>>
            <label for="raw-food">
              <img src="img/raw-food.png" alt="raw-food">
            </label>
            <input type="radio" id="cooked-food" name="image-choice" value="cooked-food" <?php if ($row['category'] == 'cooked-food') echo 'checked'; ?>>
            <label for="cooked-food">
              <img src="img/cooked-food.png" alt="cooked-food">
            </label>
            <input type="radio" id="packed-food" name="image-choice" value="packed-food" <?php if ($row['category'] == 'packed-food') echo 'checked'; ?>>
            <label for="packed-food">
              <img src="img/packed-food.png" alt="packed-food">
            </label>
          </div>
          <br>
        </div>
        <div class="input">
          <label for="quantity">Quantity:(number of person /kg)</label>
          <input type="text" id="quantity" name="quantity" value="<?php echo htmlspecialchars($row['quantity']); ?>" required />
        </div>
        <b>
          <p style="text-align: center;">Contact Details</p>
        </b>
        <div class="input">
          <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required />
          </div>
          <div>
            <label for="phoneno">PhoneNo:</label>
            <input type="text" id="phoneno" name="phoneno" maxlength="10" pattern="[0-9]{10}" value="<?php echo htmlspecialchars($row['phoneno']); ?>" required />

          </div>
        </div>
        <div class="input">
          <label for="location"></label>


          <label for="address" style="padding-left: 10px;">Address:</label>
          <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($row['address']); ?>" required /><br>

          <label for="city" style="padding-left: 10px;">City:</label>
          <select id="city" name="city" required>
            <option value="Adajan" <?php if ($row['city'] == 'Adajan') echo 'selected'; ?>>Adajan</option>
            <option value="Althan" <?php if ($row['city'] == 'Althan') echo 'selected'; ?>>Althan</option>
            <option value="Anjana" <?php if ($row['city'] == 'Anjana') echo 'selected'; ?>>Anjana</option>
            <option value="Athwa" <?php if ($row['city'] == 'Athwa') echo 'selected'; ?>>Athwa</option>
            <option value="Bamroli" <?php if ($row['city'] == 'Bamroli') echo 'selected'; ?>>Bamroli</option>
            <option value="Begumpura" <?php if ($row['city'] == 'Begumpura') echo 'selected'; ?>>Begumpura</option>
            <option value="Bhatar" <?php if ($row['city'] == 'Bhatar') echo 'selected'; ?>>Bhatar</option>
            <option value="Bhedvad" <?php if ($row['city'] == 'Bhedvad') echo 'selected'; ?>>Bhedvad</option>
            <option value="Bhestan" <?php if ($row['city'] == 'Bhestan') echo 'selected'; ?>>Bhestan</option>
            <option value="Dabholi" <?php if ($row['city'] == 'Dabholi') echo 'selected'; ?>>Dabholi</option>
            <option value="Dindoli" <?php if ($row['city'] == 'Dindoli') echo 'selected'; ?>>Dindoli</option>
            <option value="Dumbhal" <?php if ($row['city'] == 'Dumbhal') echo 'selected'; ?>>Dumbhal</option>
            <option value="Fulpada" <?php if ($row['city'] == 'Fulpada') echo 'selected'; ?>>Fulpada</option>
            <option value="Gopipura" <?php if ($row['city'] == 'Gopipura') echo 'selected'; ?>>Gopipura</option>
            <option value="Haripura" <?php if ($row['city'] == 'Haripura') echo 'selected'; ?>>Haripura</option>
            <option value="Jahangirabad" <?php if ($row['city'] == 'Jahangirabad') echo 'selected'; ?>>Jahangirabad</option>
            <option value="Jahangirpura" <?php if ($row['city'] == 'Jahangirpura') echo 'selected'; ?>>Jahangirpura</option>
            <option value="Kapadra" <?php if ($row['city'] == 'Kapadra') echo 'selected'; ?>>Kapadra</option>
            <option value="Karanj" <?php if ($row['city'] == 'Karanj') echo 'selected'; ?>>Karanj</option>
            <option value="Katargam" <?php if ($row['city'] == 'Katargam') echo 'selected'; ?>>Katargam</option>
            <option value="Katargam Gotalawadi" <?php if ($row['city'] == 'Katargam Gotalawadi') echo 'selected'; ?>>Katargam Gotalawadi</option>
            <option value="Khatodara" <?php if ($row['city'] == 'Khatodara') echo 'selected'; ?>>Khatodara</option>
            <option value="Laldarwaja" <?php if ($row['city'] == 'Laldarwaja') echo 'selected'; ?>>Laldarwaja</option>
            <option value="Limbayat" <?php if ($row['city'] == 'Limbayat') echo 'selected'; ?>>Limbayat</option>
            <option value="Magob" <?php if ($row['city'] == 'Magob') echo 'selected'; ?>>Magob</option>
            <option value="Mahidharpura" <?php if ($row['city'] == 'Mahidharpura') echo 'selected'; ?>>Mahidharpura</option>
            <option value="Majura" <?php if ($row['city'] == 'Majura') echo 'selected'; ?>>Majura</option>
            <option value="Nanavat" <?php if ($row['city'] == 'Nanavat') echo 'selected'; ?>>Nanavat</option>
            <option value="Nanavarachha" <?php if ($row['city'] == 'Nanavarachha') echo 'selected'; ?>>Nanavarachha</option>
            <option value="Nanpura" <?php if ($row['city'] == 'Nanpura') echo 'selected'; ?>>Nanpura</option>
            <option value="Navagam" <?php if ($row['city'] == 'Navagam') echo 'selected'; ?>>Navagam</option>
            <option value="Pandesara" <?php if ($row['city'] == 'Pandesara') echo 'selected'; ?>>Pandesara</option>
            <option value="Piplod" <?php if ($row['city'] == 'Piplod') echo 'selected'; ?>>Piplod</option>
            <option value="Pisad" <?php if ($row['city'] == 'Pisad') echo 'selected'; ?>>Pisad</option>
            <option value="Rander" <?php if ($row['city'] == 'Rander') echo 'selected'; ?>>Rander</option>
            <option value="Sagrampura" <?php if ($row['city'] == 'Sagrampura') echo 'selected'; ?>>Sagrampura</option>
            <option value="Saiyadpura" <?php if ($row['city'] == 'Saiyadpura') echo 'selected'; ?>>Saiyadpura</option>
            <option value="Salabatpura" <?php if ($row['city'] == 'Salabatpura') echo 'selected'; ?>>Salabatpura</option>
            <option value="Shahpor" <?php if ($row['city'] == 'Shahpor') echo 'selected'; ?>>Shahpor</option>
            <option value="Singanpor" <?php if ($row['city'] == 'Singanpor') echo 'selected'; ?>>Singanpor</option>
            <option value="Sonifalia" <?php if ($row['city'] == 'Sonifalia') echo 'selected'; ?>>Sonifalia</option>
            <option value="Tunki" <?php if ($row['city'] == 'Tunki') echo 'selected'; ?>>Tunki</option>
            <option value="Udhana" <?php if ($row['city'] == 'Udhana') echo 'selected'; ?>>Udhana</option>
            <option value="Umara" <?php if ($row['city'] == 'Umara') echo 'selected'; ?>>Umara</option>
            <option value="Umarwada" <?php if ($row['city'] == 'Umarwada') echo 'selected'; ?>>Umarwada</option>
            <option value="Vadod" <?php if ($row['city'] == 'Vadod') echo 'selected'; ?>>Vadod</option>
            <option value="Ved" <?php if ($row['city'] == 'Ved') echo 'selected'; ?>>Ved</option>
            <option value="Wadifalia" <?php if ($row['city'] == 'Wadifalia') echo 'selected'; ?>>Wadifalia</option>
          </select><br>

        </div>
        <div class="btn">
          <button type="submit" name="submit"> Update</button>

        </div>
      </form>
    </div>
  </div>


</body>

</html>