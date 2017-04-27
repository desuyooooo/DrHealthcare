<?php 
  session_start();
if(!isset($_SESSION["type"]))
    header("location: index.php");
  else if($_SESSION["type"]=='patient'||$_SESSION["type"]=='doctor')
    header("location: index.php");

  include("_database.php");

  $sql = "SELECT * FROM patient p, patientpersonal pp, patientmedical pm WHERE p.patientid = pp.patientid AND pp.patientid = pm.patientid";
  $patientresult = mysqli_query($con, $sql);
  
  $title = "Edit Category";
  $class5 = "active";

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

      <h1 class="page-header">Categories</h1>

      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="admin-category.php">Display categories</a></li>
        <li role="presentation" class="active"><a href="admin-editcategory.php">Edit categories</a></li>
        </ul>
        <div class="row">
          <div class="panel panel-default">
            <div class="panel-body">

            <?php

            $sql = "SELECT * FROM category";
            $postresult = mysqli_query($con, $sql);

            $count = mysqli_num_rows($postresult);

            if($count==0){
              echo '<label align="center">No questions available.</label>';
            }else{
              while ($row = mysqli_fetch_array($postresult)) {

                //CATEGORY: CATID CATNAME CATDESC
              echo '<form action="_admineditcat.php" method="post"><div class="form-group">';
              echo '<div class="row"><div class="col-md-4">';
              //
              echo '<input type="hidden" name="catid" value="'.$row['catid'].'">';
              echo '<input type="text" name="catname" class="form-control" value="'.$row['catname'].'"" required></div>';
              echo '<div class="col-md-2"><button class="btn btn-default">UPDATE</button></div>';
              echo '<div class="col-md-2"><a href="_adminremovecat.php?id='.$row['catid'].'" class="btn btn-default">REMOVE</a></div></div>';
              echo '<div class="row"><div class="col-md-8">';
              echo '<textarea class="form-control" name="catdesc" placeholder="Add category description here">'.$row['catdesc'].'</textarea></div></div><br>';
              
              echo '</div></form>';
              }
            }
            ?>


            <form action="_adminaddcat.php" method="post">
            <div class="form-group">
              <div class="row"><div class="col-md-4">
              <input type="text" class="form-control" name="catname" placeholder="Category Name" required></div>
              <div class="col-md-4"><button class="btn btn-default">ADD CATEGORY</button></div></div>
              <div class="row"><div class="col-md-8">
              <textarea class="form-control" name="catdesc" placeholder="Add category description here"></textarea></div></div><br>
            </div>
            </form>

            </div>
          </div>

          
        </div>
<?php
	include_once("footer.php");
	mysqli_close($con);
?>