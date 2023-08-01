<?php

	class Customers
	{
		private $servername = "localhost";
		private $username   = "root";
		private $password   = "";
		private $database   = "newdatabase";
		public  $con;
		// Database Connection 
		public function __construct()
		{
		    $this->con = new mysqli($this->servername, $this->username,$this->password,$this->database);
		    if(mysqli_connect_error()) {
			 trigger_error("Failed to connect to MySQL: " . mysqli_connect_error());
		    }else
            {
			 $this->con;
		    }
		}

		// Insert customer data into customer table
		public function insertData()
		{
			$fname = $this->con->real_escape_string($_POST['fname']);
			$lname = $this->con->real_escape_string($_POST['lname']);
			$age = $this->con->real_escape_string($_POST['age']);
			$gender = $this->con->real_escape_string(($_POST['gender']));

			$query="INSERT INTO information(fname,lname,age,gender) VALUES('$fname','$lname','$age','$gender')";
			$sql = $this->con->query($query);
			if ($sql==true) {
			    header("Location:index2.php?msg1=insert");
			}else{
			    echo "Registration failed try again!";
			}
		}
		// Fetch customer records for show listing
		public function displayData($searchmatch = '')
		{
   		if ($searchmatch != '') {
			$searchmatch = "%{$searchmatch}%";
            $query = "SELECT * FROM information WHERE fname LIKE ?";
			$stmt = $this->con->prepare($query);
        $stmt->bind_param("s", $searchmatch);
    	} else {
        $query = "SELECT * FROM information";
		$stmt = $this->con->prepare($query);
    	}
		$stmt->execute();
    	$result = $stmt->get_result();

    	if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    	} else {
        echo "No matching records found.";
        return array();
    	}
	}

		// Fetch single data for edit from customer table
		public function displyaRecordById($id)
		{
		    $query = "SELECT * FROM information WHERE ID = '$id'";
		    $result = $this->con->query($query);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			return $row;
		    }else{
			echo "Record not found";
		    }
		}
		//Display admin Records
		public function displayadmin($id)
		{
		    $query = "SELECT * FROM admin WHERE ID = '$id'";
		    $result = $this->con->query($query);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			return $row;
		    }else{
			echo "Record not found";
		    }
		}

		public function displayDataadmin($searchmatch = '')
		{
   		if ($searchmatch != '') {
			$searchmatch = "%{$searchmatch}%";
            $query = "SELECT * FROM admin WHERE username LIKE ?";
			$stmt = $this->con->prepare($query);
        $stmt->bind_param("s", $searchmatch);
    	} else {
        $query = "SELECT * FROM admin";
		$stmt = $this->con->prepare($query);
    	}
		$stmt->execute();
    	$result = $stmt->get_result();

    	if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    	} else {
        echo "No matching records found.";
        return array();
    	}
	}

		// Update customer data into customer table
		public function updateRecord($postData)
		{
		    $fnameupdate = $this->con->real_escape_string($_POST['fname']);
		    $lnameupdate = $this->con->real_escape_string($_POST['lname']);
		    $ageupdate = $this->con->real_escape_string($_POST['age']);
            $genderupdate = $this->con->real_escape_string($_POST['gender']);
		    $id = $this->con->real_escape_string($_POST['id']);
		if (!empty($id) && !empty($postData)) {
			$query = "UPDATE information SET fname = '$fnameupdate', lname = '$lnameupdate', age = '$ageupdate' , gender = '$genderupdate' WHERE ID = '$id'";
			$sql = $this->con->query($query);
			if ($sql==true) {
			    header("Location:index2.php?msg2=update");
			}else{
			    echo "Registration updated failed try again!";
			}
		    }
			
		}
		// Delete customer data from customer table
		public function deleteRecord($id)
		{
		    $query = "DELETE FROM information WHERE ID = '$id'";
		    $sql = $this->con->query($query);
		if ($sql==true) {
			header("Location:index2.php?msg3=delete");
		}else{
			echo "Record does not delete try again";
		    }
		}

		public function admin()
		{
		if ( !isset($_POST['username'], $_POST['password']) ) {
			exit('Please fill both the username and password fields!');
		}
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$query = "SELECT ID,password FROM admin WHERE username = ?";
		$stmt = $this->con->prepare($query) or die($this->con->error);

		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows === 1) {
			$row = $result->fetch_assoc();
			$user_id = $row['ID'];
			$hashed_password = $row['password'];
			if (password_verify($password, $hashed_password)) {
				// Username and password matched, proceed to the next page.
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['user_id'] = $user_id;
				header("Location: index2.php");
				exit(); // Make sure to call exit() after redirection to terminate the current script execution.
			} else {
				echo "Incorrect password!";
			}
		} else {
			echo "Incorrect username or password";
		}
		
		$stmt->close();
		}

	}
	
?>