<?php 
  session_start();
  if(!isset($_SESSION["type"])){
      header("location: index.php");
  }else{
    if($_SESSION["type"]=='patient'){
      header("location: patient-profile.php");
    }else if($_SESSION["type"]=='doctor'){
      header("location: doctor-profile.php");
    }
  }


 ?>