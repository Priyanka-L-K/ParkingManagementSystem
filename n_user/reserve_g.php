<?php
// Connect to the database and get available spots data
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'test';
$conn = new mysqli($host, $username, $password, $dbname);
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
        // Reserve a spot and update the available_spots table
        $new_available_spots = $available_spots - 1;
        $update_query = "UPDATE available_spots SET available_spots=$new_available_spots WHERE garage_id=$garage_id";
        if ($conn->query($update_query) === TRUE) {
          echo "<p>Reserved a spot in $garage_name garage.</p>";
        } else {
          echo "Error: " . $update_query . "<br>" . $conn->error;
        }
      } else {
        echo "<p>No available spots in $garage_name garage.</p>";
      }
    } else {
      echo "<p>No available spots in $garage_name garage.</p>";
    }
  } else {
    echo "<p>Invalid garage name.</p>";
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
<!DOCTYPE html>
<html>
<head>
  <title>Parking Garage Availability</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<style type="text/css">
  * {
  margin: 0px;
  padding: 0px;
}
body {
  font-size: 120%;
  background: #F8F8FF;
}

.header {
  color: white;
  background: #5F9EA0;
  text-align: center;
  border: 1px solid #B0C4DE;
  border-bottom: none;
  border-radius: 10px 10px 0px 0px;
  padding: 20px;
}
.content {
  padding: 20px;
  border: 1px solid #B0C4DE;
  background: white;
  border-radius: 0px 0px 10px 10px;
}
table {
  border-collapse: collapse;
  width: 100%;
  margin-top: 20px;
}
th, td {
  text-align: left;
  padding: 8px;
}
th {
  background-color: #5F9EA0;
  color: white;
}
tr:nth-child(even) {
  background-color: #f2f2f2;
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
  <div class="header">
  	<h2>Parking Garage Availability</h2>
  </div>
  <div class="content">
    <?php if (count($spots) > 0) { ?>
    <table>
      <thead>
        <tr>
          <th>Garage Name</th>
          <th>Available Spots</th>
<th>Action</th> <!-- Adding a new table header for the action column -->
        </tr>
      </thead>
      <tbody>
        <?php foreach ($spots as $spot) { ?>
        <tr>
          <td><?php echo $spot['garage_name']; ?></td> <!-- Displaying garage name in the table -->
          <td><?php echo $spot['available_spots']; ?></td>
          <td>
            <?php if ($spot['available_spots'] > 0) { ?>
            <form method="POST">
              <input type="hidden" name="garage_name" value="<?php echo $spot['garage_name']; ?>">
              <button class="btn" type="submit">Reserve</button> <!-- Adding a new button to reserve a spot -->
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
</html>