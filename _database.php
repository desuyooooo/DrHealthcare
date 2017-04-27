<?php
include_once("__config.php");
$con = mysqli_connect("localhost", $dbuser, $dbpassword);
	
  if (!mysqli_select_db($con, 'drhealthcare')) {
    mysqli_query($con, 'CREATE DATABASE drhealthcare');
    mysqli_select_db($con, 'drhealthcare');
  }

if(!$con){
	die ('Could not connect: '.mysqli_error_());
}
?>