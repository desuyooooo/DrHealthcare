<?php 
  session_start();
  if(!isset($_SESSION["type"]))
    header("location: 01Homepage.php");
  else if($_SESSION["type"]=='patient')
    header("location: 04PatientProfile.php");

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
          <li role="presentation" class="active"><a href="adminpage.php">Patients' Personal Information</a></li>
          <li role="presentation"><a href="admin-patientmedicaltable.php">Patients' Medical Information</a></li>
        </ul>
        <table class="table table-striped">
            <thead>
              <tr>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Sex</th>
                <th>Birthdate</th>
                <th>Address</th>
                <th>Contact</th>
                <th>E-mail</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              while($row = mysqli_fetch_assoc($patientresult)){
                echo '<tr>
                <td>' . $row['lastname'] . '</td>
                <td>' . $row['firstname'] . '</td>
                <td>' . $row['midname'] . '</td>
                <td>' . $row['sex'] . '</td>
                <td>' . $row['bdate'] . '</td>
                <td>' . $row['address'] . '</td>
                <td>' . $row['contact'] . '</td>
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