<?php
  session_start();
  include("_database.php");

  if(isset($_POST['posttitle'])){
  	$patientid = $_SESSION['patientid'];
  	$posttitle = mysqli_real_escape_string($con, $_POST['posttitle']);
  	$postcontent = mysqli_real_escape_string($con, $_POST['postcontent']);
  	$posttag = mysqli_real_escape_string($con, $_POST['posttag']);
  	$category = $_POST['cat'];
  	$date = date("Y-m-d H:i:s");

  	$add = mysqli_query($con,"INSERT into post SET patientid='".$patientid."', posttitle='".$posttitle."', postcontent='".$postcontent."', tag='".$posttag."', catid='".$category."',   timeposted='".$date."'");

	if ($add) {
		 $_SESSION['post'] = 'Y';
		echo '<script language="javascript">alert("Post successful!");window.location.href="patient-ask-question.php";</script>';
	}else {
		echo '<div class="alert alert-danger">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Error occured:</strong>' . mysql_error() .
		'</div>';
		header("location: patient-ask-question.php");
	}

  }

  

  

  
?>