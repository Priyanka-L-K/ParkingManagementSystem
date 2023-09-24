<?php
// Start session
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');


// Check if user is logged in
if (isset($_SESSION["username"])) {
    // User is logged in, so you can use their ID to identify them
    $owner_username = $_SESSION["username"];
} else {
    // User is not logged in, so redirect them to the login page
    header("Location: n_login.php");
    exit();
}

// Connect to the database and get garage data
$host = "localhost";
$username = "root";
$password = "";
$dbname = "test";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get owner ID from owner_users table using owner username
$sql = "SELECT id FROM owner_users WHERE username = '$owner_username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $owner_id = $row["id"];
} else {
    echo "Error: Owner not found";
    exit();
}

// Get garage details owned by the owner
$sql = "SELECT * FROM garages WHERE owner_id = '$owner_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $garage_details = "<table>";
    $garage_details .= "<thead><tr><th>ID</th><th>Name</th><th>Address</th><th>Start Time</th><th>End Time</th><th>EV Charge</th><th>CCTV</th><th>Air Compressor</th><th>Rent</th></tr></thead>";
    $garage_details .= "<tbody>";
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $name = $row["name"];
        $address = $row["address"];
        $start_time = $row["start_time"];
        $end_time = $row["end_time"];
        $ev_charge = $row["ev_charge"];
        $cctv = $row["cctv"];
        $air_compressor = $row["garage_air_compressor"];
        $rent = $row["rent"];

        $garage_details .= "<tr>";
        $garage_details .= "<td>$id</td>";
        $garage_details .= "<td>$name</td>";
        $garage_details .= "<td>$address</td>";
        $garage_details .= "<td>$start_time</td>";
        $garage_details .= "<td>$end_time</td>";
        $garage_details .= "<td>$ev_charge</td>";
        $garage_details .= "<td>$cctv</td>";
        $garage_details .= "<td>$air_compressor</td>";
        $garage_details .= "<td>$rent</td>";
        $garage_details .= "</tr>";
    }
    $garage_details .= "</tbody>";
    $garage_details .= "</table>";
} else {
    $garage_details = "No garages found";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../common-css/common.css">
  <link rel="stylesheet" type="text/css" href="extra_common.css">
  <link rel="stylesheet" type="text/css" href="../common-css/viewReservations.css">
</head>
<body>
<div class="container">
    <header>
        
    </header>
    <div class="hero">
    <nav>
      <input id="nav-toggle" type="checkbox">
      <a class="logo" href="#" style="text-align: center; margin-left:70px;">
        <h2>MavPark</h2> 
      </a>
      <ul class="main-links">
        <li><a href="o_dashhome.php">Dashboard</a></li>
        <li><a href="current_reservations.php">Current Reservations</a></li>
        <li><a href="old_reservations.php">Old Reservations</a></li>
        <li><a href="update_garage.php">Update Garage Details</a></li>
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
            <h3><?php echo $owner_username; ?></h3>
          </div>
          <hr>
          <a href="../Dashboard/dashhome.html" class="sub-menu-link">
            <p>My Profile</p>
          </a>
          <a href="../home-page/test3.html" class="sub-menu-link">
            <p>Logout</p>
          </a>
        </div>
      </div>
    </nav>
  </div>
  <div class="header" style="color: black; text-align: center; border: 1px solid #B0C4DE; border-bottom: none; border-radius: 10px 10px 0px 0px; padding: 20px;">
    <h2>View Your Garages</h2>
  </div>
    <main>
      <div style="color: black; text-align: center; border-bottom: none; border-radius: 10px 10px 0px 0px; padding: 20px;">
        <?php echo $garage_details; ?>
</div>
    </main>
    <footer>
        <p>&copy; 2023 MAVSPARK. All rights reserved.</p>
    </footer>
</div>
<script>
    const menuBtn = document.querySelector(".menu-icon span");
    const searchBtn = document.querySelector(".search-icon");
    const cancelBtn = document.querySelector(".cancel-icon");
    const items = document.querySelector(".nav-items");
    const form = document.querySelector("form");
    const subMenu = document.querySelector(".sub-menu");
	menuBtn.onclick = () => {
    items.classList.add("active");
    menuBtn.classList.add("hide");
    searchBtn.classList.add("hide");
    cancelBtn.classList.add("show");
}

cancelBtn.onclick = () => {
    items.classList.remove("active");
    menuBtn.classList.remove("hide");
    searchBtn.classList.remove("hide");
    cancelBtn.classList.remove("show");
    subMenu.classList.remove("open-menu");
}

searchBtn.onclick = () => {
    form.classList.add("active");
    searchBtn.classList.add("hide");
    cancelBtn.classList.add("show");
}

cancelBtn.onclick = () => {
    form.classList.remove("active");
    searchBtn.classList.remove("hide");
    cancelBtn.classList.remove("show");
}

function toggleMenu() {
    subMenu.classList.toggle("open-menu");
}
</script>
</body>
</html>