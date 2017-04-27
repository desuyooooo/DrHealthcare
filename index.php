<?php
    session_start();

    $_SESSION['qtype'] = $_SERVER['REQUEST_URI']; 
    $_SESSION['from'] = "index.php";
    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 

$title = "Index";
$class1 = "active";
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
       
 <?php 
    if(isset($_SESSION["type"])){
      if($_SESSION["type"]=="patient" || $_SESSION["type"]=="doctor"){
        include_once("header.php");
      }else if($_SESSION["type"]== 'admin'){
        header("location: admin-index.php");
      }
    }else{
      include_once("header-guest.php");
    }

  ?>

    <div class="container">

      <h1 class="page-header">Forum</h1>
      <div class="row">
        <div class="col-md-9">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="index.php">All Questions</a></li>
            <li role="presentation"><a href="unanswered.php">Unanswered</a></li>
            <?php if(((isset($_SESSION["type"]))&&($_SESSION["type"]=="patient"))||(!isset($_SESSION["type"]))) echo'<li role="presentation"><a href="guest-ask-question.php">Ask a Question</a></li>';?>
          </ul>
        </div>
        <div class="col-md-3"></div>
      </div>
      
      <br>

      <div class="row">
        
          <?php

           include_once("_displayallquestions.php");

           include_once("category.php");

           ?>
          
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