<?php
    session_start();

    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 

    if(isset($_SESSION["type"])&&($_SESSION['type']=='admin')){
      header("location: admin-viewpost.php?id=$_GET[id]");
    }


$title = "Index";
$class1 = "active";
$selectedindex = '';
$selectedunans = '';
(isset($_SESSION['qtype']))?(($_SESSION['qtype']=='index.php')?$selectedindex='class="active"':$selectedunans='class="active"'):$selectedindex='class="active"'

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
      include_once("header.php");
    }else{
      include_once("header-guest.php");
    }

  ?>       


    <div class="container">

      <h1 class="page-header">Forum</h1>
           <div class="row">
            <div class="col-md-9">
          <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="index.php">All Questions</a></li>
        <li role="presentation"><a href="unanswered.php">Unanswered</a></li>
        <li role="presentation"><a href="guest-ask-question.php">Ask a Question</a></li>
        </ul>
        </div>
          <div class="col-md-3">
          </div>
          </div>
        <br>

        <div class="row">
        
        <div class="col-md-9"><div class="panel panel-default"><div class="panel-body">

        <?php include_once("_viewpost.php");

        ?>
        

        </div></div></div>

        <?php include_once("category.php");?>
          
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
