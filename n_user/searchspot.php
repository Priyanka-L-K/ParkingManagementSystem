<?php
// Start session
session_start();

// Check if user is logged in
if (isset($_SESSION['username'])) {
  // User is logged in, so you can use their ID to identify them
  $user_name = $_SESSION['username'];
} else {
  // User is not logged in, so redirect them to the login page
  header('Location: n_login.php');
  exit;
}

// Connect to the database and get available spots data
$host = 'localhost';
$hostname = 'root';
$password = '';
$dbname = 'test';
$conn = new mysqli($host, $hostname, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $garage_name = $_POST['garage_name'];
  // Check if garage name is valid
  $garage_query = "SELECT * FROM garages WHERE name='$garage_name'";
  $garage_result = $conn->query($garage_query);
  if ($garage_result->num_rows > 0) {
    $garage = $garage_result->fetch_assoc();
    $garage_id = $garage['id'];
    // Check if there are available spots in the garage
    $spots_query = "SELECT * FROM available_spots WHERE garage_id=$garage_id";
    $spots_result = $conn->query($spots_query);
    if ($spots_result->num_rows > 0) {
      $spots = $spots_result->fetch_assoc();
      $available_spots = $spots['available_spots'];
      if ($available_spots > 0) {
        // Reserve a spot and update the available_spots and reservations tables
        $new_available_spots = $available_spots - 1;
        $update_query = "UPDATE available_spots SET available_spots=$new_available_spots WHERE garage_id=$garage_id";
        if ($conn->query($update_query) === TRUE) {
          $insert_query = "INSERT INTO reservations (garage_id, user_name, reserved_on) VALUES ($garage_id, '$user_name', NOW())";
          if ($conn->query($insert_query) === TRUE) {
            // Redirect to pageA after reservation is made
            echo "<script>alert('Spot reserved!');</script>";
            echo "<script>window.location = 'reservations.php';</script>";
            exit;
          } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
          }
        } else {
          echo "Error: " . $update_query . "<br>" . $conn->error;
        }
      } else {
        echo "<script>alert('Success'); window.location.href='dashhome.php';</script>";
      }
    } else {
      echo "<script>alert('Success'); window.location.href='dashhome.php';</script>";
    }
  } else {
    echo "<script>alert('Success'); window.location.href='dashhome.php';</script>";
  }
}

$sql = "SELECT * FROM available_spots";
$result = $conn->query($sql);
$spots = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $spots[] = $row;
    }
}
$conn->close();
?>
<!-- <!DOCTYPE html>
<html>
<head>
  <title>Parking Garage Availability</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body> -->
  <!DOCTYPE html>
<html>
<head>
  <title>Responsive Search Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../common-css/common.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<style type="text/css">
  body {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 10vh;
  /*background-color: #f5f5f5;*/
  padding: 5px;
  margin-top: 5px;
  margin-bottom: 20px;
/*  border-radius: 20px;*/
}
.header {
  /*width: 30%;*/
  /*margin: 50px auto 0px;*/
  color: black;
  /*background: #5F9EA0;*/
  text-align: center;
  border: 1px solid #B0C4DE;
  border-bottom: none;
  border-radius: 10px 10px 0px 0px;
  padding: 20px;
}
h1 {
  font-size: 2rem;
  color: #333;
  text-align: center;
  /*text-shadow: 2px 2px 0px rgba(0,0,0,0.1);
  background-image: linear-gradient(45deg, #6fc3df, #c4e0e5);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;*/
}

section {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 50vh;

}

