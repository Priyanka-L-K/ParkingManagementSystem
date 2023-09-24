<?php
	session_start();
	if (isset($_POST['reservations'])) {
		header("Location: reservations.php");
		exit();
	}

	if (isset($_POST['reservations1'])) {
		header("Location: rent_reservations.php");
		exit();
	}
	
	if (isset($_POST['search'])) {
		// header("Location: searchspot.php");
		header("Location: searchpage.html");
		exit();
	}
	
	if (isset($_POST['manage'])) {
		header("Location: manage_vehicles.php");
		exit();
	}


?>

<!-- If the user submits the form without selecting an option, redirect them back to the home page -->
<!DOCTYPE html>
<html>
<head>
	<title>Parking Management System</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Parking Management System</h1>
		<p>Please select an option.</p>
		<form method="post" action="">
			<button type="submit">Go back</button>
		</form>
	</div>
</body>
</html>
