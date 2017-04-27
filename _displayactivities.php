<?php
	include_once("_database.php");
	if(isset($_GET['did'])){
		
		isset($_GET['did']) ? $doctorid = $_GET['did'] : $doctorid = $_SESSION['doctorid'];

		$sql = "SELECT post.postid, post.posttitle, comment.commentcontent, comment.timeposted FROM post, comment WHERE comment.doctorid='$doctorid' and comment.postid = post.postid ORDER BY timeposted desc";
		$activities = mysqli_query($con, $sql);
		$activitycount = mysqli_num_rows($activities);
		
		if($activitycount>0){

		while($activity = mysqli_fetch_assoc($activities)){
				echo '<tr>
                <td><a href="viewpost.php?id='.$activity['postid'].'">'.$activity['posttitle'].'</td>
                <td>'.substr($activity['commentcontent'], 0, 50).'</td>
                <td>'.$activity['timeposted'].'</td>
              	</tr>';	
			}

		}else{
		
			echo '<tr><td>No activities to display.</tr></td>';
		
		}

	}else if(isset($_GET['pid'])){

		isset($_GET['pid']) ? $patientid = $_GET['pid'] : $patientid = $_SESSION['patientid'];

		$sql = "SELECT * FROM post WHERE post.patientid='$patientid' and post.approved = 'Y' ORDER BY timeposted desc";
		$activities = mysqli_query($con, $sql);
		$activitycount = mysqli_num_rows($activities);
		
		if($activitycount>0){

		while($activity = mysqli_fetch_assoc($activities)){
				echo '<tr>
                <td><a href="viewpost.php?id='.$activity['postid'].'">'.$activity['posttitle'].'</td>
                <td>'.substr($activity['postcontent'], 0, 40).'...</td>
                <td>'.date("M d h:i A" ,strtotime($activity['timeposted'])).'</td>
                <td>'.$activity['solved'].'</td>
              	</tr>';	
			}

		}else{
		
			echo '<tr><td>No activities to display.</tr></td>';
		
		}			
	}else if(!isset($_GET['did'])&&isset($_SESSION['doctorid'])){
		
		$doctorid = $_SESSION['doctorid'];

		$sql = "SELECT post.postid, post.posttitle, comment.commentcontent, comment.timeposted FROM post, comment WHERE comment.doctorid='$doctorid' and comment.postid = post.postid ORDER BY timeposted desc";
		$activities = mysqli_query($con, $sql);
		$activitycount = mysqli_num_rows($activities);
		
		if($activitycount>0){

		while($activity = mysqli_fetch_assoc($activities)){
				echo '<tr>
                <td><a href="viewpost.php?id='.$activity['postid'].'">'.$activity['posttitle'].'</td>
                <td>'.substr($activity['commentcontent'], 0, 50).'</td>
                <td>'.$activity['timeposted'].'</td>
              	</tr>';	
			}

		}else{
		
			echo '<tr><td>No activities to display.</tr></td>';
		
		}

	}else if(!isset($_GET['pid'])&&isset($_SESSION['patientid'])){

		$patientid = $_SESSION['patientid'];

		$sql = "SELECT * FROM post WHERE post.patientid='$patientid' and post.approved = 'Y' ORDER BY timeposted desc";
		$activities = mysqli_query($con, $sql);
		$activitycount = mysqli_num_rows($activities);
		
		if($activitycount>0){

		while($activity = mysqli_fetch_assoc($activities)){
				echo '<tr>
                <td><a href="viewpost.php?id='.$activity['postid'].'">'.$activity['posttitle'].'</td>
                <td>'.substr($activity['postcontent'], 0, 40).'...</td>
                <td>'.date("M d h:i A" ,strtotime($activity['timeposted'])).'</td>
                <td>'.$activity['solved'].'</td>
              	</tr>';	
			}

		}else{
		
			echo '<tr><td>No activities to display.</tr></td>';
		
		}			
	}

	

	

	
?>