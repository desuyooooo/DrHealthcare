<?php
    session_start();

    include_once("_database.php");

    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    

$title = "Search";
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

    //SO MANY VARIABLES

    $ktitle = $_GET['ktitle'];
    $ktag = $_GET['ktag'];
    $kcontent = $_GET['kcontent'];
    $kdoctor = $_GET['kdoctor'];
    $kpatient = $_GET['kpatient'];
    $stitle = mysqli_real_escape_string($con, trim($_GET['ktitle']));
    $stag = mysqli_real_escape_string($con, trim($_GET['ktag']));
    $scontent = mysqli_real_escape_string($con, trim($_GET['kcontent']));
    $sdoctor = mysqli_real_escape_string($con, trim($_GET['kdoctor']));
    $spatient = mysqli_real_escape_string($con, trim($_GET['kpatient']));

    $sstatus = $_GET['kstatus'];

    //tokenizer
    $ttitle = explode(" ",$stitle);
    $ttag = explode(" ",$stag);
    $tcontent = explode(" ",$scontent);
    $tdoctor = explode(" ",$sdoctor);
    $tpatient = explode(" ",$spatient);

    //QUERY STARTER

    $posttitle_con = "SELECT * FROM `post` WHERE `posttitle` LIKE '%$stitle%'";
    $posttag_con = "SELECT * FROM `post` WHERE `tag` LIKE '%$stag%'";
    $postcontent_con = "SELECT * FROM `post` WHERE `postcontent` LIKE '%$scontent%'";

    $doctor_con = "SELECT `doctorid`, `firstname`, `lastname`, CONCAT(`firstname`,' ',`lastname`) as 'fullname' FROM `doctor` WHERE `firstname` LIKE '%$sdoctor%' OR `lastname` LIKE '%$sdoctor%' OR CONCAT(`firstname`,' ',`lastname`) LIKE '%$sdoctor%'";

    $patient_con = "SELECT `patientid`, `firstname`, `lastname`, CONCAT(`firstname`,' ',`lastname`) as 'fullname' FROM `patient` WHERE `firstname` LIKE '%$spatient%' OR `lastname` LIKE '%$spatient%' OR CONCAT(`firstname`,' ',`lastname`) LIKE '%$spatient%'";
  ?>

    <div class="container">

      <h1 class="page-header">Advanced Search</h1>
        <div class="panel panel-default">
        <div class="panel-body">
        <div class="row">
          <div class="col-md-6">
                  <form class="form-group" action="_advancesearch.php" method="post">
                  <input type="text" placeholder="Post Title" name="stitle" class="form-control" style="margin-bottom:5px;">
                  <input type="text" placeholder="Post Tag/s" name="stags" class="form-control" style="margin-bottom:5px;">
                  <input type="text" placeholder="Post Content" name="scontent" class="form-control" style="margin-bottom:5px;">
                  <input type="text" placeholder="Commented Doctor Name" name="sdoctor" class="form-control" style="margin-bottom:5px;">
                  <input type="text" placeholder="Post Owner/Patient Name" name="spatient" class="form-control" style="margin-bottom:5px;">
                  <label class="heading"> Filter: </label>
                  <label class="custom-control custom-radio">
                  <input class="custom-control-input" type="radio" name="Status" value="" checked> 
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">ALL Posts</span>
                  </label>
                  <label class="custom-control custom-radio">
                  <input class="custom-control-input" type="radio" name="Status" value="AND p.solved LIKE '%Y%'"> Answered Posts Only
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description"></span>
                  </label>
                  <label class="custom-control custom-radio">
                  <input class="custom-control-input" type="radio" name="Status" value="AND p.solved LIKE '%N%'"> 
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Unanswered Posts Only</span>
                  </label>
                  <button type="submit" class="btn btn-default" style="margin-right:15px; margin-bottom:5px;">Advance Search</button>
        </form>
          </div>
          </div>
          <?php

          if ($sdoctor == ""){
           $sql = "SELECT * FROM category c, doctor dr, patient pt, post p WHERE CONCAT(dr.firstname,' ',dr.lastname) LIKE '%$sdoctor%' AND CONCAT(pt.firstname,' ',pt.lastname) LIKE '%$spatient%' AND p.posttitle LIKE '%$stitle%' AND p.tag LIKE '%$stag%' AND p.postcontent LIKE '%$scontent%' and p.catid = c.catid and p.patientid = pt.patientid and p.approved = 'Y' $sstatus GROUP BY p.postid ORDER BY p.postid desc";
          }
          else if ($sdoctor != ""){
            $sql = "SELECT * FROM category c, doctor dr, patient pt, post p, comment cm WHERE CONCAT(dr.firstname,' ',dr.lastname) LIKE '%$sdoctor%' AND CONCAT(pt.firstname,' ',pt.lastname) LIKE '%$spatient%' AND p.posttitle LIKE '%$stitle%' AND p.tag LIKE '%$stag%' AND p.postcontent LIKE '%$scontent%' and p.catid = c.catid and p.patientid = pt.patientid and p.approved = 'Y' AND (dr.doctorid = cm.doctorid AND p.postid = cm.postid) '$sstatus' GROUP BY p.postid ORDER BY p.postid desc";
          }

            $postresult = mysqli_query($con, $sql);

            $count = mysqli_num_rows($postresult);

            if($count==0){
              echo '<label>No posts available. Back to <a href="index.php">index</a>.</label>';
            }
            else if ($sdoctor == "" && $spatient == "" && $stitle == "" && $stag == "" && $scontent == ""){
              echo '<label>(Input on fields above to show filtered results)</label>';
            }
            else{
              while ($row = mysqli_fetch_array($postresult)) {

              $tags = $row['tag'];
              $arrTags = explode(",", $tags);

              echo '<h4><strong><a href="viewpost.php?id='.$row['postid'].'">'.$row['posttitle'].'</a></strong></h4>';
              echo '<div class="row"><div class="col-md-8">';
              
              echo '<p>'.substr($row['postcontent'], 0, 60).'...</p>';
              echo '<strong><a href="searchcat.php?id='.$row['catid'].'">'.$row['catname'].'</a></strong> | Tags: ';
              foreach($arrTags as $count)
              {
                echo '<a href="searchtag.php?keyword='.$count.'">'.$count.'</a> | ';
              }
              echo '<br>';
              echo '</div><div class="col-md-4">';
              echo 'Asked by '.$row['firstname'].' '.$row['lastname'].'<br>';
              echo $row['timeposted'];
              echo '</div></div><hr>';
              }
            }

        ?>

        </div></div>

        
        
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