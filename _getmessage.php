 <?php
    session_start();
    include_once("_database.php");


    if(isset($_GET['friendid'])){

        $sqlmessages = "SELECT * FROM pdmessage WHERE friendid = '$_GET[friendid]' ORDER BY timesent asc";
        $messageshow = mysqli_query($con, $sqlmessages);
        $messagecount = mysqli_num_rows($messageshow);

        $currentuser;

        if($_SESSION['type']=='doctor'){
          $currentuser = 'D';
          $chat = 'P';
        }else if($_SESSION['type']=='patient'){
          $currentuser = 'P';
          $chat = 'D';
        }


            if($messagecount>0){
                while($message = mysqli_fetch_assoc($messageshow)){
                  
                  if($message['sentby']==$currentuser){
                    echo '
                      <li class="left clearfix admin_chat">
                        <span class="chat-img1 pull-right">
                          <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="User Avatar" class="img-circle">
                        </span>
                        <div class="me clearfix">
                          <p>'.$message['messagecontent'].'</p>
                          <div class="chat_time pull-left text-muted">'.$message['timesent'].'</div>
                        </div>
                      </li>';
                  }else{
                    echo '
                     <li class="left clearfix">
                        <span class="chat-img1 pull-left">
                          <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="User Avatar" class="img-circle">
                        </span>
                        <div class="chat-body1 clearfix">
                          <p>'.$message['messagecontent'].'</p>
                          <div class="chat_time pull-right text-muted">'.$message['timesent'].'</div>
                        </div>
                      </li>
                    ';
                  }

                $update = mysqli_query($con, "UPDATE pdmessage SET unreadm=0 WHERE messageid = '$message[messageid]' and sentby='$chat' and unreadm = 1");

                }


            }else{
                echo '<li>No message to display</li>';
            }
    }

?>