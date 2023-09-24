<?php
	session_start();
	if (isset($_POST['currentreservations'])) {
		header("Location: current_reservations.php");
		exit();
	}

	if (isset($_POST['oldreservations'])) {
		header("Location: old_reservations.php");
		exit();
	}
	
	if (isset($_POST['search'])) {
		// header("Location: searchspot.php");
		header("Location: update_garage.php");
		exit();
	}
	
	if (isset($_POST['viewgarage'])) {
		header("Location: view_garage.php");
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
