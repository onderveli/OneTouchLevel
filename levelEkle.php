<?php
include ("assets/connection.php");

$addPoint=mysqli_query($baglan,"INSERT INTO levels (name,score,moveNumber,time) VALUE (0,0,0,0)");
$id=mysqli_insert_id($baglan);
echo $id;
?>