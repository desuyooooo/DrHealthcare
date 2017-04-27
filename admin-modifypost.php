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
        $category = mysqli_query($con, "SELECT * FROM category ORDER BY catname");
        $count = mysqli_num_rows($postresult);

        if($count>0){
            while ($row = mysqli_fetch_array($postresult)) {
              echo ('
                <form action="_adminmodifypost.php" method="post">
                <div class="form-group" >
                <input type="hidden" name="postid" value="'.$row['postid'].'">
                <p>Title: <input type="text" placeholder="Title or subject of your thread" name="posttitle" class="form-control" style="margin-right:15px; margin-bottom:5px;" required value="'.$row['posttitle'].'"></p>
                <p>Content<textarea type="text" placeholder="Please enter the content" name="postcontent" class="form-control" style="margin-right:15px; margin-bottom:5px;" required>'.$row['postcontent'].'</textarea></p>
                <p>Tags: <input type="text" placeholder="Separate tags by comma" name="posttag" class="form-control" style="margin-right:15px; margin-bottom:5px;" required value="'.$row['tag'].'"></p>
                <p>Category:
                <select name="cat" name="category" required>
                  "');

                  while ($cat = mysqli_fetch_assoc($category)){
                          ($cat['catid']==$row['catid'])?$selected='selected':$selected='';
                          echo '<option value="'.$cat['catid'].'" '.$selected.'>'.$cat['catname'].'</option>';
                  }

                echo ('</select></p>
                <p><button type="submit" class="btn btn-default" >MODIFY AND APPROVE POST</button></p>
                <p><a href="admin-viewpost.php?id='.$_GET['id'].'" class="btn btn-default">CANCEL MODIFY</a></p>
                </div>
                </form>
                ');


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
