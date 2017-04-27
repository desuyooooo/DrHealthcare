<?php 
	session_start();
	include("_database.php");

		//GET EMAIL
		$email = mysqli_real_escape_string($con,$_POST['email']);
      	$password = mysqli_real_escape_string($con,$_POST['password']);

      	//CHECK AT ADMIN FIRST
      	if($_POST['email']==$admin && $_POST['password']==$password){
		
			$_SESSION["type"]="admin";
			$_SESSION["fullname"]="Admin";
			header("location: admin-index.php");
		
		}else{
		
		//THEN CHECK AT PATIENT AND DOCTOR	
		$email = $_POST['email'];
		$password = sha1($_POST['password']);
	    

		$sql="SELECT * FROM patient WHERE email='$email'";
		
		$result = mysqli_query($con,$sql);
      	$count = mysqli_num_rows($result);
		
		switch ($count) {
		case 1:	//SEARCH AT PATIENT
			$row = mysqli_fetch_assoc($result);

			if ($password == $row['password']) { //CHECK PASSWORD
				$_SESSION["type"]="patient";
				$_SESSION["patientid"]=$row['patientid'];
				$_SESSION["firstname"]=$row['firstname'];
				$_SESSION["lastname"]=$row['lastname'];
				$_SESSION["fullname"]=$row['firstname'] . ' ' . $row['lastname'];
				$_SESSION["email"]=$row['email'];
				if($row['confirmed']==0) $_SESSION['confirmed'] = 0;
		
				if(isset($_SESSION['url'])) 
   					$url = $_SESSION['url']; // holds url for last page visited.
				else 
   					$url = "index.php"; 
 
				echo '<script language="javascript">alert("You are successfully logged in!");window.location.href="'.$url.'";</script>';
			
			}else{ //WRONG PW

				if(isset($_SESSION['url'])) 
   					$url = $_SESSION['url']; // holds url for last page visited.
				else 
   					$url = "index.php"; 
				echo '<script language="javascript">alert("Wrong Email or Password");window.location.href="'.$url.'";</script>';
			}

		case 0:
			$sql="SELECT * FROM doctor WHERE email='$email' AND password='$password'";
			$result = mysqli_query($con,$sql);
			$count = mysqli_num_rows($result);
			
			if ($count == 1) {
				$row = mysqli_fetch_assoc($result);
				
				//mysqli_close($con);
				$_SESSION["type"]="doctor";
			
				$_SESSION["doctorid"]=$row['doctorid']; 
				//$_SESSION["username"]=$row['firstname'];
				$_SESSION["firstname"]=$row['firstname'];
				$_SESSION["lastname"]=$row['lastname'];
				$_SESSION["fullname"]=$row['firstname'] . ' ' . $row['lastname'];
				$_SESSION["email"]=$row['email'];
			
				if(isset($_SESSION['url'])) 
   					$url = $_SESSION['url']; // holds url for last page visited.
				else 
   					$url = "index.php"; 
 
				echo '<script language="javascript">alert("You are successfully logged in!");window.location.href="'.$url.'";</script>';
			}
			else{
				if(isset($_SESSION['url'])) 
   					$url = $_SESSION['url']; // holds url for last page visited.
				else 
   					$url = "index.php"; 
				echo '<script language="javascript">alert("Wrong Email or Password");window.location.href="'.$url.'";</script>';
			}
		}
		
/*
		$sqladmin="SELECT * FROM admin WHERE adminid='$username' AND password='$password'";
		$result = mysqli_query($con,$sqladmin);
      
      	$count = mysqli_num_rows($result);
		
		if($count==1){
			mysqli_close($con);
			$_SESSION["type"]="admin";
			while($row = mysqli_fetch_assoc($result)) 
        		$_SESSION["username"]=$row['firstname'];
			header("location: AdminPage.php");
		}
*/

		
}
?>