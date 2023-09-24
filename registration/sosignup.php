<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit']))
  {
    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $mobile=$_POST['mobile'];
    $email=$_POST['email'];
    $password=md5($_POST['password']);

    $ret=mysqli_query($con, "select email from users2 where email='$email' || mobile='$mobile'");
    $result=mysqli_fetch_array($ret);
    if($result>0){

echo '<script>alert("This email or Contact Number already associated with another account")</script>';
    }
    else{
    $query=mysqli_query($con, "insert into users2(firstname, lastname, mobile, email, password) value('$firstname', '$lastname','$mobile', '$email', '$password' )");
    if ($query) {
    
    echo '<script>alert("You have successfully registered")</script>';
  }
  else
    {
      echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
}
  ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration Form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="home.css">
	<link rel="stylesheet" href="../common-css/common.css">
	<style>
		/* Global styles */
		* {
			box-sizing: border-box;
		}

		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
		}

		/* Form styles */
		form {
			background-color: #f2f2f2;
			border-radius: 10px;
			box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
			margin: 20px auto;
			max-width: 500px;
			padding: 20px;
			width: 90%;
		}

		.input-group {
			margin-bottom: 20px;
		}

		label {
			display: block;
			font-weight: bold;
			margin-bottom: 5px;
		}

		input[type="text"],
		input[type="email"],
		input[type="password"],
		textarea,
		select {
			border: 1px solid #ccc;
			border-radius: 3px;
			display: block;
			font-size: 16px;
			padding: 10px;
			width: 100%;
		}

		input[type="submit"] {
			background-color: #333;
			border: none;
			border-radius: 3px;
			color: #fff;
			cursor: pointer;
			font-size: 16px;
			margin-top: 20px;
			padding: 10px;
			width: 100%;
		}

		/* Responsive styles */
	</style>
</head>
<body>
	<nav>
		<input id="nav-toggle" type="checkbox">
		<a class="logo" href="../home-page/test3.html" style="text-align: center; margin-left:20px;"><h2>MavPark</h2></a>
		<ul class="main-links">
			<li><a href="../home-page/test3.html">Home</a></li>
			<li><a href="../about-us-page/about-us.html">About Us</a></li>
			<li><a href="../register/sumne.html">Register</a></li>
			<li><a href="../register/sumnelogin.html">Sign In</a></li>
			<li><a href="../contact/contact-us.html">Contact</a></li>
		</ul>
		<label for="nav-toggle" class="burger-icon">
			<div class="h-line"></div>
			<div class="h-line"></div>
			<div class="h-line"></div>
			<div class="h-line"></div>
		</label>
	</nav>

	<div style="font-size: 24px;margin-bottom: 20px;text-align: center; font-weight: 700; margin-top: 20px;">Registration Form</div>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="firstname">First Name:</label><br>
	<input type="text" id="firstname" name="firstname" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>"><br>

	<label for="lastname">Last Name:</label><br>
	<input type="text" id="lastname" name="lastname" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>"><br>

	<label for="mobile">Mobile Number:</label><br>
	<input type="text" id="mobile" name="mobile" value="<?php echo isset($_POST['mobile']) ? $_POST['mobile'] : ''; ?>"><br>

	<label for="email">Email:</label><br>
	<input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br>

	<label for="password">Password:</label><br>
	<input type="password" id="password" name="password"><br>

	<label for="confirm_password">Confirm Password:</label><br>
	<input type="password" id="confirm_password" name="confirm_password"><br><br>

	<input type="submit" value="Register">
</form>

<?php
if (!empty($error)) {
	echo "<p style='color:red;'>" . $error . "</p>";
}
?>
</body>
</html>