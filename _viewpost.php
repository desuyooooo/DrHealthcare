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

			while ($post = mysqli_fetch_array($postresult)) {
				$approved = $post['approved'];

			if($approved=='N'){
      			echo '<div class="alert alert-warning" align="center" role="alert">
              	<strong><p>This post is pending for approval.</p></strong>
              	<p>Wait until the administrator approves post to comment.</p>
            	</div>';
      		}else if($approved=='D'){
            	$message = mysqli_query($con, "SELECT * FROM adminmessage am WHERE am.postid='$_GET[id]'");
				$message = mysqli_fetch_array($message);
      			echo '<div class="alert alert-danger" align="center" role="alert">
              	<strong><p>This post is declined by the administrator because of the following reason/s:</p></strong>
              	<p><i>'.$message['messagecontent'].'</i></p>
            	</div>';
      		}else if($approved=='Y'){
              echo '<h6><a href="'.$_SESSION['qtype'].'">&laquo; Back to questions</a></h6>';
          }

              $tags = $post['tag'];
              $arrTags = explode("#", trim($tags));

			       echo '<h2><a href="viewpost.php?id='.$post['postid'].'">'.$post['posttitle'];
             if($post['solved']=='Y') echo ' (Solved)';
             echo '</a></h2>';
              echo $post['postcontent'].'';
              echo '<div class="post"><div class="col-md-7">';
              echo '<br><strong><a href="'.$_SESSION['from'].'?id='.$post['catid'].'">'.$post['catname'].'</a></strong> | Tags: ';
              foreach($arrTags as $count)
              {
                if($count != '') echo '<a href="'.$_SESSION['from'].'?tag='.$count.'">#'.$count.'</a> ';  
              }
              echo '<br>';
              echo '</div><div class="col-md-5"><div class="alert alert-warning">';
              echo 'Asked by <a href="viewprofile.php?pid='.$post['patientid'].'">'.$post['firstname'].' '.$post['lastname'].'</a><br>';
              echo $post['timeposted'];
              echo '</div></div></div>';
              $patientid = $post['patientid'];

			}

		$sql = "SELECT * FROM comment c WHERE c.postid='$_GET[id]' ORDER BY commentid asc";
        $commentresult = mysqli_query($con, $sql);
        $count = mysqli_num_rows($commentresult);
        $ba = mysqli_num_rows(mysqli_query($con, "SELECT * FROM comment WHERE postid='$_GET[id]' and answer='Y'"));

        if ($approved=='Y') echo '<h3>Comments</h3><hr>';

        if($count>0){

        	echo '<div class="row"><div class="col-md-1"></div><div class="col-md-11">';

			while ($row = mysqli_fetch_array($commentresult)) {
				
				if($row['patientdoctor']=='P'){
					$patient = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM patient WHERE patientid='$row[patientid]'"));

					echo $row['commentcontent'].'<br><br>';
              		echo '<div class="row"><div class="col-xs-5 col-md-7"></div>';
              		echo '<div class="col-xs-7 col-md-5"><div class="alert alert-warning">';
             		echo 'Comment by <a href="viewprofile.php?pid='.$patient['patientid'].'">'.$patient['firstname'].' '.$patient['lastname'].'</a><br>';
              		echo $row['timeposted'];
              		echo '</div></div></div><hr>';
				}else{
					$doctor = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM doctor WHERE doctorid='$row[doctorid]'"));
                  echo '<div class="alert alert-success">';
                  if ($row['answer']=='Y') echo '<i class="fa fa-lg fa-star"></i>&emsp;';
                  echo $row['commentcontent'].'<br><br>';
              		echo '<div class="row"><div class="col-xs-5 col-md-7">';
                  if(isset($_SESSION['patientid'])){
                    if (($patientid==$_SESSION['patientid'])&&($row['answer']=='N')&&($ba==0))
                      echo '<br><br><a href="_bestanswer.php?s_id='.$row['commentid'].'">Set as best answer</a>';
                    else if (($patientid==$_SESSION['patientid'])&&($row['answer']=='Y'))
                      echo '<br><br><a href="_bestanswer.php?u_id='.$row['commentid'].'">Unset as best answer</a>';
                  }
                  echo '</div>';
              		echo '<div class="col-xs-7 col-md-5"><div class="alert alert-warning">';
             		echo 'Comment by Dr. <a href="viewprofile.php?did='.$doctor['doctorid'].'">'.$doctor['firstname'].' '.$doctor['lastname'].'</a><br>';
              		echo $row['timeposted'];
              		echo '</div></div></div>';
              		echo '</div><hr>';
				}
              
			}

			echo '</div></div>';
		}

		
		if($approved=='Y'){
		if(isset($_SESSION["type"])){
		echo '<div align="center">
            <form  action="_comment.php" method="post">
              <div class="form-group">
                <textarea type="text" placeholder="Enter comment here" name="commentcontent" class="form-control" style="margin-right:15px; margin-bottom:5px;" required></textarea>
                <input type="hidden" name="postid" value="'.$_GET['id'].'"\"" >
                <button type="Submit" class="btn btn-default" style=" margin-right:15px; margin-bottom:5px;">Submit Comment</button></li>
                </div>
            </form>
            </div>';
          }else{
         echo '<div class="alert alert-warning" align="center" role="alert">
              <strong><p>You must be logged in to comment.</p></strong>
              <p>Log in below or <a href="signup.php">sign up.</a></p>
            </div>
            <div align="center">
            <div style="width:70%;" >
            <form  action="_login.php" method="post">
              <div class="form-group">
                <input type="text" placeholder="Email Address" name="email" class="form-control" style="margin-right:15px; margin-bottom:5px;" required>
                <input type="password" placeholder="Password" name="password" class="form-control" style="margin-right:15px; margin-bottom:5px;" required>
                <button class="btn btn-default" style=" margin-right:15px; margin-bottom:5px;">Log In</button></li>
                </div>
                </form>
            </div>
            </div>';
          };
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

