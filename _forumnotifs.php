<?php
  include_once("_database.php");

  if($_SESSION['type']=='patient'){
    $post = mysqli_query($con, "SELECT * FROM post p WHERE p.patientid='$_SESSION[patientid]' and seen=1 ORDER BY postid DESC");
    $postnotif = mysqli_num_rows($post);

    if($postnotif>0){
      while($p = mysqli_fetch_assoc($post)){
        if ($p['approved']=='Y' && $p['modified']=='N') $text='approved';
        else if ($p['approved']=='D') $text='declined';
        else if ($p['approved']=='Y' && $p['modified']=='Y') $text='modified and approved';

        echo '<li><a href="viewpost.php?id='.$p['postid'].'">Your post "'.$p['posttitle'].'" has been '.$text.'.</a></li>';    
      }  
    }else{
      echo '<li>&emsp;&emsp;No forum notifications.</li>';
    }


                        
  }else if($_SESSION['type']=='doctor'){


  }
?>