          <?php

          if($_SESSION['type']=='doctor'){

            if(isset($_GET['id'])){
              $sql = "SELECT * FROM friend f, patient p WHERE f.friendid = $_GET[id] and f.doctorid = $_SESSION[doctorid] and f.patientid = p.patientid and f.status = 'A'";
              $friend= mysqli_query($con, $sql);
              if($friend){
              $friendcount = mysqli_num_rows($friend);

              $active = mysqli_fetch_assoc($friend);
              $userid = 'pid='.$active['patientid'];
              }
            }else{
              $sql = "SELECT * FROM friend f, patient p WHERE f.doctorid = $_SESSION[doctorid] and f.patientid = p.patientid and f.status = 'A' ORDER BY latestinteracttime desc";
              $friend= mysqli_query($con, $sql);
              if($friend){
              $friendcount = mysqli_num_rows($friend);

              $active = mysqli_fetch_assoc($friend);
              $userid = 'pid='.$active['patientid'];
            }             
          }

          }else if($_SESSION['type']=='patient'){

            if(isset($_GET['id'])){
              $sql = "SELECT * FROM friend f, doctor d WHERE f.friendid = $_GET[id] and f.patientid = $_SESSION[patientid] and f.doctorid = d.doctorid and f.status = 'A'";
              $friend= mysqli_query($con, $sql);
              if($friend){
              $friendcount = mysqli_num_rows($friend);

              $active = mysqli_fetch_assoc($friend);
              $userid = 'did='.$active['doctorid'];
              }
            }else{
              $sql = "SELECT * FROM friend f, doctor d WHERE f.patientid = $_SESSION[patientid] and f.doctorid = d.doctorid and f.status = 'A' ORDER BY latestinteracttime desc";
              $friend= mysqli_query($con, $sql);
              if($friend){
              $friendcount = mysqli_num_rows($friend);

              $active = mysqli_fetch_assoc($friend);
              $userid = 'did='.$active['doctorid'];
              }
            }
          }

         ?>


      <div class="main_section">
        <div class="container">
          <div class="chat_container">
            <!--chat sidebar-->
            <div class="col-sm-3 chat_sidebar">
              <div class="row">
                
                <div id="custom-search-input">
                  <div class="input-group col-md-12">
                    <input type="text" class="  search-query form-control" placeholder="Conversation" />
                    <button class="btn btn-danger" style="width:10%" type="button">
                      <span class="glyphicon glyphicon-search"></span>
                    </button>
                  </div>
                </div>

                <!--DROP DOWN CONVERSATIONS
                
                <div class="dropdown all_conversation">
                  
                  <button class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-weixin" aria-hidden="true"></i>
                    All Conversations
                    <span class="caret pull-right"></span>
                  </button>
                
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <li><a href="#">All Conversation</a>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>

                </div>

                -->
              
              <div class="member_list">

                <ul class="list-unstyled">

                  <?php
                     
                  ?>
                  <input type="hidden" name="friendid" id="id" value="<?php echo $active['friendid'] ?>" />

                  <div class="messagesidebar">

                  </div>
                  <!--USER BLABLA-->
                  <?php 

                   // include_once("_messagesidebar.php");

                  ?>

                </ul>
              </div>
            </div>
         </div>
         <!--chat_sidebar-->



        <!--MESSAGE SECTION WOOOOOOO-->
        <div class="col-sm-9 message_section">
          <div class="row">
            <div class="new_message_head">
              <div class="pull-left"><button><?php if(isset($active)) echo '<a href="viewprofile.php?'.$userid.'">'.$active['firstname'].' '.$active['lastname'].'</a>';?></button></div>


            </div><!--new_message_head-->
     
            <div class="chat_area" id="chatarea">
              
              <ul class="list-unstyled">

              <div class="display-message">

                
              </div>

              <a id="end"></a>  
             
                  
              
          
              </ul>
          </div><!--chat_area-->
          
          <div class="message_write">
            <input type="hidden" name="friendid" id="friendid" value="<?php echo $active['friendid'] ?>" />
            <input type="hidden" id="sentby" value="<?php if($_SESSION["type"]=='doctor') echo 'D'; else if($_SESSION["type"]=='patient') echo 'P'; ?>">
            <textarea class="form-control" id="messagecontent" placeholder="type a message" name="messagecontent"></textarea>
            <div class="clearfix"></div>
           
            </script>
            <div class="chat_bottom">
              <button class="pull-right btn btn-default" id="send" <?php if(!isset($active)) echo 'disabled'; ?>>SEND</button>
            </div>
          </div>
        </div>
      </div> <!--message_section-->

    </div>

   
