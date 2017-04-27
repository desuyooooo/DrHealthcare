<?php 
  session_start();

  $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
  
  if(!isset($_SESSION["type"])){
      header("location: index.php");
  }

  include("_database.php");
  
  $class3 = "active";
  $title = "Friend List";
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
        <li role="presentation" class="active"><a href="friendlist.php">Friends</a></li>
        <?php if($_SESSION["type"]=='doctor') echo '<li role="presentation"><a href="review.php">Reviews</a></li>'; ?>
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
              <div class="panel-heading"><h3 class="panel-title">Friend List</h3></div>
              <div class="panel-body">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th><?php if($_SESSION['type']=='patient') echo 'Specialization'; ?></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if($_SESSION['type']=='patient'){
                        $sql = "SELECT * FROM friend f, doctor d, doctorbackground db WHERE f.patientid='$_SESSION[patientid]' and f.doctorid = d.doctorid and d.doctorid = db.doctorid and f.status = 'A' ORDER BY firstname asc";
                        $acceptedfriends = mysqli_query($con, $sql);

                        if($acceptedfriends){
                          $count = mysqli_num_rows($acceptedfriends);
                          if($count>0){
                            while($row = mysqli_fetch_assoc($acceptedfriends)){
                            ?>
                              <tr>
                                <td><?php echo '<a href=viewprofile.php?did='.$row['doctorid'].'>'.$row['firstname'].' '.$row['lastname'].'</a>'; ?></td>
                                <td><?php echo $row['specialty']; ?></td>
                                <td></td>
                                <td></td>
                                <td><a href="" class="btn btn-default">MESSAGE</a></td>
                              </tr>
                              <?php
                          }

                          }else{
                              echo '<tr><td>You have no friends yet.</td></tr>';
                          }
                          
                        }else{
                          echo '<tr><td>You have no friends yet.</td></tr>';
                        }

                        
                      }else if($_SESSION['type']=='doctor'){
                        $sql = "SELECT * FROM friend f, patient p WHERE f.doctorid='$_SESSION[doctorid]' and f.patientid = p.patientid and f.status = 'A' ORDER BY firstname asc";
                        $acceptedfriends = mysqli_query($con, $sql);
                        
                        if($acceptedfriends){
                          $count = mysqli_num_rows($acceptedfriends);
                          if($count>0){
                          while($row = mysqli_fetch_assoc($acceptedfriends)){
                            ?>
                              <tr>
                                <td><?php echo '<a href="viewprofile.php?pid='.$row['patientid'].'">'.$row['firstname'].' '.$row['lastname'].'</a>'; ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><a href="" class="btn btn-default">MESSAGE</a></td>
                              </tr>
                            <?php
                        }
                        }else{
                              echo '<tr><td>You have no friends yet.</td></tr>';
                          }
                          
                        }else{
                          echo '<tr><td>You have no friends yet.</td></tr>';
                        }
                      }
                    ?>
                  </tbody>
                </table>
             </div>
            </div>
                      <div class="panel panel-default">
              <div class="panel-heading"><h3 class="panel-title">Pending Friend Requests</h3></div>
              <div class="panel-body">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th><?php if($_SESSION['type']=='patient') echo 'Specialization'; ?></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if($_SESSION['type']=='patient'){
                        $sql = "SELECT * FROM friend f, doctor d, doctorbackground db WHERE f.patientid='$_SESSION[patientid]' and f.doctorid = d.doctorid and d.doctorid = db.doctorid and f.reqfrom='D' and (f.status = 'R' or f.status='N')";
                        $pendingfr = mysqli_query($con, $sql);
                        
                        if($pendingfr){
                        while($row = mysqli_fetch_assoc($pendingfr)){
                            ?>
                              <tr>
                                <td><?php echo '<a href=viewprofile.php?did='.$row['doctorid'].'>'.$row['firstname'].' '.$row['lastname'].'</a>'; ?></td>
                                <td><?php echo $row['specialty']; ?></td>
                                <td></td>
                                <td></td>
                                <td><a href="_friendaccept.php?id=<?php echo $row['friendid']?>" class="btn btn-default">ACCEPT</a></td>
                              </tr>
                            <?php

                        }
                      }

                        
                      }else if($_SESSION['type']=='doctor'){
                        $sql = "SELECT * FROM friend f, patient p WHERE f.doctorid='$_SESSION[doctorid]' and f.patientid = p.patientid and f.reqfrom='P' and (f.status = 'R' or f.status='N')";
                        $pendingfr = mysqli_query($con, $sql);
                        
                        if($pendingfr){
                        while($row = mysqli_fetch_assoc($pendingfr)){
                            ?>
                              <tr>
                                <td><?php echo '<a href="viewprofile.php?pid='.$row['patientid'].'">'.$row['firstname'].' '.$row['lastname'].'</a>'; ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><a href="_friendaccept.php?id=<?php echo $row['friendid']?>" class="btn btn-default">ACCEPT</a></td>
                              </tr>
                            <?php
                        }
                      }
                      }
                    ?>
                  </tbody>
                </table>
             </div>
            </div>
          </div>
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