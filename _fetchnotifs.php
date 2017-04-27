<?php
//fetch.php;
session_start();
if(isset($_POST["view"]))
{
 include("_database.php");
 if($_POST["view"] != '')
 {
  $update_query = "UPDATE friend SET unreadfr=0 WHERE unreadfr=1";
  mysqli_query($connect, $update_query);
 }
 if($_SESSION['type']=='doctor'){
    $query = "SELECT * FROM friend WHERE doctorid = '$_SESSION[doctorid]' and unreadfr = 1 ORDER BY friendid DESC LIMIT 10";
 }else if($_SESSION['type']=='patient'){
    $query = "SELECT * FROM friend WHERE patientid = '$_SESSION[patientid]' and unreadfr = 1 ORDER BY friendid DESC LIMIT 10";
 }
 
 $friendresult = mysqli_query($connect, $query);
 $output = '';
 
 if(mysqli_num_rows($result) > 0)
 {
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
   <li>
    <a href="#">
     <strong>'.$row["comment_subject"].'</strong><br />
     <small><em>'.$row["comment_text"].'</em></small>
    </a>
   </li>
   <li class="divider"></li>
   ';
  }
 }
 else
 {
  $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
 }
 
 $query_1 = "SELECT * FROM comments WHERE comment_status=0";
 $result_1 = mysqli_query($connect, $query_1);
 $count = mysqli_num_rows($result_1);
 $data = array(
  'notification'   => $output,
  'unseen_notification' => $count
 );
 echo json_encode($data);
}
?>