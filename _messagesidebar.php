
<?php
  session_start();
  include_once("_database.php");
  if(isset($_SESSION['type'])){
    if($_SESSION['type']=='doctor'){ 
      $sql = "SELECT * FROM friend f, patient p WHERE f.doctorid = $_SESSION[doctorid] and f.patientid = p.patientid and f.status = 'A' ORDER BY latestinteracttime desc";      
    }else if($_SESSION['type']=='patient'){
      $sql = "SELECT * FROM friend f, doctor d WHERE f.patientid = $_SESSION[patientid] and f.doctorid = d.doctorid and f.status = 'A' ORDER BY latestinteracttime desc";
    }
  }
  
  $friendlist = mysqli_query($con, $sql);
  $friendcount = mysqli_num_rows($friendlist);

  if($friendcount>0){

    $count = 0;
                          
    while($friend = mysqli_fetch_assoc($friendlist)){

      $message = mysqli_query($con, "SELECT * FROM pdmessage WHERE friendid = '$friend[friendid]' ORDER BY timesent desc");
      $message = mysqli_fetch_assoc($message);
                            
      $selected = '';
      
      $emphasis = 'span';
      if(($message['sentby']=='D' && $_SESSION['type']=='patient')||($message['sentby']=='P' && $_SESSION['type']=='doctor'))
        $emphasis = 'strong';
      /*                      
      if(isset($_GET['id'])){
        if($_GET['id']==$friend['friendid']){
          $selected = 'selected';
        }
          $count = 1;
        }else if($count==0){
          $selected = 'selected';
          $count = 1;
        }
      */

      echo '
          <li class="left clearfix '.$selected.'">
          <a href="messages.php?id='.$friend['friendid'].'#end">
            <span class="chat-img pull-left">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="User Avatar" class="img-circle">
            </span>
            <div class="chat-body clearfix">
            <div class="header_sec">
              <strong class="primary-font">'.$friend['firstname'].' '. $friend['lastname'].'</strong>
                <span class="pull-right" style="font-size:12px">'.date("M d h:i A" ,strtotime($friend['latestinteracttime'])).'</span>
            </div>
            <div class="contact_sec">
              <'.$emphasis.' class="primary-font">'.substr($message['messagecontent'], 0, 20).'</'.$emphasis.'>
              <!--<span class="badge pull-right">3</span>-->
            </div>
          </div>
        </a>
        </li>
      ';
    
    }
                      
  }else{
    echo "You have no friends";
  }

?>

<?php /*                    if(isset($_SESSION['type'])){
                      if($_SESSION['type']=='doctor'){
                        $sql = "SELECT * FROM friend f, patient p WHERE f.doctorid = $_SESSION[doctorid] and f.patientid = p.patientid and f.status = 'A' ORDER BY latestinteracttime desc";
                        $friendlist = mysqli_query($con, $sql);
                        $friendcount = mysqli_num_rows($friendlist);

                        if($friendcount!=0){

                          $count = 0;
                          
                          while($friend = mysqli_fetch_assoc($friendlist)){
                            
                            $selected = '';

                            
                            if(isset($_GET['id'])){
                              if($_GET['id']==$friend['friendid']){
                                $selected = 'selected';
                                
                              }
                              $count = 1;
                            }else if($count==0){
                              $selected = 'selected';
                              $count = 1;
                            }

                            echo '
                                <li class="left clearfix '.$selected.'">
                                <a href="messages.php?id='.$friend['friendid'].'#end">
                                  <span class="chat-img pull-left">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="User Avatar" class="img-circle">
                                  </span>
                                  <div class="chat-body clearfix">
                                    <div class="header_sec">
                                      <strong class="primary-font">'.$friend['firstname'].' '. $friend['lastname'].'</strong>
                                        <span class="pull-right">09:45AM</span>
                                    </div>
                                    <div class="contact_sec">
                                      <span class="primary-font">Blablablabla</span>
                                      <!--<span class="badge pull-right">3</span>-->
                                    </div>
                                  </div>
                                </a>
                                </li>
                            ';

                          }
                      
                        }else{
                          echo "You have no friends";
                        }

                      }else if($_SESSION['type']=='patient'){
                        $sql = "SELECT * FROM friend f, doctor d WHERE f.patientid = $_SESSION[patientid] and f.doctorid = d.doctorid and f.status = 'A' ORDER BY latestinteracttime desc";
                        $friendlist = mysqli_query($con, $sql);
                        $friendcount = mysqli_num_rows($friendlist);

                        if($friendcount!=0){

                          $count = 0;
                          
                          while($friend = mysqli_fetch_assoc($friendlist)){
                            
                            $selected = '';

                            
                            if(isset($_GET['id'])){
                              if($_GET['id']==$friend['friendid']){
                                $selected = 'selected';
                                
                              }
                              $count = 1;
                            }else if($count==0){
                              $selected = 'selected';
                              $count = 1;
                            }

                            echo '
                                <li class="left clearfix '.$selected.'">
                                <a href="messages.php?id='.$friend['friendid'].'#end">
                                  <span class="chat-img pull-left">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="User Avatar" class="img-circle">
                                  </span>
                                  <div class="chat-body clearfix">
                                    <div class="header_sec">
                                      <strong class="primary-font">'.$friend['firstname'].' '. $friend['lastname'].'</strong>
                                        <span class="pull-right">09:45AM</span>
                                    </div>
                                    <div class="contact_sec">
                                      <span class="primary-font">Blablablabla</span>
                                      <!--<span class="badge pull-right">3</span>-->
                                    </div>
                                  </div>
                                </a>
                                </li>
                            ';
                          }
                        }else{
                          echo '<li class="left clearfix">
                                  You have no friends.
                                </li>';
                        }

  
                      }
                    }*/
?>