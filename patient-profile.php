<?php 
  session_start();

  $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
  
  if(!isset($_SESSION["type"])){
      header("location: index.php");
  }else{
    if($_SESSION["type"]=='doctor'){
      header("location: doctor-profile.php");
    }
  }
  
  include("_database.php");

  $patientid = $_SESSION["patientid"];
  $sql = "SELECT * FROM patient p, patientpersonal pp, patientmedical pm WHERE p.patientid = $patientid and pp.patientid = p.patientid and pm.patientid = p.patientid";
  $patientresult = mysqli_query($con, $sql); 
  $row = mysqli_fetch_assoc($patientresult);  
  
  
  $class3 = "active";
  $title = "Profile";
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
        <li role="presentation" class="active"><a href="profile.php">Me</a></li>
        <li role="presentation"><a href="activitylog.php">Activity Log</a></li>
        <li role="presentation"><a href="friendlist.php">Friend List</a></li>
        </ul>
        </div>
        </div>

        <br>

        <div class="row">
          <div class="col-md-4">
          <div class="row placeholders">
            <div class="placeholder" align="center">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4> <?php echo $_SESSION["fullname"];?></h4>
              <span class="text-muted"><?php echo $_SESSION["email"];?></span>
            </div>
          </div>
            </div>
            <div class="col-md-8">
            <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Personal Record</h3>
            </div>
            <div class="panel-body">
            <ul class="list-unstyled">
              <li>Name: <?php echo $row['firstname'] . ' ' . $row['midname'] . ' ' . $row['lastname']; ?></li>  
              <li>Sex: <?php echo $row['sex'];?></li>
              <li>Birthdate: <?php echo $row['bdate'];?></li>
              <li>Address: <?php echo $row['address'];?></li>
              <li>Contact No: <?php echo $row['contact'];?></li>
              </ul>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Medical Record</h3>
            </div>
            <div class="panel-body">
            <ul class="list-unstyled">
              <li>Height: <?php echo $row['height'];?>cm</li>
              <li>Weight: <?php echo $row['weight'];?>kg</li>
              <li>Blood Type: <?php echo $row['bloodtype'];?></li>
              <li>Blood Pressure: <?php echo $row['bloodpressure'];?></li>
              <li>Known Allergies: <?php echo $row['allergies'];?></li>
              <li>Medical History: <?php echo $row['medicalhist'];?></li>
               </ul>
            </div>
          </div>
          <a href="patient-edit-profile.php" class="btn btn-default">Edit Profile</a>
        </div>
        </div>
<?php
include_once("footer.php");
?>
<?php 
  include_once("_footer.php");
?>
    <script>
      $( function() {
      $( "#datepicker" ).datepicker();
    } );
  </script>
  </body>
</html>
<?php 
      mysqli_close($con);
?>