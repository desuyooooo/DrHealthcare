<?php 
  session_start();

  $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
  
  if(!isset($_SESSION["type"])){
      header("location: index.php");
  }

  include("_database.php");
  
  $class4 = "active";
  $title = "Messages";
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
    <link href="dist/css/messages.css" rel="stylesheet">
  </head>

  <body>

    <?php include_once("header.php"); ?>

    <div class="container">

      <h1 class="page-header">Messages</h1>
  
      <!--MESSAGE BOX-->
      <?php include_once("_messagebox.php"); ?>

      
<?php
include_once("_footer.php");
?>
    <script type="text/javascript" src="dist/js/ajaxchat.js"></script> 
  <script>
    $( function() {
    $( "#datepicker" ).datepicker();
    } );
  </script>
  </body>
</html>