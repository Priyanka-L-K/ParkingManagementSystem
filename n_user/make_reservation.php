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

// Connect to the database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "test";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the garage ID and available spots
$garage_id = $_POST['garage_id'];
$today = date("Y-m-d");
$sql = "SELECT spots - IFNULL(SUM(reserved_spots), 0) as available_spots, rent
FROM (
    SELECT COUNT(id) as reserved_spots
    FROM reservations
    WHERE garage_id = $garage_id AND DATE(reserved_on) = '$today'
) as combined_data, garages
WHERE garages.id = $garage_id";

$result = $conn->query($sql);

if (!$result) {
  printf("Error: %s\n", $conn->error);
  exit();
}

$row = $result->fetch_assoc();
$available_spots = $row['available_spots'];
$rent = $row['rent'];

// Check if there are available spots
if ($available_spots > 0) {
  // Insert the reservation
  $reserved_on = date("Y-m-d H:i:s"); // Set the reserved_on date/time
  $sql = "INSERT INTO reservations (garage_id, user_name, reserved_on, rent)
        VALUES ('$garage_id', '$user_name', '$reserved_on', '$rent')";


  if ($conn->query($sql) === TRUE) {
    // Reservation successful
    // Update the garages table by incrementing the number of reserved spots
    $sql = "UPDATE reservations SET reserved_spots = reserved_spots + 1 WHERE garage_id = '$garage_id' AND DATE(reserved_on) = '$today'";
    $conn->query($sql);

    // Send confirmation email to the user
    $sql = "SELECT email FROM users WHERE username = '$user_name'";
    $result = $conn->query($sql);

    if (!$result) {
      printf("Error: %s\n", $conn->error);
      exit();
    }

    $row = $result->fetch_assoc();
    $email = $row['email'];

    // You can replace the placeholder text in the email with your own message
    $subject = "Reservation Confirmation";
    $message = "Dear $user_name,\n\nYour reservation at MavPark has been confirmed. Thank you for using our service!\n\nBest regards,\nThe MavPark Team";
    $headers = "From: mavpark@example.com";

    if (mail($email, $subject, $message, $headers)) {
      // Email sent successfully
      header("Location: dashhome.php?success=true");
    } else {
      // Email failed to send
      header("Location: dashhome.php?success=false");
    }
  } else {
    // Reservation failed
    header("Location: dashhome.php?success=false");
  }
} else {
  // No available spots
  header("Location: dashhome.php?success=false");
}

$conn->close();
