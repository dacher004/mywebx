<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
	
}
?>


<!DOCTYPE html>
<html>
<style>

.disabled {
      background-color: #eee;
      pointer-events: none;
    }
table, th, td {
  border: 1px solid black;
}
table {
            margin-left: auto;
            margin-right: auto;
        }
		
		input[type="tabletext"]
		 {
            text-align: center;
			margin: auto;
			
		}
		button[alignment="addbutton"]
		 {
            float: right;
			
		}

label{
  font-size: 16px; /* Adjust the font size of the label */
  width: 200px; /* Adjust the width size of the label */
  height: 30px; /* Adjust the height of the label */
  padding: 5px; /* Adjust the padding around the label */
  margin: auto; /* Adjust the margin around the label */
}
			
</style>

	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Company name</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Information Database</h2>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newdatabase";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);

}

?>
<form  method="GET"> 
<label> Search : </label> 
<input type="text" name="search" placeholder="Search here"> 
<button type="submit" name="save">Search </button>
</form>

<table>
		<thead>
<tr>
<!--  <th><label> ID</th> -->
<th><label> First name </th>
<th><label> Last name </th>
<th><label> Age </th>
<th><label> Gender </th>
<th><label >Action</button>
</tr>


<button id="add" type="addbutton" alignment="addbutton" name="add">Add Data </button>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        $(document).ready(function() {
            // Initially disable the textbox
            $('#fname').prop('disabled', true);
			$('#lname').prop('disabled', true);
			$('#age').prop('disabled', true);
			$('#gender').prop('disabled', true);

            // Button click event handler
            $('#add').click(function() {
				
                // Toggle the disabled property of the textbox
                $('#fname').prop('disabled', function(i, val) {
                    return !val;
                });
				$('#lname').prop('disabled', function(i, val) {
                    return !val;
                });
				$('#age').prop('disabled', function(i, val) {
                    return !val;
                });
				$('#gender').prop('disabled', function(i, val) {
                    return !val;
                });
				$('#add').prop('hidden', function(i, val) {
                    return !val;
                });
				$('#savedata').prop('hidden', function(i, val) {
                    return !val;
                });
            });
});

    </script>


<!-- ADD DATA TO DATABASE -->
<form method=POST>
<button id= "savedata" type= "submit" alignment="addbutton" name= "savedata" value= "save" hidden= "true">Save Data </button>
<tr>
	<br></br>
<?php
	$fnameadd = "";
	$lnameadd = "";
	$ageadd = "";
	$genderadd = "";
	?>
		<!-- 	<td><input type="tabletext" id="ID" disabled="true"></td> -->
			<td><input type="tabletext" id="fname" name= "fname" value="<?php echo $fnameadd; ?>"></td>
			<td><input type="tabletext" id="lname" name= "lname" value="<?php echo $lnameadd; ?>"></td>
			<td><input type="tabletext" id="age" name= "age" value="<?php echo $ageadd; ?>"></td>
			<td><input type="tabletext" id="gender" name= "gender" value="<?php echo $genderadd; ?>"></td>
			
		</tr>
<?php
if (isset($_POST['savedata'])) {
    $fnameadd = $_POST['fname'];
    $lnameadd = $_POST['lname'];
    $ageadd = $_POST['age'];
    $genderadd = $_POST['gender'];
	
	if (empty($fnameadd) || empty($lnameadd) || empty($ageadd) || empty($genderadd)) {
        echo "Data can't be NULL";
    } else {
        $sql = "INSERT INTO information (fname, lname, age, gender) VALUES ('$fnameadd', '$lnameadd', '$ageadd', '$genderadd')";
        $result = $conn->query($sql);

        if ($result) {
            echo "Data added successfully!";
        } else {
            echo "Error adding data: " . $conn->error;
        }
    }
}
?>
</form>

