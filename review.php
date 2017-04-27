<?php 
  session_start();
  
  $_SESSION['url'] = $_SERVER['REQUEST_URI']; 

  if(!isset($_SESSION["type"])){
      header("location: index.php");
  }else{
    if($_SESSION["type"]=='patient'){
      header("location: patient-profile.php");
    }
  }

  include("_database.php");

  $email = $_SESSION["email"];
  $sql = "SELECT * FROM doctor WHERE email='$email'";
  $doctorresult = mysqli_query($con, $sql);
  
  while ($row = mysqli_fetch_array($doctorresult)) {
    
    $doctorid = $row['doctorid'];
    $doctorfirstname = $row['firstname'];
    $doctormidname = $row['midname'];
    $doctorlastname = $row['lastname'];
    $doctorname = $doctorfirstname." ". $doctormidname ." ".$doctorlastname;
    $doctoremail = $row['email'];
    $doctorsex = $row['sex'];
    //$doctorphoto = $row['photo'];
  
    $sql = "SELECT * FROM doctorbackground WHERE doctorid='$doctorid'";
    $dbresult = mysqli_query($con, $sql);
  
  }
  
  $title = "My Profile";
  $class3 = "active";
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
    <link href="dist/css/rating.css" rel="stylesheet">

  </head>

<body>
  <?php include_once("header.php"); ?>

    <div class="container">

      <h1 class="page-header">Profile</h1>
           <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-8">
          <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="profile.php">Me</a></li>
        <li role="presentation"><a href="activitylog.php">Activity Log</a></li>        
        <li role="presentation"><a href="friendlist.php">Friend List</a></li>
        <li role="presentation" class="active"><a href="review.php">Reviews</a></li>
        </ul>
        </div>
        </div>

        <br>

        <div class="row">
          <div class="col-md-4">
          <div class="row placeholders">
            <div class="placeholder" align="center">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h2><?php 

                if(isset($_SESSION['doctorid'])){
                  $avgrating = mysqli_query($con, "SELECT AVG(rating) as rating FROM review WHERE doctorid='$_SESSION[doctorid]'");
                  $avgrating = mysqli_fetch_assoc($avgrating);
                  echo substr($avgrating['rating'], 0, 3).' <i class="fa fa-lg fa-stethoscope"></i>'; 
                }
                ?></h2>
              <h4> <?php echo $_SESSION["fullname"];?></h4>
              <span class="text-muted"><?php echo $_SESSION["email"];?></span>
            </div>
          </div>
            </div>
      
    
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-body">
            <input type="hidden" id="doctorid" value="<?php echo $_SESSION['doctorid']; ?>">
            <div class="reviewcontainer">

              </div>
          </div>
        </div>
        </div>
</div>
<?php 
  include_once("_footer.php");
?>
    <script type="text/javascript" src="dist/js/rating.js"></script> 
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