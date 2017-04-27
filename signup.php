<?php
  /*
   if(isset($_SESSION["type"])){
    if($_SESSION["type"]=="patient"){
        header("location: 01PatientProfile.php");
    }else if($_SESSION["type"]=="doctor"){
        header("location: 01PatientProfile.php");
    }else if($_SESSION["type"]=="admin"){
        header("location: 01PatientProfile.php");
  */

$class3 = "active";
$title = "Index";
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
    <!-- Custom styles for this template -->
    <link href="dist/css/dashboard.css" rel="stylesheet">

  </head>

<body background="dist/images/background2.jpg" style="background-size: cover;">

    <?php include_once("header-guest.php"); ?>

    <div class="container" style="width:40%; min-width: 300px; padding-top:5%">

      <h1 style="color:white; text-shadow: 2px 2px 5px #000;">Sign-Up</h1>
        
         <div class="panel panel-default">
            <div class="panel-body">
            <form action="_register.php" method="post">
              <div class="form-group" >
              <p><input type="text" placeholder="First Name" name="firstname" class="form-control" style="margin-right:15px; margin-bottom:5px;" required></p>
              <p><input type="text" placeholder="Last Name" name="lastname" class="form-control" style="margin-right:15px; margin-bottom:5px;" required></p>
              <p><input type="email" placeholder="E-mail Address" name="email" class="form-control" style="margin-right:15px; margin-bottom:5px;" required></p>
              <p><input type="password" placeholder="Password" name="password" class="form-control" style="margin-right:15px; margin-bottom:5px;" required></p>
              <p><input type="password" placeholder=" Confirm Password" name="cpassword" class="form-control" style="margin-right:15px; margin-bottom:5px;" required></p>
              <p><button type="submit" class="btn btn-default" >REGISTER</button></p>
              </div>
              </form>
          </div>
          </div>
        
<?php
include_once("footer.php");
?>