<?php
if (isset($_GET['search'])) {
    $searchmatch = $_GET['search'];


	if ($searchmatch != null)
	{
	$sql = "SELECT * FROM information where fname LIKE '%$searchmatch%'";
	

	} else {
    $sql = "SELECT * FROM information";
	}
$result = $conn->query($sql);

echo "<pre>";
print_r($_POST);
echo "</pre>";

		if ($result === false)
 		{
			die("Error executing the query: " . $conn->error);
		}

			if ($result->num_rows > 0) 
			{
    		while ($row = $result->fetch_assoc()) 
			{
       	 // Process each row of data
       		 $id =  $row["ID"];
       		 $fname =  $row["fname"];
			$lname =  $row["lname"];
			$age =  $row["age"];
			$gender =  $row["gender"];        
				?>
				
			<tr>
			<form method ="POST" >	
			<input type="hidden" id="ID" name= "ID" value= "<?php echo $id;?>">
			<td><input type="tabletext" id="fname" name= "fname" value="<?php echo $fname;?>" disabled></td>
			<td><input type="tabletext" id="lname" name= "lname" value= "<?php echo $lname;?>" disabled></td>
			<td><input type="tabletext" id="age" name= "age" value= "<?php echo $age;?>" disabled></td>
			<td><input type="tabletext" id="gender" name= "gender" value= "<?php echo $gender;?>"  disabled ></td>
			<td>
			
			<button id="delete" type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this row?')">Delete</button>
				
		</form>
		
		<form method ="POST" onsubmit="event.preventDefault();">			
		<button id="edit" type="button" name="edit" onclick="enableTextboxes()">Edit data</button> 	

		<button id="saveedit" type="submit" name="saveedit" hidden onclick="saveData()" disabled>Save</button>
</form>
</td>
</tr>	


		
			
			
	
		
			<?php
			}
		} 
		else 
		{
		echo "No results found.";
		} 
	}

			?>
			<?php

// DELETE info to database
if (isset($_POST['delete'])) {
	$IDdel = $_POST['ID'];
//	$fnamedel = $_POST['fname'];
 //   $lnamedel = $_POST['lname'];
  //  $agedel = $_POST['age'];
  //  $genderdel = $_POST['gender'];

// Create a connection with PDO instance
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newdatabase";

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$query = "DELETE FROM information WHERE ID = :ID"; //AND fname = :fname AND lname = :lname AND age = :age AND gender = :gender";
    $stmt = $pdo->prepare($query);
	$stmt->bindValue(':ID', $IDdel);
	//$stmt->bindValue(':fname', $fnamedel);
    //$stmt->bindValue(':lname', $lnamedel);
   // $stmt->bindValue(':age', $agedel);
  //  $stmt->bindValue(':gender', $genderdel);

	if ($stmt->execute()) {
        echo "Rows deleted successfully.";
		
    } else {
        echo "Error deleting rows: " . $stmt->errorInfo()[2];
    	}
	}
?>





<!-- EDIT info to database -->





<?php
if (isset($_POST['edit'])) {
	echo "No results found.";
?>
<script>
function enableTextboxes() {
  document.getElementById('fname').disabled = false;
  document.getElementById('lname').disabled = false;
  document.getElementById('age').disabled = false;
  document.getElementById('gender').disabled = false;
  document.getElementById("edit").disabled = true;
  document.getElementById("edit").hidden = true;
  document.getElementById("saveedit").disabled = false;
  document.getElementById("saveedit").hidden = false;
  document.getElementById("gender").classList.remove("disabled");
}
function saveData() {
document.getElementById('fname').disabled = true;
document.getElementById('lname').disabled = true;
document.getElementById('age').disabled = true;
document.getElementById('gender').disabled = true;
document.getElementById("edit").disabled = false;
document.getElementById("edit").hidden = false;
document.getElementById("saveedit").disabled = true;
document.getElementById("saveedit").hidden = true;
document.getElementById("gender").classList.add("disabled");
}
</script>
	


<?php
	if (isset($_POST['saveedit'])) {
	$IDedit = $_POST['ID'];
	$fnameedit = $_POST['fname'];
    $lnameedit = $_POST['lname'];
    $ageedit = $_POST['age'];
    $genderedit = $_POST['gender'];

	if (empty($fnameedit) || empty($lnameedit) || empty($ageedit) || empty($genderedit)) {
        echo "Data can't be NULL";
    } else {

        $sql = "UPDATE information SET fname = '$fnameedit', lname = '$lnameedit', age = '$ageedit', gender = '$genderedit' WHERE ID = '$IDedit'";
        $result = $conn->query($sql);

		if ($conn->query($sql) === TRUE) {
            echo "Update added successfully!";
        } else {
            echo "Error updating data: " . $conn->error;
        }
    }
	}
}
?>
	

	
		



</table>
		</div>
	</body>
</html>