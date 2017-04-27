<?php
	session_start();
	$tagex = explode('#', $_POST[stags]);

	header("location: advancesearch.php?ktitle=$_POST[stitle]&ktag=$tagex[1]&kcontent=$_POST[scontent]&kdoctor=$_POST[sdoctor]&kpatient=$_POST[spatient]&kstatus=$_POST[Status]");
