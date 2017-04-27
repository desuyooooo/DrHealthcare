<?php 
  session_start();
  if(!isset($_SESSION["type"]))
    header("location: 01Homepage.php");
  else if($_SESSION["type"]=='patient')
    header("location: 04PatientProfile.php");


  include("_database.php");

  if(isset($_GET['table'])){
    $table = $_GET['table'];
    switch ($table) {
      case 'patient':
        $header = 'Patient Personal Information';
        break;
      case 'patientmedical':
        $header = 'Patient Medical Information';
        break;
      case 'doctor':
        $header = 'Doctor Background Information';
        break;
    }
  }else if(isset($_GET['overview'])){
    $header = 'Overview';
  }else if(isset($_GET['forum'])){
    $header = 'Forum';
  }else if(isset($_GET['review'])){
    $header = 'Review';
  }

  $time = '';
  $t = "BETWEEN '1000-01-01' AND '9999-12-31'";

  if(isset($_GET['overall'])){
    $time = '';
  }else if(isset($_GET['today'])){
    $t = '= CURDATE()';
  }else if(isset($_GET['weekly'])){
    $t = 'BETWEEN DATE_SUB( CURDATE( ) , INTERVAL (dayofweek(CURDATE())-1) DAY ) AND CURDATE( )';
  }else if(isset($_GET['monthly'])){
    $t = 'BETWEEN DATE_SUB( CURDATE( ) , INTERVAL (30-dayofweek(CURDATE())) DAY ) AND CURDATE( )';
    if(isset($_GET['week'])){

      $day = $_GET['week'] * 7;
      $t = "BETWEEN CONCAT(DATE_FORMAT(CURDATE(),'%Y-%m'),'-',". ($day-6) .") AND CONCAT( DATE_FORMAT(CURDATE(),'%Y-%m'),'-',".$day.")";
    }
  }else if(isset($_GET['yearly'])){
    $t = "BETWEEN CONCAT(YEAR(CURDATE()),'-01-01') AND CONCAT(YEAR(CURDATE()),'-12-31')";
    if(isset($_GET['year'])&&!isset($_GET['month'])){
      $t = "BETWEEN CONCAT(".$_GET['year'].",'-01-01') AND CONCAT(".$_GET['year'].",'-12-31')";
    }else if(isset($_GET['year'])&&isset($_GET['month'])){
      $t = "BETWEEN CONCAT(" .$_GET['year']. " , '-' , " . $_GET['month'] . " , '-01') AND CONCAT(" .$_GET['year']. " , '-' , " . $_GET['month'] . " , '-31')";
    }
  }else if(isset($_GET['custom'])){
    $t = "BETWEEN CONCAT(YEAR(CURDATE()),'-01-01') AND CONCAT(YEAR(CURDATE()),'-12-31')";
    if(isset($_GET['since'])&&isset($_GET['until'])){
        $since = $_GET['since'];
        $until = $_GET['until'];
        if(($since!='')&&($until!='')){
          $t = "BETWEEN '".$since."' AND '".$until."'";
        }else if(($since=='')&&($until!='')){
          $t = "BETWEEN '1000-01-01' AND '".$until."'";
        }else if(($since!='')&&($until=='')){
          $t = "BETWEEN '".$since."' AND '9999-12-31'";
        }
    }
  }

$catarray = array();
$tagarray = array();
$postarray = array();
$drmostreviewedarr = array();
$drrankingarr = array();


  $title = 'Reports';
  $class2 = "active";
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
  <div class="container-fluid">

      <!--
      <h1 class="page-header">Patients</h1>
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="<?php echo $table1?>"><a href="?table=patient">Patients' Personal Information</a></li>
          <li role="presentation" class="<?php echo $table2?>"><a href="?table=patientmedical">Patients' Medical Information</a></li>
          <li role="presentation" class="<?php echo $table3?>"><a href="?table=doctor">Doctors' Personal Information</a></li>
        </ul>
      -->
    <div class="row">
      <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="?overview">Overview<span class="sr-only">(current)</span></a></li>
            <li><a href="?forum&overall=active">Forum Transactions</a></li>
            <li><a href="?review&overall=active">Review Transactions</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="?table=patient">Patients' Personal Information</a></li>
            <li><a href="?table=patientmedical">Patients' Medical Information</a></li>
            <li><a href="?table=doctor">Doctors' Personal Information</a></li>
          </ul>
          <!--
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul>
          -->
        </div>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h2 class="sub-header"><?php echo $header; ?></h2>
