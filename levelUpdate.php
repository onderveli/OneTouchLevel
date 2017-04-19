<?php
include ("assets/connection.php");
$id=$_POST['id'];
$name=$_POST['name'];
$time=$_POST['time'];
$score=$_POST['score'];
$moveNumber=$_POST['moveNumber'];

$updatePoint=mysqli_query($baglan,"UPDATE levels SET name=".$name.", moveNumber=".$moveNumber.", score=".$score.", time=".$time." where id=".$id);

?>