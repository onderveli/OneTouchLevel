<?php
include ("assets/connection.php");
$pointid=$_POST['id'];
$posX=$_POST['posX'];
$posY=$_POST['posY'];

$updatePoint=mysqli_query($baglan,"UPDATE points SET posX=".$posX.", posY=".$posY." where id=".$pointid);

?>