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

// Connect to the database and get available spots data
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
  echo "<script>alert('Owner Not Found'); window.location.href='o_dashhome.php';</script>";
    exit();
}

// Get garage IDs owned by the owner
$sql = "SELECT id FROM garages WHERE owner_id = '$owner_id'";
$result = $conn->query($sql);

$garage_ids = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($garage_ids, $row["id"]);
    }
} else {
  echo "<script>alert('No Reservations Found'); window.location.href='o_dashhome.php';</script>";
    exit();
}

// Get reservations made for today's date for the garage IDs owned by the owner
$today = date("Y-m-d");
$garage_ids_str = implode(",", $garage_ids);
// echo "Today's date: $today<br>";
// echo "Garage IDs: $garage_ids_str<br>";

$sql = "SELECT r.id, r.garage_id, u.username, u.mobile, r.reserved_on, r.rent
        FROM reservations r
        JOIN users u ON r.user_name = u.username
        WHERE DATE(r.reserved_on) < CURDATE() AND r.garage_id IN ($garage_ids_str)
        ORDER BY r.reserved_on DESC";

$result = $conn->query($sql);
if (!$result) {
  printf("Error: %s\n", $conn->error);
  exit();
}


$total_rent = 0;

?>

<!DOCTYPE html>
<html>
<head>
  <title>View Reservation History</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../common-css/common.css">
  <link rel="stylesheet" type="text/css" href="extra_common.css">
  <link rel="stylesheet" type="text/css" href="../common-css/viewReservations.css">
</head>
<body>
  <div class="hero">
    <nav>
      <input id="nav-toggle" type="checkbox">
      <a class="logo" href="#" style="text-align: center; margin-left:70px;">
        <h2>MavPark</h2> 
      </a>
      <ul class="main-links">
        <li><a href="o_dashhome.php">Dashboard</a></li>
        <li><a href="current_reservations.php">Current Reservations</a></li>
        <!-- <li><a href="old_reservations.php">Old Reservations</a></li> -->
        <li><a href="update_garage.php">Update Garage Details</a></li>
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
    <h2>View Current Reservations</h2>
  </div>
  <div class="content">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Garage ID</th>
          <th>User Name</th>
          <th>User Mobile</th>
          <th>Reserved Date</th>
          <th>Rent</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $garage_id = $row["garage_id"];
        $username = $row["username"];
        $mobile = $row["mobile"];
        $reserved_on = $row["reserved_on"];
        $rent = $row["rent"];
        // Output the data to the table
        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$garage_id</td>";
        echo "<td>$username</td>";
        echo "<td>$mobile</td>";
        echo "<td>$reserved_on</td>";
        echo "<td>$rent</td>";
        echo "</tr>";
        // Add to the total rent
        $total_rent += $rent;
      } ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5" style="text-align:right;"><b>Total Rent : $</b></td>
          <td><b><?php echo $total_rent; ?></b></td>
        </tr>
      </tfoot>
    </table>
</div>

  <footer>
    <p>&copy; 2023 MAVSPARK. All rights reserved.</p>
  </footer>
  <script type="text/javascript">
    let subMenu = document.getElementById("subMenu");

    function toggleMenu(){
      subMenu.classList.toggle("open-menu");
    }
  </script>
</body>
</html>
