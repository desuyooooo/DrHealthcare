<?php
   session_start();

   $_SESSION['url'] = $_SERVER['REQUEST_URI']; 

   if(isset($_SESSION["type"])){
    if($_SESSION["type"]=="patient"){
        header("location: patient-ask-question.php");
    }else if($_SESSION["type"]=="doctor"){
        header("location: index.php");
    }else if($_SESSION["type"]=="admin"){
        header("location: admin-index.php");
      }
  }
  

$title = "Ask Question";
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
 <?php include_once("header-guest.php"); ?>
       


    <div class="container">

      <h1 class="page-header">Forum</h1>
           <div class="row">
            <div class="col-md-9">
          <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="index.php">All Questions</a></li>
        <li role="presentation"><a href="unanswered.php">Unanswered</a></li>
        <li role="presentation" class="active"><a href="guest-ask-question.php">Ask a Question</a></li>
        </ul>
        </div>
          </div>
        <br>
        <div class="row">
           <div class="col-md-9">
              <div class="panel panel-default">
            <div class="panel-body"  align="center" >

            <div class="alert alert-warning" align="center" role="alert">
              <strong><p>You must be logged in to ask a question.</p></strong>
              <p>Log in below or <a href="signup.php">sign up.</a></p>
            </div>
            <div style="width:70%;" >
            <form  action="_login.php" method="post">
              <div class="form-group" >
                <input type="text" placeholder="Email Address" name="email" class="form-control" style="margin-right:15px; margin-bottom:5px;" required>
                <input type="password" placeholder="Password" name="password" class="form-control" style="margin-right:15px; margin-bottom:5px;" required>
                <button class="btn btn-default" style=" margin-right:15px; margin-bottom:5px;">Log In</button></li>
                </div>
                </form>
            </div>

            </div>
            </div>
          </div>

                    <?php include_once("category.php"); ?>

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