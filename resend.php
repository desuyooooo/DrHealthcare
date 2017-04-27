<?php

session_start();
include_once("_database.php");

$getcode = mysqli_query($con,"SELECT code, firstname, email FROM patient WHERE email = '$_SESSION[email]'");
$result = mysqli_fetch_assoc($getcode);
$firstname = $result['firstname'];
$code = $result['code'];
$email = $result['email'];
/*** SEND EMAIL ON REGISTER ***/
// the message
$msg = "Welcome to Dr. Healthcare, ".$firstname."!\n\nThanks for registering. Please click on the link below to confirm your email address.\n\nhttp://drhealthcare.000webhostapp.com/confirm.php?code=".$code."&email=".$email;

// send email
mail($_SESSION["email"],"Dr. Healthcare Registration",$msg);

(isset($_SESSION['url'])) ? $url = $_SESSION['url'] : $url = "index.php"; 

echo '<script language="javascript">alert("Confirmation email successfully resent!");window.location.href="'.$url.'";</script>';

?>