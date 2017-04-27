<?php 
	
  session_start();
  if(!isset($_SESSION["type"]))
      header("location: index.php");

  include("_database.php");

  $doctorid = $_SESSION["doctorid"];
  $doctorname = $_SESSION["firstname"];
  /*
  $target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}


$temp = explode(".", $_FILES["fileToUpload"]["name"]);
$photo = $doctorname."-".round(microtime(true)) . '.' . end($temp);
if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "uploads/" . $photo)){
	$uploadOk = 1;
}
else $uploadOk = 0;



 Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}


// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    echo '<script language="javascript">alert("Sorry, there was an error uploading your file." '. mysqli_error($con) .');window.location.href="doctor-edit-profile.php";</script>';
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo '<script language="javascript">alert("File successfully uploaded");window.location.href="doctor-profile.php";</script>';

    } else {
        echo '<script language="javascript">alert("Sorry, there was an error uploading your file." '. mysqli_error($con) .');window.location.href="doctor-edit-profile.php";</script>';

    }
}


*/





  $sql = "UPDATE doctor SET firstname='$_POST[firstname]', midname='$_POST[midname]', lastname='$_POST[lastname]', sex='$_POST[sex]' WHERE doctorid='$doctorid'";
  $sql2 = "UPDATE doctorbackground SET specialty='$_POST[specialty]', schedule='$_POST[schedule]', hospitalname='$_POST[hospitalname]', officeaddress='$_POST[officeaddress]', officehours='$_POST[officehours]', officecontact='$_POST[officecontact]' WHERE doctorid='$doctorid'";
  	
	if (mysqli_query($con, $sql) && mysqli_query($con, $sql2)) {
		mysqli_close($con);
    	echo '<script language="javascript">alert("Profile Succesfully Updated");window.location.href="doctor-profile.php";</script>';
	} else {
    	echo '<script language="javascript">alert("Error updating profile." '. mysqli_error($con) .');window.location.href="doctor-edit-profile.php";</script>';
	}




/*
		$sqladmin="SELECT * FROM admin WHERE adminid='$username' AND password='$password'";
		$result = mysqli_query($con,$sqladmin);
      
      	$count = mysqli_num_rows($result);
		
		if($count==1){
			mysqli_close($con);
			$_SESSION["type"]="admin";
			while($row = mysqli_fetch_assoc($result)) 
        		$_SESSION["username"]=$row['firstname'];
			header("location: AdminPage.php");
		}
*/

		
?>