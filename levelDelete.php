<?php
include ("assets/connection.php");
$levelid=$_POST['levelID'];

$deletePoint=mysqli_query($baglan,"DELETE FROM points WHERE levelid=".$levelid);
$deleteLevel=mysqli_query($baglan,"DELETE FROM levels WHERE id=".$levelid);

?>