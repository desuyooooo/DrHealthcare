<?php
  session_start();
  include("_database.php");

  if($_POST['postid'] != ''){

  $postcontent = mysqli_real_escape_string($con, $_POST['postcontent']);
  $update = mysqli_query($con,"UPDATE post SET posttitle='$_POST[posttitle]', postcontent='".$postcontent."', tag='$_POST[posttag]', catid='$_POST[cat]', approved = 'Y', seen = 1, modified = 'Y' WHERE postid='$_POST[postid]'");
				
	if ($update) {
		$tags = trim($_POST['posttag']);
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
		echo '<script language="javascript">alert("Modify and approval successful!");window.location.href="admin-index.php";</script>';
	}
	else {
		echo '<script language="javascript">alert("Modify and approval unsuccessful");window.location.href="admin-index.php";</script>';
	}

	}
  

  
?>