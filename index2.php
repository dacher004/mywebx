<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
	
}
?>

<?php
  
  // Include database file
  include 'information.php';
  $customerObj = new Customers();
  // Delete record from table
  if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
      $deleteId = $_GET['deleteId'];
      $customerObj->deleteRecord($deleteId);
  }

     
?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sample Project</title>
  <link rel="stylesheet" href="style2.css">
  <link rel="stylesheet" href="fonts.css">
</head>
<body>
<div class="card text-center" style="padding:15px;background-color: #25383C;color:#FFFFFF;">
  <h4>Customer Information </h4>
</div>


<a href="logout.php" class="btn btn-primary1" style="float:right;">Logout</a>

<br><br> 
<div class="container">
  <?php
    if (isset($_GET['msg1']) == "insert") {
      echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Your Registration added successfully
            </div>";
      } 
    if (isset($_GET['msg2']) == "update") {
      echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Your Registration updated successfully
            </div>";
    }
    if (isset($_GET['msg3']) == "delete") {
      echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Record deleted successfully
            </div>";
    }
  ?>
  <h2>
    <a href="add.php" class="btn btn-primary" style="float:right;">Add Customer</a>
  </h2>
  <table class="table table-hover">
  <form method="POST" action="index2.php">
    <label>Search:</label>&nbsp
    <input type="text" name="search" placeholder="Type here"> &nbsp
    <button class="btn btn-primary1" type="submit" name="save">Search</button>
</form>
    <thead>
      <tr>
        
        <th>First name</th>
        <th>Last name</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        <?php 

        // Search and display record from table
          $searchResults = array();
          if (isset($_POST['search'])) {
           $searchfname = $_POST['search'];
           $searchResults = $customerObj->displayData($searchfname);
          } else {
           $searchResults = $customerObj->displayData();
            }
          foreach ($searchResults as $customer) {
    
        ?>
        <tr>
         
          <td><?php echo $customer['fname'] ?></td>
          <td><?php echo $customer['lname'] ?></td>
          <td><?php echo $customer['age'] ?></td>
          <td><?php echo $customer['gender'] ?></td>
          <td>
            <a href="edit.php?editId=<?php echo $customer['ID'] ?>" style="color:green"> Edit
              </a>&nbsp
            <a href="index2.php?deleteId=<?php echo $customer['ID'] ?>" style="color:red" onclick="confirm('Are you sure want to delete this record')">
            Delete            </a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</div>
<div class="card text-center" style="padding:15px;background-color: #25383C;color:#FFFFFF;">
  <h4>Admin Accounts </h4>
</div>
<div class="container">
<h2>
    <a href="add.php" class="btn btn-primary" style="float:right;">Add New Account</a>
  </h2>
  <table class="table table-hover">
  <form method="POST" action="index2.php">
    <label>Search:</label>&nbsp
    <input type="text" name="search1" placeholder="Type here"> &nbsp
    <button class="btn btn-primary1" type="submit" name="save1">Search</button>
</form>
    <thead>
      <tr>
        
        <th>Username</th>
        <th>Password</th>
        
      </tr>
    </thead>
    <tbody>
        <?php 

        // Search and display record from table
          $searchResults = array();
          if (isset($_POST['search1'])) {
           $searchfname = $_POST['search1'];
           $searchResults = $customerObj->displayDataadmin($searchfname);
          } else {
           $searchResults = $customerObj->displayDataadmin();
            }
          foreach ($searchResults as $customer) {
          
        ?>
        <tr>
         
          <td><?php echo $customer['username'] ?></td>
          <td><?php echo $customer['password'] ?></td>
          
          <td>
            <a href="edit.php?editId=<?php echo $customer['ID'] ?>" style="color:green"> Edit
              </a>&nbsp
            <a href="index2.php?deleteId=<?php echo $customer['ID'] ?>" style="color:red" onclick="confirm('Are you sure want to delete this record')">
            Delete            </a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

</body>
</html>