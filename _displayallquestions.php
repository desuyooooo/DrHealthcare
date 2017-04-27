<?php 
include("_database.php")
?>
<div class="col-md-9">
              <div class="panel panel-default">
            <div class="panel-body">

            <?php

            if(isset($_GET['skip']))
              $skip = 'LIMIT 10 OFFSET '.$_GET['skip'];
            else 
              $skip = 'LIMIT 10';

            $count = 0;

            if(!isset($_GET['id']) && !isset($_GET['tag'])){

            $sql = "SELECT * FROM post p, category c, patient pt WHERE p.catid = c.catid and p.patientid = pt.patientid and p.approved='Y' ORDER BY postid desc ".$skip ;
            $postresult = mysqli_query($con, $sql);
            $allrows = mysqli_query($con, "SELECT * FROM post p, category c, patient pt WHERE p.catid = c.catid and p.patientid = pt.patientid and p.approved='Y'");
            $count = mysqli_num_rows($allrows);

            if($count==0){
              echo '<label align="center">No questions available.</label>';
            }else{
              while ($row = mysqli_fetch_array($postresult)) {

              $tags = $row['tag'];
              $arrTags = explode("#", trim($tags));

              echo '<h4><strong><a href="viewpost.php?id='.$row['postid'].'">'.$row['posttitle'];
              if($row['solved']=='Y') echo ' (Solved)';
              echo '</a></strong></h4>';
              echo '<div class="row"><div class="col-md-8">';
              
              echo '<p>'.substr($row['postcontent'], 0, 80).'...</p>';
              echo '<strong><a href="?id='.$row['catid'].'">'.$row['catname'].'</a></strong> | Tags: ';
              foreach($arrTags as $tag)
              {
                if($tag != '') echo '<a href="?tag='.$tag.'">#'.$tag.'</a> ';  
              }
              echo '<br>';
              echo '</div><div class="col-md-4">';
              echo 'Asked by <a href="viewprofile.php?pid='.$row['patientid'].'">'.$row['firstname'].' '.$row['lastname'].'</a><br>';
              echo $row['timeposted'];
              echo '</div></div><hr>';
              }
            }

            }else if(isset($_GET['id'])) {
            $sql = "SELECT * FROM post p, category c, patient pt WHERE c.catid='$_GET[id]' and p.catid = c.catid and p.patientid = pt.patientid and p.approved = 'Y' ORDER BY postid desc ".$skip;
            $postresult = mysqli_query($con, $sql);
            $allrows = mysqli_query($con, "SELECT * FROM post p, category c, patient pt WHERE c.catid='$_GET[id]' and p.catid = c.catid and p.patientid = pt.patientid and p.approved='Y'");
            $count = mysqli_num_rows($allrows);

            $count = mysqli_num_rows($postresult);

            if($count==0){
              echo '<label>No posts available. Back to <a href="index.php">index</a>.</label>';
            }else{

              echo '<h6><a href="index.php">&laquo; Back to index</a>.</h6>';
              $cat = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM category WHERE catid='$_GET[id]'"));
              echo '<h2>Category: <a href="#">'.$cat['catname'].'</a></h2><hr>';
              
              while ($row = mysqli_fetch_array($postresult)) {

              $tags = $row['tag'];
              $arrTags = explode("#", trim($tags));

              echo '<h4><strong><a href="viewpost.php?id='.$row['postid'].'">'.$row['posttitle'];
              if($row['solved']=='Y') echo ' (Solved)';
              echo '</a></strong></h4>';
              echo '<div class="row"><div class="col-md-8">';
              
              echo '<p>'.substr($row['postcontent'], 0, 60).'...</p>';
              echo '<strong><a href="?id='.$row['catid'].'">'.$row['catname'].'</a></strong> | Tags: ';
              foreach($arrTags as $tag)
              {
                if($tag != '') echo '<a href="?tag='.$tag.'">#'.$tag.'</a> ';  
              }
              echo '<br>';
              echo '</div><div class="col-md-4">';
              echo 'Asked by '.$row['firstname'].' '.$row['lastname'].'<br>';
              echo $row['timeposted'];
              echo '</div></div><hr>';
              }
            }
            }else if (isset($_GET['tag'])) {


            $sql = "SELECT * FROM post p, category c, patient pt WHERE `tag` LIKE '%$_GET[tag]%' and p.catid = c.catid and p.patientid = pt.patientid and p.approved = 'Y' ORDER BY postid desc ".$skip;
            $postresult = mysqli_query($con, $sql);
            $allrows = mysqli_query($con, "SELECT * FROM post p, category c, patient pt WHERE `tag` LIKE '%$_GET[tag]%'  and p.catid = c.catid and p.patientid = pt.patientid and p.approved='Y'");
            $count = mysqli_num_rows($allrows);

            if($count==0){
              echo '<label>No posts available. Back to <a href="index.php">index</a>.</label>';
            }else{
              echo '<h6><a href="index.php">&laquo; Back to index</a>.</h6>';
              echo '<h2>Tag: #'.$_GET['tag'].'</h2><hr>';

              while ($row = mysqli_fetch_array($postresult)) {

              $tags = $row['tag'];
              $arrTags = explode("#", trim($tags));

              echo '<h4><strong><a href="viewpost.php?id='.$row['postid'].'">'.$row['posttitle'].'</a></strong></h4>';
              echo '<div class="row"><div class="col-md-8">';
              
              echo '<p>'.substr($row['postcontent'], 0, 60).'...</p>';
              echo '<strong><a href="?id='.$row['catid'].'">'.$row['catname'].'</a></strong> | Tags: ';
              foreach($arrTags as $tag)
              {
                if($tag != '') echo '<a href="?tag='.$tag.'">#'.$tag.'</a> ';  
              }
              echo '<br>';
              echo '</div><div class="col-md-4">';
              echo 'Asked by '.$row['firstname'].' '.$row['lastname'].'<br>';
              echo $row['timeposted'];
              echo '</div></div><hr>';
              }
            }
            }

            echo '<center>';
            $pages = round($count/10);
            for($i=0; $i < $pages; $i++){
              echo '<a href="?&skip='.($i*10).'">'.($i+1).'</a>&emsp;';
            }
            echo '</center>';

            ?>            
            </div>
            </div>
</div>