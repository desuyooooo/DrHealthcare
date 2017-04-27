<?php
	session_start();
	include("_database.php");

	if(isset($_GET["id"])){
	    $add = mysqli_query($con,"UPDATE friend SET status='A', unreadfr = 1, latestinteracttime=CURRENT_TIMESTAMP WHERE friendid='$_GET[id]'");

        if ($add) {
			echo '<script language="javascript">alert("Request Accepted");</script>';
		}

		$url = $_SESSION['url'];
		header("location: $url");

    }

    
?>