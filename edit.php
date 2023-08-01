<?php
  session_start();
  if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
    
  }
  // Include database file
  include 'information.php';
  $customerObj = new Customers();


  // Edit customer record
  if(isset($_GET['editId']) && !empty($_GET['editId'])) {
    $editId = $_GET['editId'];
    $customer = $customerObj->displyaRecordById($editId);
  }
  // Update Record in customer table
  if(isset($_POST['update'])) {
    $customerObj->updateRecord($_POST);
  }  
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Information</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style2.css">
  <link rel="stylesheet" href="fonts.css"/>
</head>
<body>
<div class="card text-center" style="padding:15px;background-color: #808080;color:#FFFFFF;">
  <h4>Edit Information</h4>
</div><br> 
<div class="container">
  <form action="edit.php" method="POST">
  <a href="index2.php" class="btn btn-primary1" style="float:right;">Back</a> <br> 
    <div class="form-group">
      <label for="name">First name:</label>
      <input type="text" class="form-control" name="fname" value="<?php echo isset($customer['fname']) ? $customer['fname'] : ''; ?>" required="">
    </div>
    <div class="form-group">
      <label for="email">Last name:</label>
      <input type="text" class="form-control" name="lname" value="<?php echo isset($customer['lname']) ? $customer['lname'] : ''; ?>" required="">
    </div>
    <div class="form-group">
      <label for="username">Age:</label>
      <input type="text" class="form-control" name="age" value="<?php echo isset($customer['age']) ? $customer['age'] : ''; ?>" required="">
    </div>
    <div class="form-group">
      <label for="username">Gender:</label>
      <input type="text" class="form-control" name="gender" value="<?php echo isset($customer['gender']) ? $customer['gender'] : ''; ?>" required="">
    </div>
    <div class="form-group">
      <input type="hidden" name="id" value="<?php echo $customer['ID']; ?>">
      <input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Update">
    </div>
  </form>
</div>
</body>
</html>