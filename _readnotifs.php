<?php
//fetch.php;
session_start();
if(isset($_POST["view"]))
{
 include("_database.php");
 if($_POST["view"] != '')
 {
  if($_SESSION['type']=='patient'){
    $update_query = "UPDATE friend f, doctor d SET unreadfr=0 WHERE (f.patientid='$_SESSION[patientid]' and f.doctorid = d.doctorid) and ((f.status = 'A' and f.reqfrom='P') or (f.status = 'R' and f.reqfrom='D')) and unreadfr=1";

    $updatepost= mysqli_query($con, "UPDATE post p SET seen=0 WHERE p.patientid='$_SESSION[patientid]' and p.seen=1");
  }else if($_SESSION['type']=='doctor'){
    $update_query = "UPDATE friend f, patient p SET unreadfr=0  WHERE (f.doctorid='$_SESSION[doctorid]' and f.patientid = p.patientid) and ((f.status = 'A' and f.reqfrom='D') or (f.status = 'R' and f.reqfrom='P')) and unreadfr=1";

  }
  mysqli_query($con, $update_query);
 }
}
?>