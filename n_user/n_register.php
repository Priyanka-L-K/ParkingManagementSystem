<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>
	
  <form method="post" action="n_register.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
    <div class="input-group">
      <label>First Name</label>
      <input type="text" name="fname" value="<?php echo $fname; ?>">
    </div>
    <div class="input-group">
      <label>Last Name</label>
      <input type="text" name="lname" value="<?php echo $lname; ?>">
    </div>
    <div class="input-group">
      <label>Mobile</label>
      <input type="text" name="mobile" value="<?php echo $mobile; ?>">
    </div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="n_login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>