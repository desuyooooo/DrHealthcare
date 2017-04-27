<?php 
  session_start();

  $_SESSION['url'] = $_SERVER['REQUEST_URI']; 

  if(!isset($_SESSION["type"]))
      header("location: index.php");

  include("_database.php");

  $email = $_SESSION["email"];
  $sql = "SELECT * FROM doctor WHERE email='$email'";
  $doctorresult = mysqli_query($con, $sql);
  
  while ($row = mysqli_fetch_array($doctorresult)) {
	  
	  $doctorid = $row['doctorid'];
	  $doctorfirstname = $row['firstname'];
    $doctormidname = $row['midname'];
	  $doctorlastname = $row['lastname'];
	  $doctorname = $doctorfirstname." ".$doctorlastname;
	  $doctoremail = $row['email'];
	  $doctorsex = $row['sex'];
	  //$doctorphoto = $row['photo'];
  
	  $sql = "SELECT * FROM doctorbackground WHERE doctorid='$doctorid'";
	  $dbresult = mysqli_query($con, $sql);
  
  }
  
  $class3 = "active";
  $title = "My Profile";
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

      <h1 class="page-header">Edit Profile</h1>
       
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
            <form class="form-group" action="_doctoreditprofile.php" method="post" enctype='multipart/form-data'>
            <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Personal Record</h3>
            </div>
            <div class="panel-body">
            <ul class="list-unstyled">
            <li>Name:
              <div class="row">
                <div class="col-md-4"><input type="text" class="form-control" placeholder="First Name" name="firstname" value="<?php echo $doctorfirstname; ?>"  required></div>
                <div class="col-md-4"><input type="text" class="form-control" placeholder="Middle Name" name="midname" value="<?php echo $doctormidname; ?>" ></div>
                <div class="col-md-4"><input type="text" class="form-control" placeholder="Last Name" name="lastname"  value="<?php echo $doctorlastname; ?>" required></div>
              </div>
            </li>
              <div class="row">
                <div class="col-xs-6 col-md-2 ">
                  <select name="sex" class="form-control" required>
                    <option disabled value="">Sex</option>
                    <option value="M" <?php if ($doctorsex=="M") echo "selected"; ?>>Male</option>
                    <option value="F" <?php if ($doctorsex=="F") echo "selected"; ?>>Female</option>
                  </select>
                </div>
              </div>
            </ul>
              
      <!--  <li>Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit"></li>-->
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Occupational Background</h3>
            </div>
            <div class="panel-body">
              <!--div class="alert alert-info" role="alert">
              <strong>Heads up!</strong> Please enter accurate information.
               </div-->

            <?php $row = mysqli_fetch_assoc($dbresult) ?>  

            <ul class="list-unstyled">
              <li>Specialty: <input type="text" class="form-control" placeholder="" name="specialty" value="<?php echo $row['specialty'];?>"></li>
              <li>Schedule: <input type="text" class="form-control" placeholder="" name="schedule" value="<?php echo $row['schedule'];?>"></li>
              <li>Hospital Name: <input type="text" class="form-control" placeholder="" name="hospitalname" value="<?php echo $row['hospitalname'];?>"></li>
              <li>Office Address: <input type="text" class="form-control" placeholder="" name="officeaddress" value="<?php echo $row['officeaddress'];?>"></li>
              <li>Office Hours: <input type="text" class="form-control" placeholder="" name="officehours" value="<?php echo $row['officehours'];?>"></li>
              <script type="text/javascript"> // for + and / only characters available
                function validate(evt) {
                var theEvent = evt || window.event;
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode( key );
                var regex = /[0-9]|\.|\/|\+/;
                if( !regex.test(key) ) {
                  theEvent.returnValue = false;
                  if(theEvent.preventDefault) theEvent.preventDefault();
                  }
                }
              </script>
              <li>Office Contact No.: <input type="text" class="form-control" placeholder="" name="officecontact"  onkeypress="validate(event)" pattern="{[0-9][+][/]}*" value="<?php echo $row['officecontact'];?>"></li>
            </ul>
            </div>
          </div>

          <!--
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Change Password</h3>
            </div>
            <div class="panel-body">
            <ul class="list-unstyled">
              <li>Old Password: <input type="text"  name="allergies"></li>
              <li>New Password: <input type="text"  name="medicalhist"></li>
              <li>Re-enter New Password: <input type="text"  name="medicalhist"></li>
            </ul>

          </div>
          </div>
          -->

          <button type="submit" class="btn btn-default">Save Changes</button>

          <a href="doctor-profile.php" class="btn btn-default">Cancel Editing</a>

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