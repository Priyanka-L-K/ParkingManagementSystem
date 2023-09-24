<?php
// Start session
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if user is logged in
if (isset($_SESSION["username"])) {
    // User is logged in, so you can use their ID to identify them
    $user_name = $_SESSION["username"];
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

// Get garages with available spots
$today = date("Y-m-d");
$sql = "SELECT g.id, g.name, g.address, g.rent, g.spots - IFNULL(r.reserved_spots, 0) as available_spots
FROM garages g
LEFT JOIN (
    SELECT garage_id, DATE(reserved_on) as reserved_date, COUNT(id) as reserved_spots
    FROM reservations
    GROUP BY garage_id, reserved_date
) r ON g.id = r.garage_id AND r.reserved_date = '$today'
WHERE g.spots - IFNULL(r.reserved_spots, 0) > 0";

$result = $conn->query($sql);

if (!$result) {
  printf("Error: %s\n", $conn->error);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get garage ID from the submitted form
  $garage_id = $_POST['garage_id'];

  // Check if the garage has available spots
  $sql = "SELECT g.spots - IFNULL(r.reserved_spots, 0) as available_spots
  FROM garages g
  LEFT JOIN (
      SELECT garage_id, DATE(reserved_on) as reserved_date, COUNT(id) as reserved_spots
      FROM reservations
      WHERE garage_id = $garage_id AND reserved_on BETWEEN DATE(NOW()) AND DATE_ADD(DATE(NOW()), INTERVAL 1 DAY)
      GROUP BY garage_id, reserved_date
  ) r ON g.id = r.garage_id AND r.reserved_date = '$today'
  WHERE g.id = $garage_id";

  $result = $conn->query($sql);

  if (!$result) {
    printf("Error: %s\n", $conn->error);
    exit();
  }

  $row = $result->fetch_assoc();
  $available_spots = $row['available_spots'];

  if ($available_spots > 0) {
    // Display a confirmation pop-up window
    echo "<script>
            if (confirm('Are you sure you want to reserve this spot?')) {
              window.location.href = 'make_reservation.php?garage_id=$garage_id';
            }
          </script>";
  } else {
    // Display an error message
    echo "<script>alert('Sorry, this garage is full. Please select another garage.');</script>";
  }
}

$conn->close();

?>
<!DOCTYPE html>
<html>
<head>
  <title>Search Parking</title>
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
        <li><a href="dashhome.php">Dashboard</a></li>
        <li><a href="searchpage.html">Search Parking</a></li>
        <li><a href="manage_vehicles.php">Add Vehicle</a></li>
        <li><a href="n_helps.html">Help & Support</a></li>
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
            <h3><?php echo $user_name; ?></h3>
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
    <h2>Search Parking</h2>
  </div>

  <div class="content">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Address</th>
          <th>Rent</th>
          <th>Available Spots</th>
          <th>Reserve</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['rent']; ?></td>
            <td><?php echo $row['available_spots']; ?></td>
            <td>
            <form action="make_reservation.php" method="POST" onsubmit="return confirmReservation()">
                <input type="hidden" name="garage_id" value="<?php echo $row['id']; ?>">
                <button type="submit">Reserve</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
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

    function confirmReservation() {
      let r = confirm("Are you sure you want to make this reservation?");
      if (r) {
        alert("Reservation successful!");
        return true;
      } else {
        return false;
      }
    }
  </script>
</body>
</html>