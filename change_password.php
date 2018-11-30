<?php 
include "./include/connection.php";

$user_id = $_SESSION['id'];
$oldPass = (mysqli_real_escape_string($connect, $_POST['oldpassword']));
$newPass= (mysqli_real_escape_string($connect, $_POST['newpassword']));
$newPassConfirm= (mysqli_real_escape_string($connect, $_POST['newpassword1']));

$query1 = "SELECT password FROM user WHERE user_id = $user_id";
echo $query1;
$res = mysqli_query($connect, $query1) or die(mysqli_error($connect));
if(mysqli_num_rows($res) == 1){
	$row = mysqli_fetch_row($res);
	$fetchedPass = $row[0];
	if($fetchedPass == $oldPass){
		$query2 = "UPDATE user SET password = '$newPass' WHERE user_id= $user_id";
		if(mysqli_query($connect, $query2)  or die(mysqli_error($connect))){
			header('location:admin_dash.php?msg="Password Changed Sucessfully!"#changePass');
		}else header('location:admin_dash.php?insertError="Data not Updated"#changePass');
	}else header('location:admin_dash.php?error="Incorrect Current Password entered!"#changePass');
}else header('location:admin_dash.php?passError="Duplicate Entries Found!"#changePass');
?>

