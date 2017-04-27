<?php
	session_start();
	include("_database.php");

		if(isset($_SESSION["type"])){
        	if($_SESSION["type"]=='admin'){
            	$add = mysqli_query($con,"INSERT into adminmessage SET postid='$_POST[postid]',  messagecontent = '$_POST[messagecontent]'");
                $update = mysqli_query($con,"UPDATE post SET approved='D', seen = 1 WHERE postid='$_POST[postid]'");
            	
			echo '<script language="javascript">alert("Post Declined");window.location.href="admin-index.php";</script>';

    	}
    }

    
?>