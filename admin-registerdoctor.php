<?php 
  session_start();
  if(!isset($_SESSION["type"]))
    header("location: 01Homepage.php");
  else if($_SESSION["type"]=='patient')
    header("location: 04PatientProfile.php");

  include("_database.php");

	$title = "Register Doctor";
	$class4 = "active";
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

    <div class="container" style="width: 60%; min-width: 375px;">

      <h1 class="page-header">Register Doctor</h1>
        <div class="form-group">
        <form action="_registerdoctor.php" method="post" name="form">
        <div class="panel panel-default" >
            <div class="panel-heading">
              <h3 class="panel-title">Personal Information</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-4"><input type="text" class="form-control" placeholder="First Name" name="firstname" required></div>
                <div class="col-md-4"><input type="text" class="form-control" placeholder="Middle Name" name="midname"></div>
                <div class="col-md-4"><input type="text" class="form-control" placeholder="Last Name" name="lastname" required></div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-2 ">
                  <select name="sex" class="form-control" required>
                    <option disabled selected value="">Sex</option>
                    <option>Male</option>
                    <option>Female</option>
                  </select>
                </div>
              </div>
              <input class="form-control" type="email" placeholder="E-mail Address" name="email" required>
              <!--
              <input class="form-control" type="password" placeholder="Password" name="password" required>
              <input class="form-control" type="password" placeholder=" Confirm Password" name="cpassword"  required>
              -->
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Occupational Background</h3>
            </div>
            <div class="panel-body">
            
            <!--idk what to put yet. SCHEDULE / SPECIALTY / HOSPITAL-CLINIC NAME / OFFICE ADDRESS / CONTACT INFORMATION / BIRTHDAY? /  ANO PAAAA
              Type:
              <input type="radio" class="radio" name="type" value="gp" checked="" onclick="document.getElementById('specialty').disabled=true">General Practitioner</input>
              <input type="radio" class="radio" name="type" value="specialist" onclick="document.getElementById('specialty').disabled=false">Specialist</input>

            -->
              <label class="custom-control custom-radio">
                <input id="radio1" name="type" value="gp" type="radio" checked class="custom-control-input" onclick="document.getElementById('specialty').disabled=true">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">General Practitioner</span>
              </label>
              &emsp;
              <label class="custom-control custom-radio">
                <input id="radio2" name="type" value="Sp" type="radio" class="custom-control-input" onclick="document.getElementById('specialty').disabled=false">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Specialist</span>
              </label>

              <input type="text" class="form-control" placeholder="Specialty" name="specialty" id="specialty" disabled="">
              <input type="text" class="form-control" placeholder="Schedule" name="schedule" required>
              <input type="text" class="form-control" placeholder="Hospital/Clinic Name" name="hospitalname" required>
              <input type="text" class="form-control" placeholder="Office Address" name="officeaddress" required>
              <input type="text" class="form-control" placeholder="Office Hours" name="officehours" style="width:20%; min-width:150px;" required>
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
              <input type="text" class="form-control" placeholder="Office Contact" name="officecontact" style="width:20%; min-width: 150px;" onkeypress="validate(event)" required>
            
            </div>
        </div>
          <p><button type="submit" class="btn btn-lg btn-default" >REGISTER DOCTOR</button></p>
        </div>

          </form>
          
<?php 
	include_once("footer.php");
	mysqli_close($con);
?>


<!--
Specialties // make checkbox or something

Anesthesiologist 
Cardiologist 
Dermatologist
Diabetes specialist/Endocrinologist
Emergency medicine physician 
Gastroenterologist 
General surgeon
Infectious disease/HIV physician 
Nephrologist 
Neurologist
Obstetrician/Gynecologist
Oncologist 
Ophthalmologist
Orthopedic surgeon 
Pediatrician 
Plastic surgeon
Podiatrist 
Primary care physician 
Psychiatrist 
Pulmonologist
Radiologist
Rheumatologist 
Urologist
-->