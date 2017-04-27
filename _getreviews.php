<?php
	include_once("_database.php");
		isset($_GET['did']) ? $doctorid = $_GET['did'] : $doctorid = $_SESSION['doctorid'];
		
		$review = mysqli_query($con, "SELECT * FROM review, patient WHERE review.doctorid='$doctorid' and review.patientid = patient.patientid ORDER BY reviewtime desc");
		$reviewcount = mysqli_num_rows($review);

		if($reviewcount>0){

			while($reviewdata = mysqli_fetch_assoc($review)){
				echo '<h2>';
				for($i=0;$i<$reviewdata['rating'];$i++) echo '<i class="fa fa-stethoscope fa-lg stethoscope-checked">&nbsp;</i>';
				echo '<i>"'.$reviewdata['reviewtitle'].'"</i></h2>
					<i>"'.$reviewdata['reviewcontent'].'"</i>
						<br>
						<h6 class="text-muted">by '.$reviewdata['firstname'].' '.$reviewdata['lastname'].' on '.$reviewdata['reviewtime'].'</h6>
					<hr>'
					;	
			}
			


			
			?> 

			<!--
			<div id="stethoscope-container">
                <i class="fa fa-stethoscope fa-3x stethoscope" id="stethoscope-1" style="margin-bottom: 10px;"></i>
                <i class="fa fa-stethoscope fa-3x stethoscope" id="stethoscope-2"></i>
                <i class="fa fa-stethoscope fa-3x stethoscope" id="stethoscope-3"></i>
                <i class="fa fa-stethoscope fa-3x stethoscope" id="stethoscope-4"></i>
                <i class="fa fa-stethoscope fa-3x stethoscope" id="stethoscope-5"></i>
              <h3><?php echo '<>';?></h3>
              <textarea placeholder="Add your detailed review here" class="form-control" id="reviewcontent" style="margin-bottom: 10px;"></textarea>
              <div class="row">
                <div class="col-xs-4 col-md-2"><button class="form-control" id="poor" style="margin-bottom: 10px;"><i>Poor!</i></button></div>
                <div class="col-xs-4 col-md-2"><button class="form-control" id="good" style="margin-bottom: 10px;"><i>Good!</i></button></div>
                <div class="col-xs-4 col-md-2"><button class="form-control" id="excellent" style="margin-bottom: 10px;"><i>Excellent!</i></button></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"><button class="btn btn-default" id="review">ADD REVIEW</button></div>
              </div>
              </div>
              <hr>
              -->
			<?php
		}else{
			?>
			No reviews at moment.
			<?php
		}

	
?>