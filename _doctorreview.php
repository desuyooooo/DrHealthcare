
<?php
	include_once("_database.php");
	if(isset($_SESSION['type'])){

	if($_SESSION['type']=='patient'){
		//look at db if patient has already reviewed the doctor
		$patientid = $_SESSION['patientid'];
		$doctorid = $_GET['did'];
		$review = mysqli_query($con, "SELECT * FROM review WHERE doctorid='$doctorid' and patientid='$patientid'");
		$reviewccount = mysqli_num_rows($review);
		?>
		
        <input type="hidden" id="doctorid" value="<?php echo $doctorid?>">
        <input type="hidden" id="patientid" value="<?php echo $patientid?>">
		<?php
		if($reviewccount>0){
			?>
				<p>You have reviewed this doctor.</p>
				<hr>
			
			<?php
		}else{
			?>
			<div id="stethoscope-container">
                <i class="fa fa-stethoscope fa-3x stethoscope" id="stethoscope-1" style="margin-bottom: 10px;"></i>
                <i class="fa fa-stethoscope fa-3x stethoscope" id="stethoscope-2"></i>
                <i class="fa fa-stethoscope fa-3x stethoscope" id="stethoscope-3"></i>
                <i class="fa fa-stethoscope fa-3x stethoscope" id="stethoscope-4"></i>
                <i class="fa fa-stethoscope fa-3x stethoscope" id="stethoscope-5"></i>
              <input type="text" placeholder="Review title" class="form-control" id="reviewtitle" required>
              <textarea placeholder="Add your detailed review here" class="form-control" id="reviewcontent" style="margin-bottom: 10px;"></textarea>
              <div class="row">
                <div class="col-xs-4 col-md-2"><button class="form-control" id="poor" style="margin-bottom: 10px;"><i>Poor!</i></button></div>
                <div class="col-xs-4 col-md-2"><button class="form-control" id="good" style="margin-bottom: 10px;"><i>Good!</i></button></div>
                <div class="col-xs-4 col-md-2"><button class="form-control" id="excellent" style="margin-bottom: 10px;"><i>Excellent!</i></button></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"><button class="btn btn-default" id="review">ADD REVIEW</button></div>
              </div>
              <hr>
              </div>

			<?php
		}
	}
	}
?>