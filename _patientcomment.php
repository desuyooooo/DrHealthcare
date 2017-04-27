<?php
  session_start();
  include("_database.php");

  if (!mysqli_select_db($con, 'drhealth_drhealthcare')) {
    mysqli_query($con, 'CREATE DATABASE drhealth_drhealthcare');
    mysqli_select_db($con, 'drhealth_drhealthcare');
  }
  
  if ($con->query("SHOW TABLES LIKE 'post'")->num_rows==0) { 
    //$sql1="CREATE TABLE patient (  patientid INT PRIMARY KEY AUTO_INCREMENT, firstname VARCHAR(30) NOT NULL, midname VARCHAR(30), lastname VARCHAR(30) NOT NULL, email VARCHAR(50)NOT NULL, password VARCHAR(30) NOT NULL)";
    $sql1 = "CREATE TABLE post
			(
			postid int NOT NULL AUTO_INCREMENT,
			patientid int NOT NULL,
			postcontent varchar(255) NOT NULL,
			timeposted datetime NOT NULL,
			solved char DEFAULT 'N',
			PRIMARY KEY (postid)
			)";
	mysqli_query($con,$sql1);
	$sql2 = "CREATE TABLE comment
			(
			commentid int NOT NULL AUTO_INCREMENT,
			postid int NOT NULL,
			patientdoctor varchar(255) NOT NULL,
			patientid int,
			doctorid int,
			commenttime datetime NOT NULL,
			commentcontent varchar(255),
			PRIMARY KEY (commentid)
			)";
	mysqli_query($con,$sql2);
  }


  $add = mysqli_query($con,"INSERT into comment SET postid='".$_POST['postid']."' patientdoctor='Patient', patientid='".$_SESSION["patientid"]."', commentcontent='".$_POST['commentcontent']."', commenttime='".date("Y-m-d H:i:s")."'");
				
				if ($add) {
					header("location: 10PatientAskDoctor.php");
				}
				else {
					echo '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Error occured:</strong>' . mysql_error() .
					'</div>';
					header("location: 10PatientAskDoctor.php");
				}

  

  
?>