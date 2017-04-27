<?php

$class3 = "active";
$title = "Email Confirmation";
include("_database.php");
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

    <?php if ($_SESSION['email'] == $email) include_once("header.php"); else if (!$_SESSION['email']) include_once("header-guest.php"); ?>

    <div class="container" style="width:40%; min-width: 300px; padding-top:5%">

      <h1 style="color:white; text-shadow: 2px 2px 5px #000;">Email Confirmation</h1>
        
         <div class="panel panel-default">
            <div class="panel-body">
<?php
$code = $_GET['code'];
$email = $_GET['email'];

// check if session exists. if it does, check if session email is not the same as $email
if ($_SESSION['email'] && $_SESSION['email']!= $email) {
echo "Error confirming email. You are logged in under another account. Click here to <a href='_logout.php'>logout</a> and try again.";
}
// check if session email is the same as $email OR if there's no session at all
else if ($_SESSION['email'] == $email || !$_SESSION['email']) {

$sql = "SELECT * FROM patient WHERE email='$email' AND code='$code'";
  $confirmresult = mysqli_query($con, $sql);

if (mysqli_num_rows($confirmresult) == 1) {

  while ($result = mysqli_fetch_array($confirmresult)) {
        $_SESSION["type"]="patient";
        $_SESSION["patientid"]=$result['patientid'];
        $_SESSION["firstname"]=$result['firstname'];
        $_SESSION["lastname"]=$result['lastname'];
        $_SESSION["fullname"]=$result['firstname'] . ' ' . $result['lastname'];
        $_SESSION["email"]=$result['email'];
    if ($result['confirmed']==0) {
$sql2 = "UPDATE patient SET confirmed=1";
  $confirmupdate = mysqli_query($con, $sql2);
?>
            You have successfully confirmed your email. Thank you! Back to <a href="index.php">index</a>.

<?php }
    else {
?>
            Email address already confirmed.
<?php
    }
  } // end while
}
else { ?>
There was an error confirming your email.
<?php }
} // end session check
?>
          </div>
          </div>
        
<?php
include_once("footer.php");
?>