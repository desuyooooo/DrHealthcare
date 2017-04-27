<?php 
  session_start();
  
  $_SESSION['url'] = $_SERVER['REQUEST_URI']; 

  if(!isset($_SESSION["type"])){
      header("location: index.php");
  }else{
    if($_SESSION["type"]=='patient'){
      header("location: patient-profile.php");
    }
  }

  include("_database.php");

  $email = $_SESSION["email"];
  $sql = "SELECT * FROM doctor WHERE email='$email'";
  $doctorresult = mysqli_query($con, $sql);
  
  while ($row = mysqli_fetch_array($doctorresult)) {
	  
	  $doctorid = $row['doctorid'];
	  $doctorfirstname = $row['firstname'];
	  $doctormidname = $row['midname'];
    $doctorlastname = $row['lastname'];
	  $doctorname = $doctorfirstname." ". $doctormidname ." ".$doctorlastname;
	  $doctoremail = $row['email'];
	  $doctorsex = $row['sex'];
	  //$doctorphoto = $row['photo'];
  
	  $sql = "SELECT * FROM doctorbackground WHERE doctorid='$doctorid'";
	  $dbresult = mysqli_query($con, $sql);
  
  }

  $avgrating = mysqli_query($con, "SELECT AVG(rating) as rating FROM review WHERE doctorid='$doctorid'");
  $avgrating = mysqli_fetch_assoc($avgrating);
  
  $title = "My Profile";
  $class3 = "active";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="dr. Healthcare index page">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title> <?php echo $title; ?> | Dr. Healthcare</title>

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
        <li role="presentation"><a href="review.php">Reviews</a></li>
        </ul>
        </div>
        </div>

        <br>

        <div class="row">
          <div class="col-md-4">
          <div class="row placeholders">
            <div class="placeholder" align="center">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h2><?php echo substr($avgrating['rating'], 0, 3).' <i class="fa fa-lg fa-stethoscope"></i>'; ?></h2>
              <h4> <?php echo $_SESSION["fullname"];?></h4>
              <span class="text-muted"><?php echo $_SESSION["email"];?></span>
            </div>
          </div>
            </div>
			
		
            <div class="col-md-8">
            <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Personal Information</h3>
            </div>
            <div class="panel-body">
            <ul class="list-unstyled">
              <li>Name: <?php echo $doctorname; ?></li>
              <li>Sex: <?php echo $doctorsex; ?></li>
              <li>E-mail: <?php echo $doctoremail; ?></li>
              </ul>
            </div>
          </div>
		  
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Background</h3>
            </div>
            <div class="panel-body">
            <ul class="list-unstyled">
            <?php $row = mysqli_fetch_assoc($dbresult) ?>  
              <li>Specialty: <?php echo $row['specialty'];?></li>
              <li>Hospital Name: <?php echo $row['hospitalname'];?></li>
              <li>Office Address: <?php echo $row['officeaddress'];?></li>
              <li>Office Hours: <?php echo $row['officehours'];?></li>
              <li>Office Contact No.: <?php echo $row['officecontact'];?></li>
               </ul>
            </div>
          </div>
          <a href="doctor-edit-profile.php" class="btn btn-default">Edit Profile</a>
        </div>
        </div>
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