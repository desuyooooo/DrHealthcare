<?php 
  session_start();

  $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
  
  include("_database.php");

  if(isset($_GET['pid'])){
  	if(isset($_SESSION['type'])){
  		if($_SESSION['type']=='patient'){
    		if($_GET['pid']==$_SESSION['patientid']){
        		header("location: profile.php");   
    		}
    	}
    }
    $sql = "SELECT * FROM patient p, patientpersonal pp, patientmedical pm WHERE p.patientid='$_GET[pid]' and p.patientid=pp.patientid and p.patientid=pm.patientid";
  }else if(isset($_GET['did'])){
  	if(isset($_SESSION['type'])){
  		if($_SESSION['type']=='doctor'){
    		if($_GET['did']==$_SESSION['doctorid']){
        		header("location: profile.php");   
    		}
    	}
    }
   	$sql = "SELECT * FROM doctor d, doctorbackground db WHERE d.doctorid='$_GET[did]' and d.doctorid=db.doctorid";
  }

  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);

  $title = "View Profile";
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
  </head>

  <body>

    <?php
    if(!isset($_SESSION["type"])){
     include_once("header-guest.php"); 
    }else{
      if($_SESSION["type"]=='patient'||$_SESSION["type"]=='doctor') include_once("header.php");
      else if($_SESSION["type"]=='admin') include_once("header-admin.php");
    }

    ?>
    <div class="container">

      <h1 class="page-header"></h1>
           <div class="row">
            <div class="col-md-4">
            </div>
            
        </div>
        <br>
        <div class="row">
          <div class="col-md-4">
          <div class="row placeholders">
            <div class="placeholder" align="center">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
               <h2><?php 

               	if(isset($_GET['did'])){
               		$avgrating = mysqli_query($con, "SELECT AVG(rating) as rating FROM review WHERE doctorid='$_GET[did]'");
  					$avgrating = mysqli_fetch_assoc($avgrating);
             	  	echo substr($avgrating['rating'], 0, 3).' <i class="fa fa-lg fa-stethoscope"></i>'; 
                }
               	?></h2>
              <h4> <?php echo $row["firstname"].' '.$row["lastname"];?></h4>
              <p class="text-muted"><?php echo $row["email"];?></p>
            <?php
        
            if(isset($_SESSION["type"])){
              if(($_SESSION["type"]=='doctor')&&(isset($_GET['pid']))){
                $checkreq = "SELECT * FROM friend WHERE patientid='$_GET[pid]' and doctorid='$_SESSION[doctorid]'";
                $userid = 'pid='.$_GET['pid'];
                $result = mysqli_query($con,$checkreq);

                $count = mysqli_num_rows($result);
                if($count > 0){
                  $a = mysqli_fetch_assoc($result);
                  if($a['status']=='R' && $a['reqfrom']=='D'){
                    echo '<a href="" class="btn btn-default" style="max-width: 250px; ">PENDING REQUEST</a>';  
                  }else if($a['status']=='R' && $a['reqfrom']=='P'){
                    echo '<a href="_friendaccept.php?id='.$a['friendid'].'" class="btn btn-default" style="max-width: 250px; ">ACCEPT REQUEST</a>';  
                  }else if($a['status']=='A'){
                    echo '<a href="messages.php?id='.$a['friendid'].'#end" class="btn btn-default" style="max-width: 250px; ">MESSAGE</a>';
                  }
                }else{
                  echo '<a href="_addfriend.php?'.$userid.'" class="btn btn-default" style="max-width: 250px;">Add Friend</a>';
                }
                }else if(($_SESSION["type"]=='patient')&&(isset($_GET['did']))){
                $checkreq = "SELECT * FROM friend WHERE patientid='$_SESSION[patientid]' and doctorid='$_GET[did]'";    
                $userid = 'did='.$_GET['did'];             
                $result = mysqli_query($con,$checkreq);   

                $count = mysqli_num_rows($result);
                if($count > 0){
                  $a = mysqli_fetch_assoc($result);
                  if($a['status']=='R' && $a['reqfrom']=='P'){
                    echo '<a href="" class="btn btn-default" style="max-width: 250px; ">PENDING REQUEST</a>';  
                  }else if($a['status']=='R' && $a['reqfrom']=='D'){
                    echo '<a href="_friendaccept.php?id='.$a['friendid'].'" class="btn btn-default" style="max-width: 250px; ">ACCEPT REQUEST</a>';  
                  }else if($a['status']=='A'){
                    echo '<a href="messages.php?id='.$a['friendid'].'#end" class="btn btn-default" style="max-width: 250px; ">MESSAGE</a>';
                  }
                }else{
                  echo '<a href="_addfriend.php?'.$userid.'" class="btn btn-default" style="max-width: 250px;">Add Friend</a>';
                }          
              }
            }      
            ?>
            </div>

          </div>
            </div>
            <?php 
              if(isset($_GET['pid'])){
            ?>
              <div class="col-md-8">
                 <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><?php echo '<a href="viewprofile.php?pid='.$_GET['pid'].'">'.$row["firstname"].'</a>';?></li>
                    <li role="presentation"><?php echo '<a href="viewactivitylog.php?pid='.$_GET['pid'].'">';?>Activity Log</a></li>
                </ul>
                <br>
            <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Personal Record</h3>
            </div>
            <div class="panel-body">
            <ul class="list-unstyled">
              <li>Name: <?php echo $row['firstname'] . ' ' . $row['midname'] . ' ' . $row['lastname']; ?></li>
              <li>Sex: <?php echo $row['sex'];?></li>
              <li>Birthdate: <?php echo $row['bdate'];?></li>
            </ul>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Medical Record</h3>
            </div>
            <div class="panel-body">
            <ul class="list-unstyled">
              <li>Height: <?php echo $row['height'];?>cm</li>
              <li>Weight: <?php echo $row['weight'];?>kg</li>
              <li>Blood Type: <?php echo $row['bloodtype'];?></li>
              <li>Blood Pressure: <?php echo $row['bloodpressure'];?></li>
              <li>Known Allergies: <?php echo $row['allergies'];?></li>
              <li>Medical History: <?php echo $row['medicalhist'];?></li>
               </ul>
            </div>
          </div>
        </div>
        </div>
            <?php
              }elseif(isset($_GET['did'])){
            ?>

            <div class="col-md-8">
              <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><?php echo '<a href="viewprofile.php?did='.$_GET['did'].'">'.$row["firstname"].'</a>';?></li>
                    <li role="presentation"><?php echo '<a href="viewactivitylog.php?did='.$_GET['did'].'">';?>Activity Log</a></li>
                    <li role="presentation"><?php echo '<a href="viewreview.php?did='.$_GET['did'].'">';?>Reviews</a></li>
                </ul>
              <br>
            <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Personal Information</h3>
            </div>
            <div class="panel-body">
            <ul class="list-unstyled">
              <li>Name: <?php echo $row['firstname'] . ' ' . $row['midname'] . ' ' . $row['lastname']; ?></li>
              <li>Sex: <?php echo $row['sex'];?></li>
              <li>E-mail: <?php echo $row['email']; ?></li>
              </ul>
            </div>
          </div>
      
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Background</h3>
            </div>
            <div class="panel-body">
            <ul class="list-unstyled">
              <li>Specialty: <?php echo $row['specialty'];?></li>
              <li>Hospital Name: <?php echo $row['hospitalname'];?></li>
              <li>Office Address: <?php echo $row['officeaddress'];?></li>
              <li>Office Hours: <?php echo $row['officehours'];?></li>
              <li>Office Contact No.: <?php echo $row['officecontact'];?></li>
               </ul>
            </div>
          </div>
          </div>
        </div>

            <?php 
              }
            ?>
            
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