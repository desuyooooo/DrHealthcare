<?php
  include_once("_database.php");

  if($_SESSION['type']=='patient'){
    $sql = "SELECT * FROM friend f, doctor d WHERE f.patientid='$_SESSION[patientid]' and f.doctorid = d.doctorid and f.status = 'R' and f.reqfrom='D' ORDER BY latestinteracttime desc";
    $friendrequests = mysqli_query($con, $sql);
    $friendreqcount = mysqli_num_rows($friendrequests);

    if($friendreqcount!=0){
      while($frreq = mysqli_fetch_assoc($friendrequests)){
        echo '<span style="font-size: 14px;">&emsp;<a href="viewprofile.php?did='.$frreq['doctorid'].'">'.$frreq['firstname'].' '.$frreq['lastname'].'</a>
              <a href="_friendaccept.php?id='.$frreq['friendid'].'"><i class="fa fa-check"></i></a>
              <a href="_friendnotnow.php?id='.$frreq['friendid'].'"><i class="fa fa-close"></i></a></span><br>';    
      }  
    }else{
      echo '<li>&emsp;&emsp;No friend requests.</li>';
    }

    $acceptedfr = mysqli_query($con, "SELECT * FROM friend f, doctor d WHERE f.patientid='$_SESSION[patientid]' and f.doctorid = d.doctorid and f.status = 'A' and f.reqfrom='P' and unreadfr=1");

    if($acceptedfr){
    $count = mysqli_num_rows($acceptedfr);
    if($count>0){
      echo '<li role="separator" class="divider"></li>';
      while ($friend = mysqli_fetch_assoc($acceptedfr)){
        echo '<span style="font-size: 14px; padding-left, padding-right:10px;">&emsp;<a href="viewprofile.php?did='.$friend['doctorid'].'">'.$friend['firstname'].' '.$friend['lastname'].'</a> accepted your friend request.</span>';
      }
    }
    }
                        
  }else if($_SESSION['type']=='doctor'){
    $sql = "SELECT * FROM friend f, patient p WHERE f.doctorid='$_SESSION[doctorid]' and f.patientid = p.patientid and f.status = 'R' and f.reqfrom='P' ORDER BY latestinteracttime desc";
    $friendrequests = mysqli_query($con, $sql);
    $friendreqcount = mysqli_num_rows($friendrequests);

    if($friendreqcount!=0){                    
      while($frreq = mysqli_fetch_assoc($friendrequests)){ 
        echo '<span style="font-size: 14px;">&emsp;<a href="viewprofile.php?pid='.$frreq['patientid'].'">'.$frreq['firstname'].' '.$frreq['lastname'].'</a>
              <a href="_friendaccept.php?id='.$frreq['friendid'].'"><i class="fa fa-check"></i></a>
              <a href="_friendnotnow.php?id='.$frreq['friendid'].'"><i class="fa fa-close"></i></a></span><br>';    
      }
    }else{
      echo '<li>&emsp;&emsp;No friend requests.</li>';
    }

    $acceptedfr = mysqli_query($con, "SELECT * FROM friend f, patient p WHERE f.doctorid='$_SESSION[doctorid]' and f.patientid = p.patientid and f.status = 'A' and f.reqfrom='D' and unreadfr=1");
    $count = mysqli_num_rows($acceptedfr);

    if($count>0){
      echo '<li role="separator" class="divider"></li>';
      while ($friend = mysqli_fetch_assoc($acceptedfr)){
        echo '<span style="font-size: 14px;">&emsp;<a href="viewprofile.php?pid='.$friend['patientid'].'">'.$friend['firstname'].' '.$friend['lastname'].'</a> accepted your friend request.</span>';
      }
    }

  }
?>