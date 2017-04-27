<?php
	include("_database.php");

    if(isset($_POST['reviewtitle'])){

        $add = mysqli_query($con,"INSERT into review SET doctorid='$_POST[doctorid]', patientid = '$_POST[patientid]', rating = '$_POST[rating]', reviewtitle = '$_POST[reviewtitle]', reviewcontent = '$_POST[reviewcontent]'");

    }


    

    
?>