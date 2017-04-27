<?php
  include_once("_database.php");

  if($_SESSION['type']=='patient'){
    $count = mysqli_query($con, "SELECT * FROM friend f, doctor d WHERE (f.patientid='$_SESSION[patientid]' and f.doctorid = d.doctorid) and ((f.status = 'A' and f.reqfrom='P') or (f.status = 'R' and f.reqfrom='D')) and unreadfr=1");
    $notifcount = mysqli_num_rows($count);  

    $count = mysqli_query($con, "SELECT * FROM post p WHERE p.patientid='$_SESSION[patientid]' and seen=1");
    $notifcount =  $notifcount + mysqli_num_rows($count);  

  }else if($_SESSION['type']=='doctor'){
    $count = mysqli_query($con, "SELECT * FROM friend f, patient p WHERE (f.doctorid='$_SESSION[doctorid]' and f.patientid = p.patientid) and ((f.status = 'A' and f.reqfrom='D') or (f.status = 'R' and f.reqfrom='P')) and unreadfr=1");
    $notifcount = mysqli_num_rows($count); 

  }
?>