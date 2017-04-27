<?php 
  session_start();

  $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
  
  if(!isset($_SESSION["type"])){
      header("location: index.php");
  }

  include("_database.php");
  
  $class3 = "active";
  $title = "Activity Log";
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo $title; ?> | Dr. Healthcare</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <link href="dist/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="dist/css/dashboard.css" rel="stylesheet">
  </head>

  <body>

    <?php include_once("header.php"); ?>

    <div class="container">

      <h1 class="page-header">Profile</h1>
           <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-8">
          <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="profile.php">Me</a></li>
        <li role="presentation" class="active"><a href="activitylog.php">Activity Log</a></li>
        <li role="presentation"><a href="friendlist.php">Friends</a></li>
        <?php if($_SESSION["type"]=='doctor') echo '<li role="presentation"><a href="review.php">Reviews</a></li>'; ?>
        </ul>
        </div>
        </div>
        <br>
        <div class="row">
          
        <div class="col-md-4">
          <div class="row placeholders">
            <div class="placeholder" align="center">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h2><?php 

                if(isset($_SESSION['doctorid'])){
                  $avgrating = mysqli_query($con, "SELECT AVG(rating) as rating FROM review WHERE doctorid='$_SESSION[doctorid]'");
                  $avgrating = mysqli_fetch_assoc($avgrating);
                  echo substr($avgrating['rating'], 0, 3).' <i class="fa fa-lg fa-stethoscope"></i>'; 
                }
                ?></h2>
              <h4> <?php echo $_SESSION["fullname"];?></h4>
              <span class="text-muted"><?php echo $_SESSION["email"];?></span>
            </div>
          </div>
        </div>

        <div class="col-md-8">
        <?php if(isset($_SESSION['patientid'])){ ?>
          <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title">Approved Posts</h3></div>
          <div class="panel-body">
                <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Post Title</th>
                      <th>Post Content</th>
                      <th>Date and Time</th>
                      <th>Solved</th>
                  </tr>
                </thead>
              <tbody>
              <?php 
                include_once("_displayactivities.php");
              ?>
            </tbody>
            </table>
            </div>
            </div>
          <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title">Pending Posts</h3></div>
          <div class="panel-body">
                <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Post Title</th>
                      <th>Post Content</th>
                      <th>Date and Time</th>
                      <th></th>
                  </tr>
                </thead>
              <tbody>
            <?php 
                $patientid = $_SESSION['patientid'];
                $sql = "SELECT * FROM post WHERE post.patientid='$patientid' and post.approved = 'N' ORDER BY timeposted desc";
                $pendingposts = mysqli_query($con, $sql);
                $pendingpostcount = mysqli_num_rows($pendingposts);
    
                if($pendingpostcount>0){

                while($activity = mysqli_fetch_assoc($pendingposts)){
                  echo '<tr>
                  <td><a href="viewpost.php?id='.$activity['postid'].'">'.$activity['posttitle'].'</td>
                  <td>'.substr($activity['postcontent'], 0, 40).'</td>
                  <td>'.date("M d h:i A" ,strtotime($activity['timeposted'])).'</td>
                  <td><a class="btn btn-default" href="_deletepost.php?id='.$activity['postid'].'">DELETE</a></td>
                  </tr>'; 
                }

                }else{
    
                  echo '<tr><td>No pending posts.</td></tr>';
    
                }     
            ?>
            </tbody>
            </table>
            </div>
            </div>
            <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title">Declined Posts</h3></div>
          <div class="panel-body">
                <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Post Title</th>
                      <th colspan="2">Message</th>
                      <th>Time Reviewed</th>
                      <th></th>
                  </tr>
                </thead>
              <tbody>
            <?php 
                $patientid = $_SESSION['patientid'];
                $sql = "SELECT * FROM post, adminmessage WHERE post.patientid='$patientid' and post.approved = 'D' and post.postid = adminmessage.postid ORDER BY post.timeposted desc";
                $declinedposts = mysqli_query($con, $sql);
                $declinedpostcount = mysqli_num_rows($declinedposts);
    
                if($declinedpostcount>0){

                while($activity = mysqli_fetch_assoc($declinedposts)){
                  echo '<tr>
                  <td><a href="viewpost.php?id='.$activity['postid'].'">'.$activity['posttitle'].'</td>
                  <td colspan="2">'.substr($activity['messagecontent'], 0, 40).'</td>
                  <td>'.date("M d h:i A" ,strtotime($activity['timereviewed'])).'</td>
                  <td><a class="btn btn-default" href="_deletepost.php?id='.$activity['postid'].'">DELETE</a></td>
                  </tr>'; 
                }

                }else{
    
                  echo '<tr><td>No pending posts.</td></tr>';
    
                }     
            ?>
            </tbody>
            </table>
            </div>
            </div>
            <?php
            
            }else if(isset($_SESSION['doctorid'])){ 

            ?>
              <div class="panel panel-default">
              <div class="panel-body">
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Post Title</th>
                      <th>Comment</th>
                      <th>Date and Time</th>
                  </tr>
                </thead>
              <tbody>
              <?php 
                include_once("_displayactivities.php");
              ?>
            </tbody>
            </table>
            </div>
            </div>
            <?php
              }
            ?>
            
          </div>
        </div>
<?php
include_once("footer.php");
?>
<?php 
      mysqli_close($con);
?>