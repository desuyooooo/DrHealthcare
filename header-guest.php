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
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Log In<span class="caret"></span></a>
              <ul class="dropdown-menu">
              <form class="navbar-form " action="_login.php" method="post">
              <div class="form-group">
                  <li><input type="text" placeholder="Email Address" name="email" class="form-control" style="margin-bottom:5px;" required></li>
                  <li><input type="password" placeholder="Password" name="password" class="form-control" style="margin-bottom:5px;" required></li>
                  <button class="btn btn-default" style="margin-right:15px; margin-bottom:5px;">Log In</button>
              </div>
                </form>
              </ul>
            </li>
            <li class="<?php echo $class3; ?>"><a href="signup.php">Sign Up</a></li>
          </ul>

            
        </div><!--/.navbar-collapse -->
      </div>
    </nav>