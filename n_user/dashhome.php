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
  background-color: #f5f5f5;
  padding: 5px;
  margin-top: 5px;
  margin-bottom: 20px;
/*  border-radius: 20px;*/
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
            <a class="logo" style="text-align: center; margin-left:70px;"><h2>MavPark</h2> 
            </a>
           
                <!-- <ul class="main-links">
                    <li><a href="dashhome.php">Dashboard</a></li>
                    <li><a href="searchpage.html">Search Parking</a></li>
                    <li><a href="manage_vehicles.php">Add Vehicle</a></li>
                    <li><a href="../Dashboard/helps.html">Help & Support</a></li>
                </ul> -->
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
					</div>
					<hr>

					<a href="#" class="sub-menu-link">
						<!-- <img src="../images/logout.png"> -->
						<p><a style="text-decoration: none; color: #525252;
						" href="../home-page/test3.html">Logout</a></p>
					</a>
				</div>
			</div>
		</nav>
	</div>
	<!-- <div class="container">
	<h1>Search Results</h1>
	</div>
    <div class="results">
      <div class="result">
        <div class="result-info">
          <h2><a href="#">Maverick Parking Garage</a></h2>
          <p>708 S. West St.</p>
        </div>
        <div class="result-parking">
          <p>Parking Spaces Available: 10</p>
        </div>
        <div class="result-parking1">
          <p>Reserve space</p>
        </div>
      </div>
      <div class="result">
        <div class="result-info">
          <h2><a href="#">LOT 39</a></h2>
          <p>400 S. Spaniolo St</p>
        </div>
        <div class="result-parking">
          <p>Parking Spaces Available: 5</p>
        </div>
        <div class="result-parking1">
          <p>Reserve space</p>
        </div>
      </div>
      <div class="result">
        <div class="result-info">
          <h2><a href="#">Park South Garage</a></h2>
          <p>550 S. Center St.</p>
        </div>
        <div class="result-parking">
          <p>Parking Spaces Available: 3</p>
        </div>
        <div class="result-parking1">
          <p>Reserve space</p>
        </div>
      </div>
      <div class="result">
        <div class="result-info">
          <h2><a href="../Dashboard/dummysearches1.html">West Campus Garage</a></h2>
          <p>804 UTA Blvd.</p>
        </div>
        <div class="result-parking">
          <p>Parking Spaces Available: 14</p>
        </div>
        <div class="result-parking1">
          <p><a style="text-decoration: none; color: white;" href="../Dashboard/dummysearches1.html">Reserve space</p>
        </div>
      </div>
    </div>
<footer>
    <p>&copy; 2023 PriyankaLakur. All rights reserved.</p>
  </footer>
	<script type="text/javascript">
	let subMenu = document.getElementById("subMenu");

	function toggleMenu(){
		subMenu.classList.toggle("open-menu");
	}
</script> -->
<form method="post" action="process.php">
	<div class="container1">
		<!-- <div class="box">
			<h2 class="heading">Parking Lot Reservations</h2>
			<button type="submit" class="btn" name="reservations1">View Reservations</button>
		</div>
		<div class="box">
			<h2 class="heading">Garage Reservations</h2>
			<button type="submit" class="btn" name="reservations">View Reservations</button>
		</div> -->
		<div class="box">
			<h2 class="heading">Reservations</h2>
			<button type="submit" class="btn" name="reservations">View Reservations</button>
		</div>
		<div class="box">
			<h2 class="heading">Search Parking</h2>
			<button type="submit" class="btn" name="search">Search</button>
		</div>
		<div class="box">
			<h2 class="heading">Manage Vehicles</h2>
			<button type="submit" class="btn" name="manage">Manage</button>
		</div>
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
