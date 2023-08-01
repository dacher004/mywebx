<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
	
}
  // Include database file
  include 'information.php';
  $customerObj = new Customers();
  // Insert Record in customer table
  if(isset($_POST['submit'])) {
    $customerObj->insertData($_POST);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Data</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style2.css">
  <link rel="stylesheet" href="fonts.css"/>
</head>
<body>
<div class="card text-center" style="padding:15px;background-color: #808080;color:#FFFFFF;">
  <h4>Add Data</h4>
</div><br> 

<div class="container">
  <form action="add.php" method="POST">
  <a href="index2.php" class="btn btn-primary1" style="float:right;">Back</a> <br> 
    <div class="form-group">
      <label for="fname">First name:</label>
      <input type="text" class="form-control" name="fname" placeholder="First name" required="">
    </div>
    <div class="form-group">
      <label for="lname">Last name:</label>
      <input type="text" class="form-control" name="lname" placeholder="Last name" required="">
    </div>
    <div class="form-group">
      <label for="age">Age:</label>
      <input type="number" class="form-control" name="age" placeholder="Age" required="">
    </div>
    <div class="form-group">
      <label for="gender">Gender:</label>
      <input type="text" class="form-control" name="gender" placeholder="Gender" required="">
    </div>
     
    <input type="submit" name="submit" class="btn btn-primary" style="float:right;" value="Submit">
    
  </form>
</div>
</body>
</html>