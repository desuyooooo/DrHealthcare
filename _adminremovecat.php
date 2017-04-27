<?php
	session_start();
    if(isset($_SESSION["type"])){
    	if($_SESSION["type"]=='admin'){
    		include("_database.php");
    		$sql = mysqli_query($con, "DELETE FROM category WHERE catid = '$_GET[id]'");
			echo '<script language="javascript">alert("Category removed!");window.location.href="admin-editcategory.php";</script>';
		}
	}
?>