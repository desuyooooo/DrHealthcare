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
        <li role="presentation" class="active"><a href="admin-category.php">Display categories</a></li>
        <li role="presentation"><a href="admin-editcategory.php">Edit categories</a></li>
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

              echo '<h4><strong>'.$row['catname'].'</strong></h4>';
              echo '<div class="row"><div class="col-md-6">';
              
              echo '<p>'.$row['catdesc'].'</p></div></div>';
              
              }
            }
            ?>

            </div>
</div>

          
        </div>
<?php
	include_once("footer.php");
	mysqli_close($con);
?>