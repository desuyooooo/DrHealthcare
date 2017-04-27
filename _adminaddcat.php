<?php
	session_start();
    if(isset($_SESSION["type"])){
    	if($_SESSION["type"]=='admin'){
    		include("_database.php");
			$sql = mysqli_query($con, "INSERT into category SET catname = '$_POST[catname]', catdesc = '$_POST[catdesc]'");
			echo '<script language="javascript">alert("Category added!");window.location.href="admin-editcategory.php";</script>';
		}
	}
?>