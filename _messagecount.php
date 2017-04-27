<?php
  include_once("_database.php");

  if($_GET['type']=='patient'){

    $count = mysqli_query($con, "SELECT * FROM friend f, pdmessage m WHERE f.patientid='$_GET[id]' and f.friendid = m.friendid and m.sentby='D' and m.unreadm=1 GROUP BY f.doctorid");
    $mcount = mysqli_num_rows($count); 

    if($mcount>0) echo $mcount;



  }else if($_GET['type']=='doctor'){

    $count = mysqli_query($con, "SELECT * FROM friend f, pdmessage m WHERE f.doctorid='$_GET[id]' and f.friendid = m.friendid and m.sentby='P' and m.unreadm=1 GROUP BY f.patientid");
    $mcount = mysqli_num_rows($count); 

    if($mcount>0) echo $mcount;

  }
?>