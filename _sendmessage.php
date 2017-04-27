<?php
	session_start();
	include("_database.php");

		if(isset($_SESSION["type"])){
        	if($_SESSION["type"]=='doctor'){
            	$add = mysqli_query($con,"INSERT into pdmessage SET friendid='$_POST[friendid]', sentby = 'D', messagecontent = '$_POST[messagecontent]'");
            	$update = mysqli_query($con, "UPDATE friend SET latestinteracttime=CURRENT_TIMESTAMP WHERE friendid = '$_POST[friendid]'");

			header("location: messages.php#end");

        	}else if($_SESSION["type"]=='patient'){
            	$add = mysqli_query($con,"INSERT into pdmessage SET friendid='$_POST[friendid]', sentby = 'P', messagecontent = '$_POST[messagecontent]'");
            	$update = mysqli_query($con, "UPDATE friend SET latestinteracttime=CURRENT_TIMESTAMP WHERE friendid = '$_POST[friendid]'");

			header("location: messages.php#end");

    	}
    }

    
?>