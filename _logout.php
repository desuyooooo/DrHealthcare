<?php
	session_start();
 	if(isset($_SESSION["type"])){
    	session_unset();
    	session_destroy(); 
    	echo '<script language="javascript">alert("You are successfully logged out!");window.location.href="index.php";</script>';
  }
?>