<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: n_login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: n_login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Responsive Search Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../common-css/common.css">
	<link rel="stylesheet" type="text/css" href="../n_user/style.css">
</head>
<link rel="stylesheet" type="text/css" href="extra_common.css">
<body>
	<div class="hero">
		<nav>
			<!-- <img src="images/logo.png" class="logo"> -->
			<input id="nav-toggle" type="checkbox">
            <a class="logo" style="text-align: center; margin-left:70px;"><h2>MavPark</h2> 
            </a>
           
                <ul class="main-links">
                    <!-- <li><a href="current_reservations.php">Current Reservations</a></li>
                    <li><a href="old_reservations.php">Old Reservations</a></li>
					<li><a href="update_garage.php">Update Garage Details</a></li>
					<li><a href="view_garage.php">View Garages</a></li> -->
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

					<!-- <a href="#" class="sub-menu-link"> -->
						<!-- <img src="../images/profile.png"> -->
						<!-- <p><a style="text-decoration: none; color: #525252;
						" href="../Dashboard/dashhome.html">My Profile</a></p>
					</a> -->

					<a href="#" class="sub-menu-link">
						<!-- <img src="../images/logout.png"> -->
						<p><a style="text-decoration: none; color: #525252;
						" href="../home-page/test3.html">Logout</a></p>
					</a>
				</div>
			</div>
		</nav>
	</div>

<form method="post" action="process.php">
	<div class="container1">
		<div class="box">
			<h2 class="heading">Current Reservations</h2>
			<button type="submit" class="btn" name="currentreservations">View Reservations</button>
		</div>
		<div class="box">
			<h2 class="heading">Old Reservations</h2>
			<button type="submit" class="btn" name="oldreservations">View Reservations</button>
		</div>
		<div class="box">
			<h2 class="heading">Update Garage Details</h2>
			<button type="submit" class="btn" name="search">Update</button>
		</div>
		<div class="box">
			<h2 class="heading">View Garage</h2>
			<button type="submit" class="btn" name="viewgarage">View</button>
		</div>
		<!-- <div class="box">
			<h2 class="heading">Set Availability Time</h2>
			<button type="submit" class="btn" name="manage">Update</button>
		</div> -->
	</div>
</form>
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
