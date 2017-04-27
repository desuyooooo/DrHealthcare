<?php
    session_start();

    include_once("_database.php");

    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    

$title = "Search";
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
       
  <?php 
    if(isset($_SESSION["type"])){
      include_once("header.php");
    }else{
      include_once("header-guest.php");
    }

    $keyword = $_GET['keyword'];
    $search = mysqli_real_escape_string($con, trim($_GET['keyword']));
    $keys = explode(" ",$search);

    $post_con = "SELECT * FROM `post` WHERE `tag` LIKE '%$search%' OR `posttitle` LIKE '%$search%'";

    $doctor_con = "SELECT doctor.doctorid, CONCAT(doctor.firstname,' ',doctor.lastname) as 'fullname', avg(rating) as rating FROM doctor left join review on doctor.doctorid = review.doctorid WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR CONCAT(firstname,' ',lastname) LIKE '%$search%' OR `email` = '$search'" ;

    foreach($keys as $k)
    { 
      $post_con .= " OR `tag` LIKE '%$k%' OR `posttitle` LIKE '%$k%'";

      $doctor_con .= " OR `firstname` LIKE '%$k%' OR `lastname` LIKE '%$k%' OR CONCAT(`firstname`,' ',`lastname`) LIKE '%$k%' ";

    }

    $find_post = mysqli_query($con, $post_con);

    $find_doctor = mysqli_query($con, $doctor_con." GROUP BY doctor.doctorid ");


  ?>

    <div class="container">

      <h1 class="page-header">Search Result: <?php echo $_GET['keyword'];?></h1>

        <div class="row">
        
          <?php

           //wahahahha  wala  pa

           ?>

           <div class="col-md-9">
              <div class="panel panel-default">
                <div class="panel-body">

                <h2>FORUMS</h2>
                <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Post Title</th>
                  </tr>
                </thead>
              <tbody>
                <?php
                  while($row = mysqli_fetch_assoc($find_post))
                  {
                    $name = $row['posttitle'];
                    $id = $row['postid'];
                    echo "<tr><td><a href='viewpost.php?id=$id'>$name</a></td></tr>";
                  }

                   if ( !mysqli_num_rows($find_post) ) 
                  {
                    echo "<tr><td>There are no results to display.</td></tr>";
                  }

                ?>
                </tbody>
                </table>

                <h2> DOCTORS </h2>
                 <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Doctor name</th>
                      <th>Rating</th>
                  </tr>
                </thead>
              <tbody>
                <?php
                  while($drow = mysqli_fetch_assoc($find_doctor))
                  {
                    $dname = $drow['fullname'];
                    $did = $drow['doctorid'];
                    $rate = $drow['rating'];
                    echo "<tr><td><a href='viewprofile.php?did=$did'>$dname</a></td> <td>".substr($rate, 0, 4)." <i class='fa fa-stethoscope'></i></td></tr>";

                  }
                  if ( !mysqli_num_rows($find_doctor) ) 
                  {
                    echo "<tr><td>There are no results to display.</td></tr>";
                  }

                ?>
                </tbody>
                </table>
                </div>
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