<?php
  //
  //  date(p.timeposted)=CURDATE() FILTER FOR CURRENT DATE
  //

  if(isset($_GET['overview'])){
    ?>
    <div class="row">

      <div class="col-sm-6 col-md-4">
        <div class="panel panel-default"> 
          <div class="panel-heading"><h3 class="panel-title">Most Used Category</h3></div>
          <div class="panel-body">
            <?php 
              $sql = mysqli_query($con, "SELECT COUNT(p.catid) as count, c.catname, p.catid FROM post p, category c WHERE p.catid = c.catid GROUP BY p.catid ORDER BY count DESC LIMIT 5");
              $sum = mysqli_query($con, "SELECT COUNT(p.postid) as sum from post p");
              $postsum = mysqli_fetch_assoc($sum);
              $i = 1;
              while($category = mysqli_fetch_assoc($sql)){
                $catid = $category['catid'];
                $catcount = $category['count'];
                $catname = $category['catname'];
                $percent = round($catcount / $postsum['sum'] *100);
                echo '<h'.$i.'>#'.$i.' <a href="admin-index.php?id='.$catid.'&approved=Y" target="admin-viewcat.php?id='.$catid.'&approved=Y">'.$catname.'</a> ('.$percent.'%)</h'.$i.'>';
                $i++;
              }
            ?>
            <a href="?forum&overall=active">View more details</a>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title">Most Used Tags</h3></div>
          <div class="panel-body">
           <?php
                $sql = mysqli_query($con, "SELECT * FROM tags ORDER BY tagcount DESC LIMIT 5");
              $sum = mysqli_query($con, "SELECT SUM(tagcount) as sum FROM tags");
              $tagsum = mysqli_fetch_assoc($sum);
              $i = 1;
              while($tags = mysqli_fetch_assoc($sql)){
                $tagname = $tags['tag'];
                $tagcount = $tags['tagcount'];
                $percent = round(($tagcount / $tagsum['sum']) * 100);
                echo '<h'.$i.'>#'.$i.' <a href="admin-index.php?tag='.trim($tagname).'&approved=Y" target="admin-index.php?tag='.trim($tagname).'&approved=Y">'.$tagname.'</a> ('.$percent.'% )</h'.$i.'>';
                $i++;
              } 
            ?>
            <a href="?forum&overall=active">View more details</a>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title">Most Commented Posts</h3></div>
          <div class="panel-body">
            <?php 
              $sql = mysqli_query($con, "SELECT COUNT(c.commentid) as count, p.posttitle, p.postid FROM post p, comment c WHERE p.postid = c.postid  GROUP BY p.postid ORDER BY count DESC LIMIT 5");
              $i = 1;
              while($comments = mysqli_fetch_assoc($sql)){
                echo '<h3>#'.$i.' <a href="admin-viewpost.php?id='.$comments['postid'].'" target="admin-viewpost.php?id='.$comments['postid'].'">'.$comments['posttitle'].'</a> ('.$comments['count'].' comment/s)</h3>';
                $i++;
              }
            ?>
            <a href="?forum&overall=active">View more details</a>
          </div>
        </div>
      </div>

    </div>

    <div class="row">

      <div class="col-sm-6 col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title">Most Reviewed Doctor</h3></div>
          <div class="panel-body">
            <?php 
              $sql = mysqli_query($con, "SELECT COUNT(r.reviewid) as count, CONCAT(d.firstname, ' ', d.midname, ' ', d.lastname) as fullname, d.doctorid FROM review r, doctor d WHERE r.doctorid = d.doctorid GROUP BY d.doctorid ORDER BY count DESC LIMIT 5");
              $i = 1;
              while($reviews = mysqli_fetch_assoc($sql)){
  
                echo '<h'.$i.'>#'.$i.' <a href="viewprofile.php?did='.$reviews['doctorid'].'" target="viewprofile.php?did='.$reviews['doctorid'].'">'.$reviews['fullname'].'</a> ('.$reviews['count'].' users)</h'.$i.'>';
                $i++;
              }
            ?>
            <a href="?review&overall=active">View more details</a>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title">Top Ranked Doctors</h3></div>
          <div class="panel-body">
            <?php 
              $sql = mysqli_query($con, "SELECT AVG(r.rating) as avg, CONCAT(d.firstname, ' ', d.midname, ' ', d.lastname) as fullname, d.doctorid FROM review r, doctor d WHERE r.doctorid = d.doctorid GROUP BY d.doctorid ORDER BY avg DESC LIMIT 5");
              $i = 1;
              while($rank = mysqli_fetch_assoc($sql)){
                echo '<h'.$i.'>#'.$i.' <a href="viewprofile.php?did='.$rank['doctorid'].'" target="viewprofile.php?did='.$rank['doctorid'].'">'.$rank['fullname'].'</a> ('.substr($rank['avg'], 0, 4).' <i class="fa fa-stethoscope"></i>)</h'.$i.'>';
                $i++;
              }
            ?>
            <a href="?review&overall=active">View more details</a>
          </div>
        </div>
      </div>

    </div>

    <?php

    }else if(isset($_GET['forum'])){
    
    //
    // FORUM
    //
    ?>

    <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="<?php echo $_GET[overall]?>"><a href="?forum&overall=active">Overall</a></li>
          <li role="presentation" class="<?php echo $_GET[today]?>"><a href="?forum&today=active">Today</a></li>
          <li role="presentation" class="<?php echo $_GET[weekly]?>"><a href="?forum&weekly=active">This Week</a></li>
          <li role="presentation" class="<?php echo $_GET[monthly]?>"><a href="?forum&monthly=active">Monthly</a></li>
          <li role="presentation" class="<?php echo $_GET[yearly]?>"><a href="?forum&yearly=active">Yearly</a></li>
          <li role="presentation" class="<?php echo $_GET[custom]?>"><a href="?forum&custom=active">Custom Range</a></li>
    </ul>

    <?php
      if(isset($_GET['monthly'])){
        echo '<br>
          <a href="?forum&monthly=active&week=1">Week 1</a>&emsp;
          <a href="?forum&monthly=active&week=2">Week 2</a>&emsp;
          <a href="?forum&monthly=active&week=3">Week 3</a>&emsp;
          <a href="?forum&monthly=active&week=4">Week 4</a>&emsp;
          <br>';
      }else if(isset($_GET['yearly'])){
        if(!isset($_GET['year'])){
        echo '
          <br>
          <a href="?forum&yearly=active&year=2015">2015</a>&emsp;
          <a href="?forum&yearly=active&year=2016">2016</a>&emsp;
          <a href="?forum&yearly=active&year=2017">2017</a>&emsp;
          <br>
          ';
        }else{

          echo '
          <br>
          <a href="?forum&yearly=active&year=2015">2015</a>&emsp;
          <a href="?forum&yearly=active&year=2016">2016</a>&emsp;
          <a href="?forum&yearly=active&year=2017">2017</a>&emsp;
          <br>
          <br>
          <a href="?forum&yearly=active&year='.$_GET['year'].'&month=01">January</a>&emsp;
          <a href="?forum&yearly=active&year='.$_GET['year'].'&month=02">February</a>&emsp;
          <a href="?forum&yearly=active&year='.$_GET['year'].'&month=03">March</a>&emsp;
          <a href="?forum&yearly=active&year='.$_GET['year'].'&month=04">April</a>&emsp;
          <a href="?forum&yearly=active&year='.$_GET['year'].'&month=05">May</a>&emsp;
          <a href="?forum&yearly=active&year='.$_GET['year'].'&month=06">June</a>&emsp;
          <a href="?forum&yearly=active&year='.$_GET['year'].'&month=07">July</a>&emsp;
          <a href="?forum&yearly=active&year='.$_GET['year'].'&month=08">August</a>&emsp;
          <a href="?forum&yearly=active&year='.$_GET['year'].'&month=09">September</a>&emsp;
          <a href="?forum&yearly=active&year='.$_GET['year'].'&month=10">October</a>&emsp;
          <a href="?forum&yearly=active&year='.$_GET['year'].'&month=11">November</a>&emsp;
          <a href="?forum&yearly=active&year='.$_GET['year'].'&month=12">December</a>&emsp;
          <br>';
        }
      }else if(isset($_GET['custom'])){
        echo '
        <form action="admin-reports.php" method="get">
        <div class="row"><br>
        <input type="hidden" name="forum">
        <input type="hidden" name="custom" value="active">
        <div class="col-md-2">From<input type="date" class="form-control" style="width:175px;" name="since"></div>
        <div class="col-md-2">To<input type="date" class="form-control" style="width:175px;" name="until"></div>
        <div class="col-md-2"><br><button class="btn btn-default">Generate</button></div>
        </div>
        </form>';
      }
    ?>

      <br>

        <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title">Most Used Category</h3></div>
          <div class="panel-body">
            <div class="row">
            <div class="col-md-6">
            <?php 
              $sql = mysqli_query($con, "SELECT COUNT(p.catid) as count, c.catname, p.catid FROM post p, category c WHERE p.catid = c.catid and date(p.timeposted) ".$t." GROUP BY p.catid ORDER BY count DESC LIMIT 10");
              $sum = mysqli_query($con, "SELECT COUNT(p.postid) as sum from post p where date(p.timeposted) ".$t);
              $postsum = mysqli_fetch_assoc($sum);
              $cat = array();
              $catarr = array();
              $i = 1;
              while($category = mysqli_fetch_assoc($sql)){
                $catid = $category['catid'];
                $catcount = $category['count'];
                $catname = $category['catname'];
                $percent = round($catcount / $postsum['sum'] *100);
                echo '<h3>#'.$i.' <a href="admin-index.php?id='.$catid.'&approved=Y" target="admin-viewcat.php?id='.$catid.'&approved=Y">'.$catname.'</a> ('.$percent.'% / '.$catcount.' times)</h3>';
                $cat = array($catname, $percent);
                $catarr[] = $cat;
                $i++;
              }
              $catarray[] = $catarr;
            ?>
            </div>
            <div class="col-md-6" >
            <div id="category"></div>
            </div>
          </div>
        </div>
      </div>
        <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title">Most Used Tags</h3></div>
          <div class="panel-body">
           <div class="row">
            <div class="col-md-6">
           <?php 
              $sql = mysqli_query($con, "SELECT COUNT(tags.tag) as tagcount, tags.tag FROM tags LEFT JOIN post on post.tag LIKE CONCAT('%',tags.tag,'%') WHERE date(post.timeposted) ".$t." GROUP BY tags.tag ORDER BY tagcount DESC LIMIT 9");
              $sum = mysqli_query($con, "SELECT COUNT(tags.tag) as sum FROM tags LEFT JOIN post on post.tag LIKE CONCAT('%',tags.tag,'%') WHERE date(post.timeposted) ".$t."  ");
              $tagsum = mysqli_fetch_assoc($sum);
              $tag = array();
              $tagarr = array();
              $i = 1;
              $countsum = 0;

              if(mysqli_num_rows($sql)>0){
                            while($tags = mysqli_fetch_assoc($sql)){
                              $tagname = $tags['tag'];
                              $tagcount = $tags['tagcount'];
                              $percent = round(($tagcount / $tagsum['sum']) * 100);
                              $countsum += $tagcount;
                              echo '<h3>#'.$i.' <a href="admin-index.php?tag='.trim($tagname).'&approved=Y" target="admin-index.php?tag='.trim($tagname).'&approved=Y">'.$tagname.'</a> ('.$percent.'% / '.$tagcount.' times)</h3>';
                              $tag = array($tagname, $percent);
                              $tagarr [] = $tag;
                              $i++;
                            }
                            $others = round((($tagsum['sum'] - $countsum)/$tagsum['sum'])*100);
                            $tagarr [] = array("Others", $others);
                            $tagarray[] = $tagarr;
                            echo '<h3>#10 other tags ('.$others.'% )</h3>';
            }
            ?>
            </div>
            <div class="col-md-6" >
            <div id="tag"></div>
          </div>
        </div>
      </div>
      </div>
        <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title">Most Commented Posts</h3></div>
          <div class="panel-body">
           <div class="row">
            <div class="col-md-6">
            <?php 
              $sql = mysqli_query($con, "SELECT COUNT(c.commentid) as count, p.posttitle, p.postid FROM post p, comment c WHERE p.postid = c.postid and date(c.timeposted) ".$t."  GROUP BY p.postid ORDER BY count DESC LIMIT 5");
              $i = 1;
              $comment = array();
              $commentarray = array();
              while($comments = mysqli_fetch_assoc($sql)){
                echo '<h3>#'.$i.' <a href="admin-viewpost.php?id='.$comments['postid'].'" target="admin-viewpost.php?id='.$comments['postid'].'">'.$comments['posttitle'].'</a> ('.$comments['count'].' comment/s)</h3>';
                $sql2 = mysqli_query($con, "SELECT count(commentid) as count, timeposted FROM comment WHERE postid = ".$comments['postid']." ORDER BY timeposted ASC");
                while($pc = mysqli_fetch_assoc($sql2)){
                  $comment = array($pc['timeposted'], $pc['count']);
                  $commentarray[] = $comment;
                }
                $i++;
                $postarray[] = $commentarray;
              }
            ?>
            </div>
            <div class="col-md-6">
              <div id="comment"></div>
            </div>
            </div>
          </div>
        </div>

    <?php
  }else if(isset($_GET['review'])){
    ?>

    <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="<?php echo $_GET[overall]?>"><a href="?review&overall=active">Overall</a></li>
          <li role="presentation" class="<?php echo $_GET[today]?>"><a href="?review&today=active">Today</a></li>
          <li role="presentation" class="<?php echo $_GET[weekly]?>"><a href="?review&weekly=active">This Week</a></li>
          <li role="presentation" class="<?php echo $_GET[monthly]?>"><a href="?review&monthly=active">Monthly</a></li>
          <li role="presentation" class="<?php echo $_GET[yearly]?>"><a href="?review&yearly=active">Yearly</a></li>
          <li role="presentation" class="<?php echo $_GET[custom]?>"><a href="?review&custom=active">Custom Range</a></li>
    </ul>

    <?php
      if(isset($_GET['monthly'])){
        echo '<br>
          <a href="?review&monthly=active&week=1">Week 1</a>&emsp;
          <a href="?review&monthly=active&week=2">Week 2</a>&emsp;
          <a href="?review&monthly=active&week=3">Week 3</a>&emsp;
          <a href="?review&monthly=active&week=4">Week 4</a>&emsp;
          <br>';
      }else if(isset($_GET['yearly'])){
        if(!isset($_GET['year'])){
        echo '
          <br>
          <a href="?review&yearly=active&year=2015">2015</a>&emsp;
          <a href="?review&yearly=active&year=2016">2016</a>&emsp;
          <a href="?review&yearly=active&year=2017">2017</a>&emsp;
          <br>
          ';
        }else{

          echo '
          <br>
          <a href="?review&yearly=active&year=2015">2015</a>&emsp;
          <a href="?review&yearly=active&year=2016">2016</a>&emsp;
          <a href="?review&yearly=active&year=2017">2017</a>&emsp;
          <br>
          <br>
          <a href="?review&yearly=active&year='.$_GET['year'].'&month=01">January</a>&emsp;
          <a href="?review&yearly=active&year='.$_GET['year'].'&month=02">February</a>&emsp;
          <a href="?review&yearly=active&year='.$_GET['year'].'&month=03">March</a>&emsp;
          <a href="?review&yearly=active&year='.$_GET['year'].'&month=04">April</a>&emsp;
          <a href="?review&yearly=active&year='.$_GET['year'].'&month=05">May</a>&emsp;
          <a href="?review&yearly=active&year='.$_GET['year'].'&month=06">June</a>&emsp;
          <a href="?review&yearly=active&year='.$_GET['year'].'&month=07">July</a>&emsp;
          <a href="?review&yearly=active&year='.$_GET['year'].'&month=08">August</a>&emsp;
          <a href="?review&yearly=active&year='.$_GET['year'].'&month=09">September</a>&emsp;
          <a href="?review&yearly=active&year='.$_GET['year'].'&month=10">October</a>&emsp;
          <a href="?review&yearly=active&year='.$_GET['year'].'&month=11">November</a>&emsp;
          <a href="?review&yearly=active&year='.$_GET['year'].'&month=12">December</a>&emsp;
          <br>';
        }
      }else if(isset($_GET['custom'])){
        echo '
        <form action="admin-reports.php" method="get">
        <div class="row"><br>
        <input type="hidden" name="review">
        <input type="hidden" name="custom" value="active">
        <div class="col-md-2">From<input type="date" class="form-control" style="width:175px;" name="since"></div>
        <div class="col-md-2">To<input type="date" class="form-control" style="width:175px;" name="until"></div>
        <div class="col-md-2"><br><button class="btn btn-default">Generate</button></div>
        </div>
        </form>';
      }
      ?>

      <br>

  
        <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title">Most Reviewed Doctor</h3></div>
          <div class="panel-body">
          <div class="row"><div class="col-md-6">
            <?php 
              $sql = mysqli_query($con, "SELECT COUNT(r.reviewid) as count, CONCAT(d.firstname, ' ', d.midname, ' ', d.lastname) as fullname, d.doctorid FROM review r, doctor d WHERE r.doctorid = d.doctorid and date(r.reviewtime) ".$t." GROUP BY d.doctorid ORDER BY count DESC LIMIT 10");
              $i = 1;
              $review = array();
              $reviewarray = array();
              while($reviews = mysqli_fetch_assoc($sql)){
                echo '<h3>#'.$i.' <a href="viewprofile.php?did='.$reviews['doctorid'].'" target="viewprofile.php?did='.$reviews['doctorid'].'">'.$reviews['fullname'].'</a> ('.$reviews['count'].' users)</h3>';
                $sql3 = mysqli_query($con, "SELECT count(reviewid) as count, date(reviewtime) as day FROM review WHERE doctorid = ".$reviews['doctorid']." and date(reviewtime) ".$t." GROUP BY date(reviewtime) ORDER BY reviewtime ASC");  
                while($revcount = mysqli_fetch_assoc($sql3)){
                  $review = array($revcount['day'], $revcount['count']);
                  $reviewarray[] = $review;
                }
                $i++;
                $drmostreviewedarr[] = $reviewarray;
              }
            ?></div><div class="col-md-6">
            <div id="drmostreviewed"></div>
            </div>
            </div>
          </div>
        </div>

      
        <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title">Top Ranked Doctors</h3></div>
          <div class="panel-body">
          <div class="row"><div class="col-md-6">
            <?php 
              $sql = mysqli_query($con, "SELECT AVG(r.rating) as avg, CONCAT(d.firstname, ' ', d.midname, ' ', d.lastname) as fullname, d.doctorid FROM review r, doctor d WHERE r.doctorid = d.doctorid and date(r.reviewtime) ".$t." GROUP BY d.doctorid ORDER BY avg DESC LIMIT 10");
              $i=1;
               $rankarr = array();
              $rankarray = array();
              while($rank = mysqli_fetch_assoc($sql)){
                echo '<h3>#'.$i.' <a href="viewprofile.php?did='.$rank['doctorid'].'" target="viewprofile.php?did='.$rank['doctorid'].'">'.$rank['fullname'].'</a> ('.substr($rank['avg'], 0, 4).' <i class="fa fa-stethoscope"></i>)</h3>';
                $sql4 = mysqli_query($con, "SELECT AVG(rating) as avg, date(reviewtime) as day FROM review WHERE doctorid = ".$rank['doctorid']." and date(reviewtime) ".$t." GROUP BY date(reviewtime) ORDER BY reviewtime ASC");  
                while($rankpos = mysqli_fetch_assoc($sql4)){
                  $rankarr = array($rankpos['day'], substr($rankpos['avg'], 0, 1));
                  $rankarray[] = $rankarr;
                }
                $i++;
                $drrankingarr[] = $rankarray;
              }
            ?></div><div class="col-md-6">
            <div id="drranking"></div>
            </div>
            </div>
          </div>
        </div>

    <?php

  }else if(isset($_GET['table'])){
    switch ($table) {
      case 'patient':
        $sql = "SELECT * FROM patient p, patientpersonal pp WHERE p.patientid = pp.patientid";
        $ppresult = mysqli_query($con, $sql);
        ?>
        <table class="table table-striped">
            <thead>
              <tr>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Sex</th>
                <th>Birthdate</th>
                <th>Address</th>
                <th>Contact</th>
                <th>E-mail</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              while($row = mysqli_fetch_assoc($ppresult)){
                echo '<tr>
                <td>' . $row['lastname'] . '</td>
                <td>' . $row['firstname'] . '</td>
                <td>' . $row['midname'] . '</td>
                <td>' . $row['sex'] . '</td>
                <td>' . $row['bdate'] . '</td>
                <td>' . $row['address'] . '</td>
                <td>' . $row['contact'] . '</td>
                <td>' . $row['email'] . '</td>
                </tr>';
              }
            ?>
            </tbody>
          </table>
        <?php
        break;
      case 'patientmedical':
        $sql = "SELECT * FROM patient p, patientmedical pm WHERE p.patientid = pm.patientid";
        $pmresult = mysqli_query($con, $sql);
        ?>
        <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Height</th>
                <th>Weight</th>
                <th>Bloodtype</th>
                <th>Blood Pressure</th>
                <th>Allergies</th>
                <th>Medical History</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              while($row = mysqli_fetch_assoc($pmresult)){
                echo '<tr>
                <td>' . $row['firstname'] .' '. $row['lastname'] . '</td>
                <td>' . $row['height'] . '</td>
                <td>' . $row['weight'] . '</td>
                <td>' . $row['bloodtype'] . '</td>
                <td>' . $row['bloodpressure'] . '</td>
                <td>' . $row['allergies'] . '</td>
                <td>' . $row['medicalhist'] . '</td>
                </tr>';
              }
            ?>
            </tbody>
          </table>
        <?php
        break;
      case 'doctor':
          $sql = "SELECT * FROM doctor d, doctorbackground db WHERE d.doctorid = db.doctorid";
          $doctorresult = mysqli_query($con, $sql);
        ?>
        <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Specialty</th>
                <th>Hospital</th>
                <th>Office Address</th>
                <th>Contact</th>
                <th>E-mail</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              while($row = mysqli_fetch_assoc($doctorresult)){
                echo '<tr>
                <td>' . $row['firstname'] .' '. $row['lastname'] . '</td>
                <td>' . $row['specialty'] . '</td>
                <td>' . $row['hospitalname'] . '</td>
                <td>' . $row['officeaddress'] . '</td>
                <td>' . $row['officecontact'] . '</td>
                <td>' . $row['email'] . '</td>
                </tr>';
              }
            ?>
              
            </tbody>
          </table>
        <?php
        break;

      default:
        echo 'Invalid table variable';
        break;
    }
  }
    
    include_once("_footer.php");

