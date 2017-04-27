<?php
session_start();
$title = "Email Confirmation";
include("_database.php");

if(isset($_POST['password'])&&isset($_POST['cpassword'])){
  if($_POST['password']==$_POST['cpassword'] && $_POST['password']!='' && $_POST['cpassword']!=''){
    $password = sha1($_POST['password']);
    $sql = "UPDATE doctor SET password = '$password', confirmed=1 WHERE doctorid = '$_POST[doctorid]'";
    $update = mysqli_query($con, $sql);

    if($update){
        echo '<script language="javascript">alert("Password successfully set!");window.location.href="index.php";</script>';
    }
  }else{
    echo '<script language="javascript">alert("Password doesn\'t match!");window.location.href="drconfirm.php?code='.$_POST['code'].'&email='.$_SESSION['email'].'";</script>';
  }
}

$code = $_GET['code'];
$email = $_GET['email'];

if ($_SESSION['email'] == $email || !$_SESSION['email']) {
  $sql = "SELECT * FROM doctor WHERE email='$email' AND password='$code'";
  $confirmresult = mysqli_query($con, $sql);
  $countresult = mysqli_num_rows($confirmresult);

  if ($countresult == 1) {
    while ($result = mysqli_fetch_array($confirmresult)) {
          $_SESSION["type"]="doctor";
          $_SESSION["doctorid"]=$result['doctorid'];
          $_SESSION["firstname"]=$result['firstname'];
          $_SESSION["lastname"]=$result['lastname'];
          $_SESSION["fullname"]=$result['firstname'] . ' ' . $result['lastname'];
          $_SESSION["email"]=$result['email'];
          $confirmed = $result["confirmed"];
    }
  }
}


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

     <?php include_once("header.php"); ?>

    <div class="container" style="width:40%; min-width: 300px; padding-top:5%">

      <h1 style="color:white; text-shadow: 2px 2px 5px #000;">Email Confirmation</h1>
        
         <div class="panel panel-default">
            <div class="panel-body">
<?php

// check if session exists. if it does, check if session email is not the same as $email
if ($_SESSION['email'] && $_SESSION['email']!= $email) {
echo "Error confirming email. You are logged in under another account. Click here to <a href='_logout.php'>logout</a> and try again.";
}
// check if session email is the same as $email OR if there's no session at all
else if ($_SESSION['email'] == $email || !$_SESSION['email']) {


    if ($countresult == 1) {
      if ($confirmed==0) {
    ?>

                Hello, Dr. <?php echo $_SESSION['firstname']; ?>! You have successfully confirmed your email. You can now set your password.
                <form action="drconfirm.php" method="post">
                <input type="hidden" name="doctorid" value="<?php echo $_SESSION['doctorid']; ?>">
                <input type="hidden" name="code" value="<?php echo $_GET['code'] ?>">
                <p><input type="password" id="pw" placeholder="Password" name="password" class="form-control" style="margin-right:15px; margin-bottom:5px;" required></p>
                <p><input type="password" id="cpw" placeholder=" Confirm Password" name="cpassword" class="form-control" style="margin-right:15px; margin-bottom:5px;" required></p>
                <p><button class="btn btn-default">SET PASSWORD</button></p>
                </form>

  <?php 
  
      }  else {
        echo 'Email address already confirmed.';
      }
    } else { 
      echo 'There was an error confirming your email.';
    }
    
} // end session check
    ?>
          </div>
          </div>
        
<?php
include_once("footer.php");
?>