<?php
	session_start();
	header("location: search.php?keyword=$_POST[search]");
?>