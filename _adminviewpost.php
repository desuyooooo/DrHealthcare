<?php
	include("_database.php");
?>


<?php
	if(isset($_GET['id'])){
		//hanapin yung postid
		$sql = "SELECT * FROM post p, category c, patient pt WHERE p.postid='$_GET[id]' and p.catid = c.catid and p.patientid = pt.patientid";
            $postresult = mysqli_query($con, $sql);

            $count = mysqli_num_rows($postresult);

		if($count>0){
			echo '<h6><a href="admin-index.php">&laquo; Back to questions</a></h6>';
			while ($row = mysqli_fetch_array($postresult)) {
				echo '<h2><a href="viewpost.php?id='.$row['postid'].'">'.$row['posttitle'].'</a></h2>';
              echo $row['postcontent'].'';
              echo '<div class="row"><div class="col-md-8">';
              echo '<br><strong><a href="searchcat.php?id='.$row['catid'].'">'.$row['catname'].'</a></strong> | ';
              echo $row['tag'].'<br>';
              echo '</div><div class="col-md-4"><div class="alert alert-warning">';
              echo 'Asked by '.$row['firstname'].' '.$row['lastname'].'<br>';
              echo $row['timeposted'];
              echo '</div></div></div>';

              echo '<div class="row"><div class="col-xs-6 col-md-6">';
              echo '<a href="_approvepost.php?id='.$_GET['id'].'"><button class="btn btn-default" >MODIFY POST</button></a><br>';
              echo '</div><div class="col-xs-6 col-md-6">';
              echo '<a href="_approvepost.php?id='.$_GET['id'].'"><button class="btn btn-default" >APPROVE POST</button></a><br><br>';
              echo '</div></div>';

              echo '<form action="_admindecline.php" method="post">
              		<input type="hidden" name="postid" value="'.$row['postid'].'">';
              echo '<textarea placeholder="Note" name="messagecontent" class="form-control"></textarea>';
              echo '<button class="btn btn-default">DECLINE POST</button>';
              echo '</form>';
			}


		}else{
			echo '<h2>This topic doesn\'t exist.</h2><br>';
			echo 'Back to <a href="index.php">index</a>.';
		}
	}else{
	echo '<h2>The ID of this topic is not defined.</h2>';
	echo 'Back to <a href="index.php">index</a>.';

	}

?>

 