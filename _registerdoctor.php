<?php
  session_start();
  include("_database.php");
  
  $email = $_POST['email'];

  $search = "SELECT * FROM patient, doctor WHERE patient.email='$_POST[email]' or doctor.email='$_POST[email]'";

  $result = mysqli_query($con,$search);
      
  $count = mysqli_num_rows($result);
    
  if($count==0){
    		$firstname = $_POST['firstname'];
    		$midname = $_POST['midname'];
    		$lastname = $_POST['lastname'];
    		$sex = $_POST['sex'];
    		$code = md5(rand(0, 999999));
        $sql="INSERT INTO doctor VALUES (NULL, '$firstname', '$midname', '$lastname', '$sex', '$email', '$code', 0)";
        mysqli_query($con, $sql);
        $id = $con->insert_id;

        if(!isset($_POST['specialty'])){
          $specialty = 'General Practitioner';
        }else{
          $specialty = $_POST['specialty'];
        }


        $sql="INSERT INTO doctorbackground
            VALUES('$id', '$_POST[type]', '$specialty', '$_POST[schedule]', '$_POST[hospitalname]', '$_POST[officeaddress]', '$_POST[officehours]', '$_POST[officecontact]')";
        mysqli_query($con, $sql);

 
              $msg = "Welcome to Dr. Healthcare, Dr. ".$firstname."!\n\nThanks for registering. Please click on the link below to confirm your email address and set your password.\n\nhttp://drhealthcare.000webhostapp.com/drconfirm.php?code=".$code."&email=".$email;

        		    // send email
        		    mail($email,"Dr. Healthcare Registration",$msg);

                echo '<script language="javascript">alert("Message sent to doctor for verification!");window.location.href="admin-registerdoctor.php";</script>';


    }else{
        echo '<script language="javascript">alert("Existing email");window.location.href="admin-registerdoctor.php";</script>';
    }

  
?>