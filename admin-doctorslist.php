<?php 
  session_start();
if(!isset($_SESSION["type"]))
    header("location: index.php");
  else if($_SESSION["type"]=='patient'||$_SESSION["type"]=='doctor')
    header("location: index.php");

  include("_database.php");

  //$sql = "SELECT * FROM patient p, patientpersonal pp, patientmedical pm WHERE p.patientid = pp.patientid AND pp.patientid = pm.patientid";
  $sql = "SELECT * FROM doctor d, doctorbackground db WHERE d.doctorid = db.doctorid";
  $doctorresult = mysqli_query($con, $sql);
  
  $title = "Doctors";
  $class3 = "active";
	include_once("header-admin.php");
?>

    <div class="container">

      <h1 class="page-header">Doctors</h1>
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#">Doctors' Personal Information</a></li>
          <!--<li role="presentation"><a href="003DoctorsOccupation.php">Doctors' Occupational Background</a></li>-->

        </ul>
        <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Address</th>
				        <th>Contact</th>
				        <th>E-mail</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              while($row = mysqli_fetch_assoc($doctorresult)){
                echo '<tr>
                <td>' . $row['firstname'] .' '. $row['lastname'] . '</td>
                <td>' . $row['officeaddress'] . '</td>
				        <td>' . $row['officecontact'] . '</td>
                <td>' . $row['email'] . '</td>
                </tr>';
              }
            ?>
              
            </tbody>
          </table>
<?php
	include_once("footer.php");
	mysqli_close($con);
?>