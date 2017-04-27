<?php
	session_start();
    if(isset($_SESSION["type"])){
    	if($_SESSION["type"]=='admin'){
    		include("_database.php");
			$sql = mysqli_query($con, "UPDATE post SET approved = 'Y', seen = 1 WHERE postid = '$_GET[id]'");
			if($sql){
				$gettag = mysqli_query($con, "SELECT tag FROM post WHERE postid = '$_GET[id]'");
				$tag = mysqli_fetch_assoc($gettag);
				$tags = trim($tag['tag']);
  				$arrTags = explode("#", $tags);
  				foreach($arrTags as $tag){

  				if($tag != ''){
  				$isontable = mysqli_query($con, "SELECT * FROM tags WHERE tag = '$tag'");
  				$count = mysqli_num_rows($isontable);
  				if($count > 0){
  					$fetch = mysqli_fetch_assoc($isontable);
  					$plus = $fetch['tagcount'] + 1;
  					$addcount = mysqli_query($con, "UPDATE tags SET tagcount = ".$plus." WHERE tag = '".$tag."'");
  				}else{
  					$addtag = mysqli_query($con, "INSERT into tags SET tag = '".$tag."'");
  				}
  				}
  			}
			}
			echo '<script language="javascript">alert("Post Approved");window.location.href="admin-index.php";</script>';
		}
}
?>