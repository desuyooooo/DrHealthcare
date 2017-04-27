<?php
	session_start();
	include("_database.php");

    if(isset($_GET["s_id"])){
		$sql = mysqli_query($con, "UPDATE comment SET answer = 'Y' WHERE commentid = '$_GET[s_id]' and answer = 'N'");
		$sql = mysqli_query($con, "UPDATE post, comment SET post.solved = 'Y' WHERE comment.commentid = '$_GET[s_id]' and comment.postid = post.postid");

			$url = $_SESSION['url'];
			echo '<script language="javascript">alert("Best answer successfully set");window.location.href="'.$url.'";</script>';

	}else if(isset($_GET["u_id"])){
		$sql = mysqli_query($con, "UPDATE comment SET answer = 'N' WHERE commentid = '$_GET[u_id]' and answer = 'Y'");
		$sql = mysqli_query($con, "UPDATE post, comment SET post.solved = 'N' WHERE comment.commentid = '$_GET[u_id]' and comment.postid = post.postid");

			$url = $_SESSION['url'];
			echo '<script language="javascript">alert("Best answer successfully unset");window.location.href="'.$url.'";</script>';
	}
?>