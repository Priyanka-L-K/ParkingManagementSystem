<?php
  session_start(); // Start session

  // Check if user is logged in
  if (isset($_SESSION['username'])) {
    // User is logged in, so you can use their ID to identify them
    $user_name = $_SESSION['username'];
  } else{
  // For deleting    
  if($_GET['del']){
    $catid=$_GET['del'];
    mysqli_query($con,"delete from tblvehicle where ID ='$catid'");
    echo "<script>alert('Data Deleted');</script>";
    echo "<script>window.location.href='dashhome1.php'</script>";
  }
}

  // Rest of your code goes here...
  // Connect to the database and get user's reservations data
  $host = 'localhost';
  $hostname = 'root';
  $password = '';
  $dbname = 'test';
  $conn = new mysqli($host, $hostname, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $user_name = $_SESSION['username'];

  $reservations_query = "SELECT r.reserved_on, g.name AS garage_name FROM reservations r JOIN garages g ON r.garage_id = g.id WHERE r.user_name='$user_name'";
  $reservations_result = $conn->query($reservations_query);
  $reservations = array();
  if ($reservations_result->num_rows > 0) {
    while ($row = $reservations_result->fetch_assoc()) {
      $reservations[] = $row;
    }
  }
  $conn->close();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Parking Garage Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../n_user/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
<!--   <style type="text/css">
    /* Style for header */
.header {
  background-color: #333;
  color: #fff;
  padding: 20px;
  text-align: center;
}

/* Style for content */
.content {
  padding: 20px;
}

/* Style for table */
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
  font-weight: bold;
}

  </style> -->
  <body>
    <div class="header">
      <h2>Parking Garage Dashboard</h2>
    </div>
    <div class="content">
      <?php if (count($reservations) > 0) { ?>
        <table>
          <thead>
            <tr>
              <th>Garage Name</th>
              <th>Reserved On</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reservations as $reservation) { ?>
              <tr>
                <td><?php echo $reservation['garage_name']; ?></td>
                <td><?php echo $reservation['reserved_on']; ?></td>
                <td><a href="dashhome1.php?del=<?php echo $row['ID'];?>" onClick="return confirm('Are you sure you want to delete?')">Delete</a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } else { ?>
        <p>No reservations.</p>
      <?php } ?>
    </div>
  </body>
</html>