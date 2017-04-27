

    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Dr. Healthcare</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li class="<?php echo $class1; ?>"><a href="admin-index.php">Forum</a></li>
            <li class="<?php echo $class2; ?>"><a href="admin-reports.php?overview">Reports</a></li>
			<?php if ($_SESSION["type"]=="admin") { ?><li class="<?php echo $class4; ?>"><a href="admin-registerdoctor.php">Register a Doctor</a></li><?php } ?>
            <li class="<?php echo $class5; ?>"><a href="admin-category.php">Add/Remove Category</a></li>

        </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
			<li class="<?php echo $class4; ?>"><a >Hello, <?php echo $_SESSION["fullname"];?>!</a></li>
            <li><a href="_logout.php">Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>