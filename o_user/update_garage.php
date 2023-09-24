<?php
// Start session
session_start();

// Check if user is logged in
if (isset($_SESSION["username"])) {
    // User is logged in, so you can use their ID to identify them
    $user_name = $_SESSION["username"];
} else {
    // User is not logged in, so redirect them to the login page
    header("Location: n_login.php");
    exit();
}

// Connect to the database
$host = "localhost";
$hostname = "root";
$password = "";
$dbname = "test";
$conn = new mysqli($host, $hostname, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the garage details of the logged-in user
$username = $_SESSION["username"];
$sql = "SELECT g.* FROM garages g JOIN owner_users u ON g.owner_id = u.id WHERE u.username = '$username'";
$result = $conn->query($sql);

// Add a new garage detail or update an existing garage detail
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $ev_charge = $_POST["ev_charge"];
    $cctv = $_POST["cctv"];
    $garage_air_compressor = $_POST["garage_air_compressor"];
    $rent = $_POST["rent"];

    if (isset($_POST["garage_id"])) {
        // Update existing garage detail
        $garage_id = $_POST["garage_id"];

        // If garage name is not entered, use existing garage name
        if (empty($name)) {
            $sql = "SELECT name FROM garages WHERE id=$garage_id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $name = $row["name"];
        }

        $sql = "UPDATE garages SET name='$name', start_time='$start_time', end_time='$end_time', ev_charge='$ev_charge', cctv='$cctv', garage_air_compressor='$garage_air_compressor', rent='$rent' WHERE id=$garage_id AND owner_id=(SELECT id FROM owner_users WHERE username='$username')";
        if ($conn->query($sql) === true) {
            // Show pop-up window with success message and redirect to o_dashhome.php
            echo '<script>alert("Garage details updated successfully!"); window.location.href = "o_dashhome.php";</script>';
            exit();
        } else {
            echo "Error updating garage details: " . $conn->error;
        }
    } else {
        // Add new garage detail
        $sql = "INSERT INTO garages (name, start_time, end_time, ev_charge, cctv, garage_air_compressor, rent, owner_id) VALUES ('$name', '$start_time', '$end_time', '$ev_charge', '$cctv', '$garage_air_compressor', '$rent', (SELECT id FROM owner_users WHERE username='$username'))";
        if ($conn->query($sql) === true) {
            // Show pop-up window with success message and redirect to o_dashhome.php
            echo '<script>alert("New garage added successfully!"); window.location.href = "o_dashhome.php";</script>';
            exit();
        } else {
            echo "Error adding new garage: " . $conn->error;
        }
    }
}

