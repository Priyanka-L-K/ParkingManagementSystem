<?php
session_start(); // Start session

// Connect to the database and delete the reservation
$host = 'localhost';
$hostname = 'root';
$password = '';
$dbname = 'test';
$conn = new mysqli($host, $hostname, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (isset($_SESSION['username'])) {
  // User is logged in, so you can use their ID to identify them
  $user_name = $_SESSION['username'];
} else{
// For deleting    
if($_GET['del']){
$catid=$_GET['del'];
          }

// Check if reservation exists and belongs to the current user
$reservation_query = "SELECT * FROM reservations WHERE id='$reservation_id' AND user_name='$user_name'";
$reservation_result = $conn->query($reservation_query);
if ($reservation_result->num_rows == 1) {
  // Reservation exists and belongs to the current user, so delete it
  $delete_query = "DELETE FROM reservations WHERE id='$reservation_id'";
  if ($conn->query($delete_query) === TRUE) {
    // Reservation deleted successfully
    echo "Reservation cancelled successfully.";
  } else {
    // Error deleting reservation
    echo "Error cancelling reservation: " . $conn->error;
  }
} else {
  // Reservation does not exist or does not belong to the current user
  echo "Error cancelling reservation: Reservation not found or does not belong to current user.";
}
$conn->close();
?>
