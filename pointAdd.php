<?php
include ("assets/connection.php");
$levelid=$_POST['levelid'];

$addPoint=mysqli_query($baglan,"INSERT INTO points (levelid,posX,posY) VALUE (".$levelid.",15,15)");
$id=mysqli_insert_id($baglan);
echo $id;
?>