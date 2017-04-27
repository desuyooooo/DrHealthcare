<div class="col-md-3">
            <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Trending Tags</h3>
            </div>
            <div class="panel-body">
            <ul class="list-unstyled">
<?php 
include("_database.php");

$tags = mysqli_query($con, "SELECT * FROM tags ORDER BY tagcount desc LIMIT 6");
$t = 30;
while ($tag = mysqli_fetch_array($tags)){
  echo '<span style="font-size:'.$t.'px;"><li><a href="?tag='.$tag['tag'].'" title="'.$tag['tag'].'">#'.$tag['tag'].'</a></li></span>';
  $t-=3;
}
?>
               </ul>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Categories</h3>
            </div>
            <div class="panel-body">
            <ul class="list-unstyled">
<?php 

$cat = mysqli_query($con, "SELECT * FROM category ORDER BY catname asc");

while ($row = mysqli_fetch_array($cat)){
  echo '<li><a href="?id='.$row['catid'].'" title="'.$row['catdesc'].'">'.$row['catname'].'</a></li>';
}
?>
               </ul>
            </div>
          </div>


          </div>