<?php
	session_start();
	include("_database.php");

    if(isset($_POST['messagecontent'])){

        $add = mysqli_query($con,"INSERT into pdmessage SET friendid='$_POST[friendid]', sentby = '$_POST[sentby]', messagecontent = '$_POST[messagecontent]'");
        $update = mysqli_query($con, "UPDATE friend SET latestinteracttime=CURRENT_TIMESTAMP WHERE friendid = '$_POST[friendid]'");
        //insert into `messages`

    }


    

    
?>