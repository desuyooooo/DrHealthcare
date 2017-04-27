<?php 
  session_start();

  $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
  
  if(!isset($_SESSION["type"]))
      header("location: index.php");

  include("_database.php");

  $patientid = $_SESSION["patientid"];
  $sql = "SELECT * FROM patient WHERE patientid='$patientid'";
  $patientresult = mysqli_query($con, $sql);
  $sql = "SELECT * FROM patientpersonal WHERE patientid='$patientid'";
  $ppresult = mysqli_query($con, $sql);
  $sql = "SELECT * FROM patientmedical WHERE patientid='$patientid'";
  $pmresult = mysqli_query($con, $sql);
  $title = "Edit Profile";
  $class3 = "active";
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
            <form class="form-group" action="_patienteditprofile.php" method="post">
            <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Personal Record</h3>
            </div>
            <div class="panel-body">
            <ul class="list-unstyled">
            <?php $row = mysqli_fetch_assoc($patientresult) ?>
              <li>
              <div class="row">
                <div class="col-md-4"><input type="text" class="form-control" placeholder="First Name" name="firstname" value="<?php echo $row['firstname']; ?>"  required></div>
                <div class="col-md-4"><input type="text" class="form-control" placeholder="Middle Name" name="midname" value="<?php echo $row['midname']; ?>" ></div>
                <div class="col-md-4"><input type="text" class="form-control" placeholder="Last Name" name="lastname"  value="<?php echo $row['lastname']; ?>" required></div>
              </div>
              </li>

            <?php $row = mysqli_fetch_assoc($ppresult) ?>  

              <li><div class="row">
                <div class="col-xs-6 col-md-4 ">
                  <select name="sex" class="form-control" required>
                    <option disabled value="">Sex</option>
                    <option value="M" <?php if ($row['sex']=="M") echo "selected"; ?>>Male</option>
                    <option value="F" <?php if ($row['sex']=="F") echo "selected"; ?>>Female</option>
                  </select>
                </div>
                <div class="col-xs-6 col-md-4 ">
                  <input type="date" class="form-control" placeholder="YYYY-MM-DD" id="datepicker" name="bdate" value="<?php echo $row['bdate']; ?>"/>
                </div>
              </div></li>
              <li><input type="text" class="form-control" placeholder="Street Address, City, Province" value="<?php echo $row['address']; ?>" name="address"></li>
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
              <li><input type="text" class="form-control" name="contact" placeholder="" onkeypress="validate(event)" pattern="{[0-9][+][/]}*" value="<?php echo $row['contact']; ?>"></li>
              




              </ul>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Medical Record</h3>
            </div>
            <div class="panel-body">
              <!--div class="alert alert-info" role="alert">
              <strong>Heads up!</strong> Please enter accurate information.
               </div-->

            <?php $row = mysqli_fetch_assoc($pmresult) ?>  

            <ul class="list-unstyled">
              <li>
              Height (in cm): <input type="text" class="form-control" placeholder="cm" name="height" value="<?php echo $row['height']; ?>" pattern="[0-9]+" style="max-width: 100px;">
              </li>
              <li>
              Weight (in kg): <input type="text" class="form-control" placeholder="kg" name="weight" value="<?php echo $row['weight']; ?>" pattern="[0-9]+" style="max-width: 100px;">
              </li>
              <li>Blood Type: <select name="bloodtype" class="form-control" style="max-width: 100px;"><option><?php echo $row['bloodtype']; ?></option>><option>A</option><option>B</option><option>AB</option><option>O</option></select></li>
              <li>Blood Pressure: <input type="text" class="form-control" placeholder="Sys/Dia" name="bloodpressure" pattern="[0-9]{2,3}+[/]+[0-9]{2,3}" style="max-width: 100px;"></li>
              <li>Known Allergies: <input type="text" class="form-control" placeholder="separate by comma" name="allergies" value="<?php echo $row['allergies']; ?>"></li>
              <li>Medical History: <input type="text" class="form-control" placeholder="separate by comma" name="medicalhist" value="<?php echo $row['medicalhist']; ?>"></li>
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

          <a href="patient-profile.php" class="btn btn-default">Cancel Editing</a>

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