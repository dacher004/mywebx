<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
include 'information.php';
$customerObj = new Customers();
  // Insert Record in customer table
  if(isset($_POST['login'])) {
    $customerObj->admin();
  }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<form action="index.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input class="btn btn-primary1" type="submit" name="login" value="Login">
			</form>
		</div>
	</body>
</html>