// Delete an existing garage detail
if (isset($_POST["delete"])) {
$garage_id = $_POST["garage_id"];
$sql = "DELETE FROM garages WHERE id=$garage_id AND owner_id=(SELECT id FROM owner_users WHERE username='$username')";
if ($conn->query($sql) === true) {
// Show pop-up window with success message and redirect to o_dashhome.php
echo '<script>alert("Garage deleted successfully!"); window.location.href = "o_dashhome.php";</script>';
exit();
} else {
echo "Error deleting garage: " . $conn->error;
}
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Update Garage Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../common-css/common.css">
  <link rel="stylesheet" type="text/css" href="../common-css/updateGarageDetails.css">
</head>
<link rel="stylesheet" type="text/css" href="extra_common.css">
<body>
  <div class="hero">
    <nav>
      <!-- <img src="images/logo.png" class="logo"> -->
      <input id="nav-toggle" type="checkbox">
      <a class="logo" href="#" style="text-align: center; margin-left:70px;"><h2>MavPark</h2></a>
      <ul class="main-links">
        <li><a href="o_dashhome.php">Dashboard</a></li>
        <li><a href="current_reservations.php">Current Reservations</a></li>
        <li><a href="old_reservations.php">Old Reservations</a></li>
        <li><a href="view_garage.php">View Garages</a></li>
        <!-- <li><a href="../Dashboard/helps.html">Help & Support</a></li> -->
      </ul>
      <label for="nav-toggle" class="burger-icon">
        <div class="h-line"></div>
        <div class="h-line"></div>
        <div class="h-line"></div>
        <div class="h-line"></div>
      </label>
      <img src="../images/user.png" class="user-pic" onclick="toggleMenu()">
      <div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
          <div class="user-info">
            <img src="../images/user.png">
            <h3><?php echo "$_SESSION[username]"; ?></h3>
          </div>
          <hr>
          <a href="#" class="sub-menu-link">
            <p><a style="text-decoration: none; color: #525252;" href="../Dashboard/dashhome.html">My Profile</a></p>
          </a>
          <a href="#" class="sub-menu-link">
            <p><a style="text-decoration: none; color: #525252;" href="../home-page/test3.html">Logout</a></p>
          </a>
        </div>
      </div>
    </nav>
  </div>
  <div class="header" style="color: black; text-align: center; border: 1px solid #B0C4DE; border-bottom: none; border-radius: 10px 10px 0px 0px; padding: 20px;">
    <h2>ADD / Update Garage Details</h2>
  </div>
  <form method="POST">
    <table>
      <tr>
        <td>
        <label for="garage_id">Select a garage to edit:</label>
</td>
<td>
<select name="garage_id" id="garage_id">
      <?php while ($row = $result->fetch_assoc()) { ?>
        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
      <?php } ?>
    </select>
</td>
</tr>
<tr>
        <td>
        <label for="name">Garage Name:</label>
</td>
<td><input type="text" id="name" name="name">
</td>
</tr>
<tr>
        <td><label for="start_time">Opening Time:</label></td>
        <td><input type="time" id="start_time" name="start_time"></td>
</tr>
<tr>
        <td><label for="end_time">Closing Time:</label></td>
        <td><input type="time" id="end_time" name="end_time"></td>
</tr>
<tr>
        <td><label for="ev_charge">EV Charge Availability:</label></td>
        <td><select name="ev_charge" id="ev_charge">
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select></td>
</tr>
<tr>
        <td><label for="cctv">CCTV Availability:</label></td>
        <td><select name="cctv" id="cctv">
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select></td>
</tr>
<!-- <tr>
        <td>label for="garage_air_compressor">Garage Air Compressor Availability:</label></td>
        <td><select name="garage_air_compressor" id="garage_air_compressor">
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select></td>
</tr> -->
<tr>
        <td><label for="rent">Rent:</label></td>
        <td><input type="text" id="rent" name="rent"></td>
</tr>
<tr>
        <td><input type="submit" name="delete" value="Delete">  </td>
        <td><input type="submit" name="submit" value="Submit"></td>
</tr>
</table>
    <!-- <label for="garage_id">Select a garage to edit:</label>
    <select name="garage_id" id="garage_id">
      <?php while ($row = $result->fetch_assoc()) { ?>
        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
      <?php } ?>
    </select>
    <br><br>
    <div>
    <label for="name">Garage Name:</label>
    <input type="text" id="name" name="name">
    <br><br>
      </div>
    <label for="start_time">Opening Time:</label>
    <input type="time" id="start_time" name="start_time">
    <br><br>
    <label for="end_time">Closing Time:</label>
    <input type="time" id="end_time" name="end_time">
    <br><br>
    <label for="ev_charge">EV Charge Availability:</label>
    <select name="ev_charge" id="ev_charge">
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select>
    <br><br>
    <label for="cctv">CCTV Availability:</label>
    <select name="cctv" id="cctv">
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select>
    <br><br>
    <label for="garage_air_compressor">Garage Air Compressor Availability:</label>
    <select name="garage_air_compressor" id="garage_air_compressor">
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select>
    <br><br>
    <label for="rent">Rent:</label>
    <input type="text" id="rent" name="rent"> -->
    
    <!-- <input type="submit" name="submit" value="Submit">
    <input type="submit" name="delete" value="Delete"> -->
  </form>
</body>
<script type="text/javascript" src="../common-js/common.js"></script>
</html>