<?php
	session_start();
    if(isset($_GET["id"])){
    		include("_database.php");
			$sql = mysqli_query($con, "DELETE FROM post WHERE postid = '$_GET[id]'");

			$url = $_SESSION['url'];
			echo '<script language="javascript">alert("Post deleted!");window.location.href="'.$url.'";</script>';
}
?>