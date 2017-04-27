<?php
    session_start();
    include_once("_database.php");
    if(isset($_SESSION["type"])){
   if($_SESSION["type"]=="patient"){
        header("location: patient-viewpost.php?id=".$_GET['id']);
    }else if($_SESSION["type"]=="doctor"){
        header("location: doctor-viewpost.php?id=".$_GET['id']);
    }}

$class1 = "Active";
$title = "Index";
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
include_once("header-admin.php");
?>

    <div class="container">

      <h1 class="page-header">Forum</h1>

        <div class="row">
        <dib class="col-md-9">
        <div class="panel panel-default"><div class="panel-body">

        <?php 

            if(isset($_GET['id'])){
        //hanapin yung postid
              $sql = "SELECT * FROM post p, category c, patient pt WHERE p.postid='$_GET[id]' and p.catid = c.catid and p.patientid = pt.patientid";
              $postresult = mysqli_query($con, $sql);

              $count = mysqli_num_rows($postresult);

              if($count>0){
              echo '<h6><a href="admin-index.php">&laquo; Back to questions</a></h6>';
                while ($row = mysqli_fetch_array($postresult)) {
                  echo '<h2><a href="admin-viewpost.php?id='.$row['postid'].'">'.$row['posttitle'].'</a></h2>';
                  echo $row['postcontent'].'';
                  echo '<div class="row"><div class="col-md-8">';
                  echo '<br><strong><a href="admin-index.php?id='.$row['catid'].'&approved=Y">'.$row['catname'].'</a></strong> | ';
                  echo $row['tag'].'<br>';
                  echo '</div><div class="col-md-4"><div class="alert alert-warning">';
                  echo 'Asked by '.$row['firstname'].' '.$row['lastname'].'<br>';
                  echo $row['timeposted'];
                  echo '</div></div></div>';


              if($row['approved']!='Y'){
                  echo '<div class="row"><div class="col-xs-6 col-md-6">';
                  echo '<a href="admin-modifypost.php?id='.$_GET['id'].'"><button class="btn btn-default" >MODIFY POST</button></a><br>';
                  echo '</div><div class="col-xs-6 col-md-6">';
                  echo '<a href="_approvepost.php?id='.$_GET['id'].'"><button class="btn btn-default" >APPROVE POST</button></a><br><br>';
                  echo '</div></div>';
                
                  echo '<form action="_admindecline.php" method="post">
                                    <input type="hidden" name="postid" value="'.$row['postid'].'">';
                  echo '<textarea placeholder="Note" name="messagecontent" class="form-control"></textarea>';
                  echo '<button class="btn btn-default">DECLINE POST</button>';
                  echo '</form>';
            
              }else{




    $sql = "SELECT * FROM comment c WHERE c.postid='$_GET[id]' ORDER BY commentid asc";
        $commentresult = mysqli_query($con, $sql);
        $count = mysqli_num_rows($commentresult);
        $ba = mysqli_num_rows(mysqli_query($con, "SELECT * FROM comment WHERE postid='$_GET[id]' and answer='Y'"));

        if($count>0){

          echo '<div class="row"><div class="col-md-1"></div><div class="col-md-11">';

      while ($row = mysqli_fetch_array($commentresult)) {
        
        if($row['patientdoctor']=='P'){
          $patient = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM patient WHERE patientid='$row[patientid]'"));

          echo $row['commentcontent'].'<br><br>';
                  echo '<div class="row"><div class="col-xs-5 col-md-7"></div>';
                  echo '<div class="col-xs-7 col-md-5"><div class="alert alert-warning">';
                echo 'Comment by <a href="viewprofile.php?pid='.$patient['patientid'].'">'.$patient['firstname'].' '.$patient['lastname'].'</a><br>';
                  echo $row['timeposted'];
                  echo '</div></div></div><hr>';
        }else{
          $doctor = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM doctor WHERE doctorid='$row[doctorid]'"));
                  echo '<div class="alert alert-success">';
                  if ($row['answer']=='Y') echo '<i class="fa fa-lg fa-star"></i>&emsp;';
                  echo $row['commentcontent'].'<br><br>';
                  echo '<div class="row"><div class="col-xs-5 col-md-7">';
                  echo '</div>';
                  echo '<div class="col-xs-7 col-md-5"><div class="alert alert-warning">';
                echo 'Comment by Dr. <a href="viewprofile.php?did='.$doctor['doctorid'].'">'.$doctor['firstname'].' '.$doctor['lastname'].'</a><br>';
                  echo $row['timeposted'];
                  echo '</div></div></div>';
                  echo '</div><hr>';
        }
              
      }

      echo '</div></div>';
    }
  }
    



              
            }


        }else{
            echo '<h2>This topic doesn\'t exist.</h2><br>';
            echo 'Back to <a href="index.php">index</a>.';
        }
    }else{
    echo '<h2>The ID of this topic is not defined.</h2>';
    echo 'Back to <a href="index.php">index</a>.';

    }

        ?>
          
        </div>
        </div>
        </div>
<?php
include_once("footer.php");
?>
