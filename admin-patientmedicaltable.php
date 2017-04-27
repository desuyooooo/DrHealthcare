<?php 
  session_start();
if(!isset($_SESSION["type"]))
    header("location: index.php");
  else if($_SESSION["type"]=='patient'||$_SESSION["type"]=='doctor')
    header("location: index.php");


  include("_database.php");

  $sql = "SELECT * FROM patient p, patientpersonal pp, patientmedical pm WHERE p.patientid = pp.patientid AND pp.patientid = pm.patientid";
  $patientresult = mysqli_query($con, $sql);
  
  $title = "Patients";
  $class2 = "active";
  include_once("header-admin.php");
?>


    <div class="container">

      <h1 class="page-header">Patients</h1>
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation"><a href="adminpage.php">Patients' Personal Information</a></li>
          <li role="presentation" class="active"><a href="admin-patientmedicaltable.php">Patients' Medical Information</a></li>
          
        </ul>
        <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Height</th>
				        <th>Weight</th>
				        <th>Bloodtype</th>
                <th>Blood Pressure</th>
                <th>Allergies</th>
                <th>Medical History</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              while($row = mysqli_fetch_assoc($patientresult)){
                echo '<tr>
                <td>' . $row['firstname'] .' '. $row['lastname'] . '</td>
                <td>' . $row['height'] . '</td>
				        <td>' . $row['weight'] . '</td>
                <td>' . $row['bloodtype'] . '</td>
                <td>' . $row['bloodpressure'] . '</td>
                <td>' . $row['allergies'] . '</td>
                <td>' . $row['medicalhist'] . '</td>
                </tr>';
              }
            ?>
              
            </tbody>
          </table>
<?php
	include_once("footer.php");
	mysqli_close($con);
?>