<!-- HEADER NAVIGATION FOR LOGGED IN USERS-->
  <input type="hidden" value="<?php $_SESSION['type']=='patient'?$type='patient':$type='doctor'; echo $type; ?>" id="type"/>
  <input type="hidden" value="<?php $_SESSION['type']=='patient'?$id=$_SESSION['patientid']:$id=$_SESSION['doctorid']; echo $id; ?>" id="id"/>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Dr. Healthcare</a>
        </div>
        
        <div id="navbar" class="navbar-collapse collapse">
          
          <ul class="nav navbar-nav">
            <li class="<?php echo $class1; ?>"><a href="index.php">Forum</a></li>
            <!--<li class="<?php echo $class2; ?>"><a href="appointments.php">Appointments</a></li>-->
            <li>&emsp;</li>
            <li><form method="post" action="_search.php">
                <input type="text" placeholder="Quick Search" name="search" class="form-control" style="margin-top:10px; margin-bottom: 5px; width:100%; height:30px; "  required>
                </form>
            </li>
            <li>&emsp;</li>
            <li class="<?php echo $class5; ?>"><a href="advancesearch.php?ktitle=&ktag=&kcontent=&kdoctor=&kpatient=&kstatus=">Advanced</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li class="<?php echo $class3; ?>"><a href="profile.php"><?php if($_SESSION["type"]=='doctor') echo '<i class="fa fa-lg fa-user-md"></i>'?><?php echo ' '.$_SESSION['firstname']; ?></a></li>
            <li class="<?php echo $class4; ?>"><a href="messages.php#end">Messages <span class="label label-pill label-default messagecount" style="border-radius:10px;"></span></a></li>
            <li class="dropdown">
              <?php include_once("_notifcount.php"); ?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Notifs <span class="label label-pill label-default count" style="border-radius:10px;"><?php if($notifcount!=0){echo $notifcount;} ?></span><span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Friend Requests</li>
                <div class="friendrequests"></div>
                <?php 
                  include_once("_friendrequests.php");
                ?>

                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Forum</li>
                <div class="forum"></div>
                <?php 
                  include_once("_forumnotifs.php");
                ?>

                                <!-- RESERVED FOR NOTIFICATIONS
                <li role="separator" class="divider"></li>
                <li><a href="#">Notification 1<br>notification description</a></li>

                -->
              </ul>
            </li>
            <li> <a href="_logout.php">Log out</a></li>
          </ul>

        </div><!--/.navbar-collapse -->
      </div>
  </nav>
  <?php if(isset($_SESSION['confirmed'])){ ?>
  <nav class="navbar navbar-default navbar-lower alert alert-warning" role="navigation" >
  <div class="container">
    <strong>You haven't confirmed you email address yet.</strong> <a href="resend.php">Resend confirmation mail</a>
  </div>
  </nav>
  <?php } ?>