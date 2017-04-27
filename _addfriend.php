<?php
	session_start();
	include("_database.php");

	if(isset($_SESSION["type"])){
        if(($_SESSION["type"]=='doctor')&&(isset($_GET['pid']))){
            $add = mysqli_query($con,"INSERT into friend SET patientid='$_GET[pid]', doctorid='$_SESSION[doctorid]', reqfrom='D'");

        	if ($add) {
				echo '<script language="javascript">alert("Friend Request Sent");</script>';
			}

			header("location: viewprofile.php?pid=".$_GET['pid']);

        }else if(($_SESSION["type"]=='patient')&&(isset($_GET['did']))){
            $add = mysqli_query($con,"INSERT into friend SET patientid='$_SESSION[patientid]', doctorid='$_GET[did]', reqfrom='P'");
    	
        	if ($add) {
				echo '<script language="javascript">alert("Friend Request Sent");</script>';
			}

			header("location: viewprofile.php?did=".$_GET['did']);

    	}
    }

    
?>