form {
  display: flex;
  align-items: center;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

input[type="text"] {
  padding: 10px;
  border-width: 3px;
  border-radius: 5px;
  flex: 1;
  width: 270px;
}

button[type="submit"] {
  padding: 10px;
  background-color: #333;
  color: #fff;
  border: none;
  border-radius: 5px;
  margin-top: 10px;
  margin-left: 10px;
  cursor: pointer;
}

@media only screen and (max-width: 600px) {
  form {
    flex-direction: column;
  }
}

  *{
    margin:0;
    padding: 0;
    font-family: sans-serif;
    box-sizing: border-box;
  }
  .hero{
    width: 100%;
    min-height: 100%;
    background: #eceaff;
    color: #525252;
  }
  nav{
    /*background: #1a1a1a;*/
    width: 100%;
    padding: 10px 10%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
  }
  .logo{
    width: 120px;
  }
  .user-pic{
    width: 40px;
    border-radius: 50%;
    cursor: pointer;
    margin-left: 30px;
  }
  nav ul li{
    display: inline-block;
    list-style: none;
    margin: 10px 20px;
  }
  nav ul li a{
    color: #fff;
    text-decoration: none;
  }
  .sub-menu-wrap{
    position: absolute;
    top: 100%;
    right: 10%;
    width: 270px;
    max-height: 0px;
    overflow: hidden;
    transition: max-height 0.5s;
    /*background-color: black;*/
  }
  .sub-menu-wrap.open-menu{
    max-height: 400px;
  }

  .sub-menu{
    background: #fff;
    padding: 20px;
    margin: 10px; 
    /*width: 40px; */
  }
  .user-info{
    display: flex;
    align-items: center;
  }
  .user-info h3{
    font-weight: 500;
  }
  .user-info img{
    width: 60px;
    border-radius: 50%;
    margin-right: 15px;
  }
  .sub-menu hr{
    border:0;
    height: 1px;
    width: 100%;
    /*background: #ccc;*/
    margin: 15px 0 10px;
  }
  .sub-menu-link{
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #525252;
    margin: 12px 0;
  }
  .sub-menu-link p{
    width: 100%;
  }
  .sub-menu-link img{
    width: 40px;
    background: #e5e5e5;
    border-radius: 50%;
    padding: 8px;
    margin-right: 15px; 
  }
  .sub-menu-link span{
    font-size: 22px;
    transition: transform 0.5s;
  }
  .sub-menu-link: hover span{
    transform: translateX(5px);
  }
  .sub-menu-link:hover p{
    font-weight: 600;
  }

.results {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.resu.results {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.result {
  width: 80%;
  padding: 10px;
  margin-bottom: 20px;
  background-color: #f1f1f1;
  display: flex;
  flex-wrap: wrap;
}

.result-info {
  flex: 1;
}

.result-info h2 {
  margin: 0;
}

.result-info a {
  color: #333;
  text-decoration: none;
}

.result-info a:hover {
  text-decoration: underline;
}

.result-info p {
  margin: 10px 0;
}

.result-parking {
  flex: 0 0 20%;
  display: flex;
  align-items: center;
  justify-content: center;
  /*background-color: #2196f3;*/
  color: #fff;
}

.result-parking p {
  background-color: #333;
  border: none;
  border-radius: 3px;
  color: #fff;
  cursor: pointer;
  font-size: 10px;
  padding: 10px;
  margin-left: -115px;
}

.result-parking1 p {
  background-color: #333;
  border: none;
  border-radius: 3px;
  color: #fff;
  cursor: pointer;
  font-size: 10px;
  padding: 10px;
  width: 90px;
  margin-left: 170px;
  margin-top: -32px;
}

@media screen and (max-width: 768px) {
  .result {
    flex-direction: column;
  }

  .result-parking {
    flex: 1;
    margin-top: 10px;
  }
}

footer {
  background-color: #555;
  padding: 20px;
  text-align: center;
  color: #fff;
}
  
.container1 {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      align-items: center;
      background-color: #f2f2f2;
    }
    
    .box {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 300px;
      height: 150px;
      margin: 10px;
      background-color: #fff;
      box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
      border-radius: 5px;
    }
    
    .heading {
      font-size: 24px;
      margin-bottom: 20px;
    }
    
    .button {
      padding: 10px 20px;
      margin-bottom:20px;
      background-color: #4CAF50;
      color: #fff;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .btn {
  padding: 10px;
  font-size: 15px;
  color: white;
  background: #5F9EA0;
  border: none;
  border-radius: 5px;
}
</style>

<body>
  <div class="hero">
    <nav>
      <!-- <img src="images/logo.png" class="logo"> -->
      <input id="nav-toggle" type="checkbox">
            <a class="logo" href="#" style="text-align: center; margin-left:70px;"><h2>MavPark</h2> 
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
            <h3>James</h3>
          </div>
          <hr>

          <a href="#" class="sub-menu-link">
            <!-- <img src="../images/profile.png"> -->
            <p><a style="text-decoration: none; color: #525252;
            " href="../Dashboard/dashhome.html">My Profile</a></p>
          </a>

          <a href="#" class="sub-menu-link">
            <!-- <img src="../images/logout.png"> -->
            <p><a style="text-decoration: none; color: #525252;
            " href="../home-page/test3.html">Logout</a></p>
          </a>
        </div>
      </div>
    </nav>
  </div>

    <div class="header" style="/*width: 30%;*/
  /*margin: 50px auto 0px;*/
  color: black;
  /*background: #5F9EA0;*/
  text-align: center;
  border: 1px solid #B0C4DE;
  border-bottom: none;
  border-radius: 10px 10px 0px 0px;
  padding: 20px;">
  <div class="header">
    <h2>Parking Garage Availability</h2>
  </div>
  <div class="content">
    <?php if (count($spots) > 0) { ?>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Available Spots</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($spots as $spot) { ?>
        <tr>
          <td><?php echo $spot['garage_name']; ?></td>
          <td><?php echo $spot['available_spots']; ?></td>
          <td>
            <?php if ($spot['available_spots'] > 0) { ?>
              <form method="POST">
                <input type="hidden" name="garage_name" value="<?php echo $spot['garage_name']; ?>">
                <button class="btn" type="submit">Reserve</button>
              </form>
            <?php } else { ?>
              No spots available
            <?php } ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php } else { ?>
      <p>No available spots.</p>
    <?php } ?>
  </div>
</body>

<footer>
    <p>&copy; 2023 MAVSPARK. All rights reserved.</p>
  </footer>
  <script type="text/javascript">
  let subMenu = document.getElementById("subMenu");

  function toggleMenu(){
    subMenu.classList.toggle("open-menu");
  }
</script>

</html>
