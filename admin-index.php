<?php 
  session_start();
  if(!isset($_SESSION["type"]))
    header("location: index.php");
  else if($_SESSION["type"]=='patient'||$_SESSION["type"]=='doctor')
    header("location: index.php");

  include("_database.php");

  $sql = "SELECT * FROM patient p, patientpersonal pp, patientmedical pm WHERE p.patientid = pp.patientid AND pp.patientid = pm.patientid";
  $patientresult = mysqli_query($con, $sql);
  
  $title = "Forum";
  $class1 = "active";
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
<?php
  include_once("header-admin.php");
?>

    <div class="container">

      <h1 class="page-header">Forum</h1>
        <div class="row">
          <div class="col-md-9">
          <div class="panel panel-default">
            <div class="panel-body">

            <?php

            if(!isset($_GET['id'])&&!isset($_GET['tag']))
             { 
                         $sql = "SELECT * FROM post p, category c, patient pt WHERE p.catid = c.catid and p.patientid = pt.patientid and p.approved='N' ORDER BY postid desc";
                         $postresult = mysqli_query($con, $sql);
             
                         $count = mysqli_num_rows($postresult);
             
                         if($count==0){
                           echo '<label align="center">No pending posts available.</label>';
                         }else{
                           while ($row = mysqli_fetch_array($postresult)) {
             
                           echo '<h4><strong><a href="admin-viewpost.php?id='.$row['postid'].'">'.$row['posttitle'].'</a></strong></h4>';
                           echo '<div class="row"><div class="col-md-6">';
                           
                           echo '<p>'.substr($row['postcontent'], 0, 80).'...</p>';
                           echo '<strong><a href="searchcat.php?id='.$row['catid'].'">'.$row['catname'].'</a></strong> | ';
                           echo $row['tag'].'<br>';
                           echo '</div><div class="col-md-3">';
                           echo 'Asked by '.$row['firstname'].' '.$row['lastname'].'<br>';
                           echo $row['timeposted'];
                           echo '</div><div class="col-xs-6 col-md-3">';
                           echo '<a href="_approvepost.php?id='.$row['postid'].'"><button class="btn btn-default">APPROVE POST</button></a>';
                           echo '</div><div class="col-xs-6 col-md-3">';
                           echo '<a href="admin-viewpost.php?id='.$row['postid'].'" class="btn btn-default">VIEW POST</a>';
                           echo '</div></div><hr>';
                           }
                         }
             }else if(isset($_GET['id'])) {
              isset($_GET['approved'])? $approved = 'Y': $approved = 'N';
            $sql = "SELECT * FROM post p, category c, patient pt WHERE c.catid='$_GET[id]' and p.catid = c.catid and p.patientid = pt.patientid and p.approved = '$approved' ORDER BY postid desc";
            $postresult = mysqli_query($con, $sql);

            $count = mysqli_num_rows($postresult);

            if($count==0){
              echo '<label>No posts available. Back to <a href="admin-index.php">index</a>.</label>';
            }else{
              $cat = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM category WHERE catid='$_GET[id]'"));
              echo '<h2>Category: <a href="#">'.$cat['catname'].'</a></h2><hr>';
              
              while ($row = mysqli_fetch_array($postresult)) {

              $tags = $row['tag'];
              $arrTags = explode("#", trim($tags));

              echo '<h4><strong><a href="admin-viewpost.php?id='.$row['postid'].'">'.$row['posttitle'];
              if($row['solved']=='Y') echo ' (Solved)';
              echo '</a></strong></h4>';
              echo '<div class="row"><div class="col-md-8">';
              
              echo '<p>'.substr($row['postcontent'], 0, 60).'...</p>';
              echo '<strong><a href="?id='.$row['catid'].'&approved=Y">'.$row['catname'].'</a></strong> | Tags: ';
              foreach($arrTags as $count)
              {
                if($count != '') echo '<a href="?tag='.$count.'&approved=Y">#'.$count.'</a> ';  
              }
              echo '<br>';
              echo '</div><div class="col-md-4">';
              echo 'Asked by '.$row['firstname'].' '.$row['lastname'].'<br>';
              echo $row['timeposted'];
              echo '</div></div><hr>';
              }
            }
            }else if (isset($_GET['tag'])) {

                isset($_GET['approved'])? $approved = 'Y': $approved = 'N';
            $sql = "SELECT * FROM post p, category c, patient pt WHERE `tag` LIKE '%$_GET[tag]%' and p.catid = c.catid and p.patientid = pt.patientid and p.approved = '$approved' ORDER BY postid desc";

            $postresult = mysqli_query($con, $sql);

            $count = mysqli_num_rows($postresult);

            if($count==0){
              echo '<label>No posts available. Back to <a href="admin-index.php">index</a>.</label>';
            }else{
              echo '<h2>Tag: #'.$_GET['tag'].'</h2><hr>';

              while ($row = mysqli_fetch_array($postresult)) {

              $tags = $row['tag'];
              $arrTags = explode("#", trim($tags));

              echo '<h4><strong><a href="admin-viewpost.php?id='.$row['postid'].'">'.$row['posttitle'].'</a></strong></h4>';
              echo '<div class="row"><div class="col-md-8">';
              
              echo '<p>'.substr($row['postcontent'], 0, 60).'...</p>';
              echo '<strong><a href="?id='.$row['catid'].'&approved=Y">'.$row['catname'].'</a></strong> | Tags: ';
              foreach($arrTags as $count)
              {
                if($count != '') echo '<a href="?tag='.$count.'&approved=Y">#'.$count.'</a> ';  
              }
              echo '<br>';
              echo '</div><div class="col-md-4">';
              echo 'Asked by '.$row['firstname'].' '.$row['lastname'].'<br>';
              echo $row['timeposted'];
              echo '</div></div><hr>';
              }
            }
            }
            ?>
            </div>
            </div>
          </div>
          <?php include_once("category.php"); ?>
          
        </div>
<?php
	include_once("footer.php");
	mysqli_close($con);
?>