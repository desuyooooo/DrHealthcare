<?php 
	
  session_start();
  if(!isset($_SESSION["type"]))
      header("location: 01Homepage.php");

  include("_database.php");

  $patientid = $_SESSION["patientid"];

  $sql = "UPDATE patient SET firstname='$_POST[firstname]', midname='$_POST[midname]', lastname='$_POST[lastname]' WHERE patientid='$patientid'";
  $sql2 = "UPDATE patientpersonal SET sex='$_POST[sex]', bdate='$_POST[bdate]', address='$_POST[address]', contact='$_POST[contact]' WHERE patientid='$patientid'";
  $sql3 = "UPDATE patientmedical SET height='$_POST[height]', weight='$_POST[weight]', bloodtype='$_POST[bloodtype]', bloodpressure='$_POST[bloodpressure]', allergies='$_POST[allergies]', medicalhist='$_POST[medicalhist]' WHERE patientid='$patientid'";
	
	if (mysqli_query($con, $sql) && mysqli_query($con, $sql2) && mysqli_query($con, $sql3)) {
		mysqli_close($con);
    	echo '<script language="javascript">alert("Profile Succesfully Updated");window.location.href="profile.php";</script>';
	} else {
    	echo '<script language="javascript">alert("Error updating profile." '. mysqli_error($con) .');window.location.href="patient-edit-profile.php";</script>';
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

		
?>