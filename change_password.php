<?php 
include "./include/connection.php";

echo "<h1>Hello</h1>";
$oldpass = (mysqli_real_escape_string($connect, $_POST['oldpassword']));
$newpass= (mysqli_real_escape_string($connect, $_POST['newpassword']));

echo $oldpass." ".$newpass;
?>