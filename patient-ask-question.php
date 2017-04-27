<?php
  session_start();

  $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
  
   if(!isset($_SESSION["type"]))
      header("location: index.php");

$title = "Ask question";
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
  include_once("header.php");
 ?>
       


    <div class="container">

      <h1 class="page-header">Forum</h1>
           <div class="row">
            <div class="col-md-9">
          <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="index.php">All Questions</a></li>
        <li role="presentation"><a href="unanswered.php">Unanswered</a></li>
        <li role="presentation"  class="active"><a href="guest-ask-question.php">Ask a Question</a></li>
        </ul>
        </div>
          </div>
        <br>
        <div class="row">
           <div class="col-md-9">
              <div class="panel panel-default">
            <div class="panel-body">

            <div class="row">
            <div class="col-md-9">
            
            <form action="_patientpost.php" method="post">
            <?php
            
            if(isset($_SESSION['post'])){
            if($_SESSION['post']=='Y'){
              echo '<div class="alert alert-warning" align="center" role="alert">
              <strong><p>Post sent to administrator for approval.</p></strong>
              <p>Wait lang.</p>
              </div>';

              $_SESSION['post'] = 'N';
            }
            }else{
              $_SESSION['post'] = 'N';
            }

             ?>
              <div class="form-group" >
              <p>Title: <input type="text" placeholder="Title or subject of your thread" name="posttitle" class="form-control" style="margin-right:15px; margin-bottom:5px;" required></p>
              <p>Content<textarea type="text" placeholder="Please enter the content" name="postcontent" class="form-control" style="margin-right:15px; margin-bottom:5px;" required></textarea></p>
              <p><input type="text" placeholder="#tags separated by space" name="posttag" class="form-control" style="margin-right:15px; margin-bottom:5px;" pattern="((#[a-zA-Z0-9_]*)[\s]*)*" title="#tag1<space>#tag2" required></p>
              <p>Category:
              <select name="cat" name="category" required>                      
              <option  selected disabled value="">--Select Category--</option>
              <?php
                  include("_database.php");
                  $cat = mysqli_query($con, "SELECT * FROM category ORDER BY catname");

                  while ($row = mysqli_fetch_array($cat)){
                          echo '<option value="'.$row['catid'].'">'.$row['catname'].'</option>';
                  }
              ?>
              </select></p>
              <p><button type="submit" class="btn btn-default" >SUBMIT</button></p>
                </div>
                </form>
            </div>
            </div>
            <hr>

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