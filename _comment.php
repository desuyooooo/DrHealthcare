<?php
  session_start();
  include("_database.php");

  	if($_SESSION["type"]=="patient"){
        $add = mysqli_query($con,"INSERT into comment SET 
        	postid='".$_POST['postid']."',
        	patientdoctor='P',
        	patientid='".$_SESSION['patientid']."',
        	timeposted='".date("Y-m-d H:i:s")."',
        	commentcontent='".$_POST['commentcontent']."'
        	"
        	);

    }else if($_SESSION["type"]=="doctor"){
    	$add = mysqli_query($con,"INSERT into comment SET 
        	postid='".$_POST['postid']."',
        	patientdoctor='D',
        	doctorid='".$_SESSION['doctorid']."',
        	timeposted='".date("Y-m-d H:i:s")."',
        	commentcontent='".$_POST['commentcontent']."'
        	"
        	);
    }
  
  	if ($add) {
		echo '<script language="javascript">alert("comment successful!");</script>';
		header("location: viewpost.php?id=".$_POST['postid']);
	}else {
		echo '<div class="alert alert-danger">
		<strong>Error occured</strong></div>';
		header("location: viewpost.php?id=".$_POST['postid']);
	}

  
?>