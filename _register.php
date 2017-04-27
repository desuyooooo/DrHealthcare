<?php
  session_start();
  include("_database.php");
  
	$email = mysqli_real_escape_string($con,$_POST['email']);
	$pass1 = $_POST['password'];
	$pass2 = $_POST['cpassword'];
	$firstname = mysqli_real_escape_string($con,$_POST['firstname']);
	$lastname = mysqli_real_escape_string($con,$_POST['lastname']);

    $search = "SELECT * FROM patient, doctor WHERE patient.email='$_POST[email]' or doctor.email='$_POST[email]'";

    $result = mysqli_query($con,$search);
      
    $count = mysqli_num_rows($result);
    
    if($count==0){
		
		
		
		if ($email=='' || $firstname=='' || $lastname=='') {
			echo '<script language="javascript">alert("Fill up required fields!");window.location.href="signup.php";</script>';
		}
		
		else if ($pass1=='' && $pass2=='') {
			echo '<script language="javascript">alert("Passwords can\'t be blank!");window.location.href="signup.php";</script>';
  		  		
  		}

  		else {
		  		$pass1 = sha1($_POST['password']);
		  		$pass2 = sha1($_POST['cpassword']);
  		

			if ($pass1 != $pass2) {
					echo '<script language="javascript">alert("Passwords do not match!");window.location.href="signup.php";</script>';
				
			}
	 
			else {
				//$sql = mysqli_query($link, "UPDATE tblAccount SET password='".$pass1."' WHERE id=".$_SESSION['uid']);
				
				$add = mysqli_query($con,"INSERT into patient SET email='".$email."', password='".$pass1."', firstname='".$firstname."', lastname='".$lastname."'");
				$addmedical = mysqli_query($con,"INSERT into patientmedical SET weight='0', height='0'");
				$addpersonal = mysqli_query($con,"INSERT into patientpersonal SET contact='+63'");
				$id = $con->insert_id;
				
				if ($add && $addmedical && $addpersonal) {
					$_SESSION["type"]="patient";
					$_SESSION["patientid"]=$id;
					$_SESSION["firstname"]=$_POST['firstname'];
					$_SESSION["fullname"]=$_POST['firstname'] . ' ' . $_POST['lastname'];
					$_SESSION["email"]=$_POST['email'];

					if(isset($_SESSION['url'])) 
   						$url = $_SESSION['url']; // holds url for last page visited.
					else 
   						$url = "index.php"; 

 					echo '<script language="javascript">alert("You are successfully registered!");window.location.href="'.$url.'";</script>';
				}
				else {
					echo '<script language="javascript">alert("Oops! Something went wrong. Try again");window.location.href="signup.php";</script>';
				}

			}
		}
		
		
		/*
      if($_POST['password'] == $_POST['cpassword']){
        $sql="INSERT INTO patient
            VALUES('$_POST[firstname]', '$_POST[lastname]', '$_POST[email]', 'SHA2($_POST[password], 512)')";
        mysqli_query($con, $sql);
        $id = $con->insert_id;
        $sql="INSERT INTO patientpersonal(patientid)
            VALUES('$id')";
        mysqli_query($con, $sql);
        $sql="INSERT INTO patientmedical(patientid)
            VALUES('$id')";
        mysqli_query($con, $sql);

        
        header("location: 04PatientProfile.php");

      }else
        echo '<script language="javascript">alert("Passwords do not match.");window.location.href="02Register.php";</script>';
    }*/
	}else{
      echo '<script language="javascript">alert("Existing email");window.location.href="signup.php";</script>';
    }

  
?>