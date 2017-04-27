<?php
  session_start();

  $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
  
   if(!isset($_SESSION["type"]))
      header("location: index.php");

$title = "Index";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="dr. Healthcare index page">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title> <?php echo $title; ?> | Dr. Healthcare</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <link href="dist/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="dist/css/dashboard.css" rel="stylesheet">

  </head>

<body>
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
            <li class="active"><a href="index.php">Forum</a></li>
            <li><a href="apppoinment.php">Appointments</a></li>
        </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="patient-profile.php">Profile</a></li>
            <li> <a href="_logout.php">Log out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
       


    <div class="container">

      <h1 class="page-header">Forum</h1>
           <div class="row">
            <div class="col-md-9">
          <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="patient-index.php">Questions</a></li>
        <li role="presentation"  class="active"><a href="guest-ask-question.php">Ask a Question</a></li>
        </ul>
        </div>
          <div class="col-md-3">
            <form method="post">
                <input type="text" placeholder="Search a question" name="search" class="form-control"  required>
                </form>

          </div>
          </div>
        <br>
        <div class="row">
           <div class="col-md-9">
              <div class="panel panel-default">
            <div class="panel-body">

            <div class="row">
            <div class="col-md-9">
            
            <form action="_patientpost.php" method="post">
              <div class="form-group" >
              <p>Title: <input type="text" placeholder="Title or subject of your thread" name="title" class="form-control" style="margin-right:15px; margin-bottom:5px;" required></p>
              <p>Category:
              <select id="cat" name="category">                      
              <option value="0">--Select Category--</option>
              <option value="1">Allergies</option>
              <option value="2">Blood                          </option>
              <option value="3">Bones, joints and muscles      </option>
              <option value="4">Brain and nerves               </option>
              <option value="5">Cancer                         </option>
              <option value="6">Chest and lungs                </option>
              <option value="7">Child Health                   </option>
              <option value="8">Contraception and sexual health</option>
              <option value="9">Deficiency                     </option>
              <option value="10">Diabetes and hormone problem   </option>
              <option value="11">Ears, nose, throat and mouth   </option>
              <option value="12">Eyes                           </option>
              <option value="13">General                        </option>
              <option value="14">Gut, bowel and stomach         </option>
              <option value="15">Health promotion               </option>
              <option value="16">Heart and blood vessels        </option>
              <option value="17">Immunisations                  </option>
              <option value="18">Infections                     </option>
              <option value="19">Injury and accidents           </option>
              <option value="20">Kidneys, bladder and genitals  </option>
              <option value="21">Liver and gallbladder          </option>
              <option value="21">Men's health</option>
              <option value="22">Mental health</option>
              <option value="23">Operations ans surgical procedures</option>
              <option value="24">Pregnancy and newborn</option>
              <option value="25">Senior health</option>
              <option value="26">Skin and nails</option>
              <option value="27">Substance misuse</option>
              <option value="28">Symptoms</option>
              <option value="29">Teenage health</option>
              <option value="30">Tests and investigations</option>
              <option value="31">Women's health</option>
              </select></p>
              <p>Content<input type="text" placeholder="Please enter the content malamang" name="content" class="form-control" style="margin-right:15px; margin-bottom:5px;" required></p>
              <p><button type="submit" class="btn btn-default" >SUBMIT</button></p>
                </div>
                </form>
            </div>
            </div>
            <hr>

            </div>
            </div>
          </div>

          <?php include_once("category.php"); ?>


          
        </div>
<?php 
  include_once("_footer.php");
?>
    <script>
      $( function() {
      $( "#datepicker" ).datepicker();
    } );
  </script>
  </body>
</html>
<?php 
      mysqli_close($con);
?>