?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="dist/jqplot/jquery.jqplot.js"></script>
<script type="text/javascript" src="dist/jqplot/plugins/jqplot.pieRenderer.js"></script>
<script type="text/javascript" src="dist/jqplot/plugins/jqplot.dateAxisRenderer.js"></script>
<link rel="stylesheet" type="text/css" href="dist/jqplot/jquery.jqplot.css" />
</div></div>
<script class="code" type="text/javascript">
  $(document).ready(function(){
    <?php if(isset($_GET['forum'])){ ?>

    var plot1 = $.jqplot('category', <?php echo json_encode($catarray) ?>, {
        grid: {
            drawBorder: false, 
            drawGridlines: false,
            background: '#ffffff',
            shadow:false
        },
        axesDefaults: {
             
        },
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer,
            rendererOptions: {
                showDataLabels: true
            }
        },
        legend: {
            show: true,
            rendererOptions: {
                numberRows: 1
            },
            location: 's'
        }
    });

    var plot2 = $.jqplot('tag', <?php echo json_encode($tagarray) ?>, {
        grid: {
            drawBorder: false, 
            drawGridlines: false,
            background: '#ffffff',
            shadow:false
        },
        axesDefaults: {
             
        },
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer,
            rendererOptions: {
                showDataLabels: true
            }
        },
        legend: {
            show: true,
            rendererOptions: {
                numberRows: 1
            },
            location: 's'
        }
    });

     var plot3 = $.jqplot('comment', <?php echo json_encode($postarray) ?>,  {
      axes:{
        xaxis:{
          renderer:$.jqplot.DateAxisRenderer
        }
      },
      series:[{lineWidth:4, markerOptions:{style:'square'}}]
    });

    <?php } ?>


     var plot4 = $.jqplot('drmostreviewed', <?php echo json_encode($drmostreviewedarr) ?>,  {
      axes:{
        xaxis:{
          renderer:$.jqplot.DateAxisRenderer
        }
      },
      series:[{lineWidth:4, markerOptions:{style:'square'}}]
    });

     var plot5 = $.jqplot('drranking', <?php echo json_encode($drrankingarr) ?>,  {
      axes:{
        xaxis:{
          renderer:$.jqplot.DateAxisRenderer
        }
      },
      series:[{lineWidth:4, markerOptions:{style:'square'}}]
    });


  
  });

</script>

    
        
<?php
	
	mysqli_close($con);
?>