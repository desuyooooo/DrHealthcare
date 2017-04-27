<?php
	session_start();
    if(isset($_SESSION["type"])){
    	if($_SESSION["type"]=='admin'){
    		include("_database.php");
			$sql = mysqli_query($con, "UPDATE category SET catname = '$_POST[catname]', catdesc = '$_POST[catdesc]' WHERE catid = '$_POST[catid]';");
			echo '<script language="javascript">alert("Category updated!");window.location.href="admin-editcategory.php";</script>';
		}
	}
?>