<?php
include ("assets/connection.php");
$pointid=$_POST['pointID'];

$deletePoint=mysqli_query($baglan,"DELETE FROM points WHERE id=".$pointid);

?>