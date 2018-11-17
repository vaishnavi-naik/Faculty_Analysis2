<?php 
include "./include/connection.php";
// if(isset($_POST['email']))
// 	echo "YES";
// else echo "no";
echo " email:" . $_POST['email']. "user type" .$_POST['usertype'];
$email = mysqli_real_escape_string($connect, $_POST['email']);
$password = (mysqli_real_escape_string($connect, $_POST['password']));
$user_type = mysqli_real_escape_string($connect, $_POST['usertype']);

$query = "SELECT * FROM user WHERE email = $email AND password = $password AND user_type = $user_type";

$query_result = mysqli_query($connect, $query);
$num = mysqli_num_rows($query_result);

if ($num == 1) {
    $_SESSION['email'] = $email;
    $array = mysqli_fetch_array($query_result);
    $_SESSION['name'] = $array['name'];
    $_SESSION['type'] = $user_type;
    $_SESSION['id'] = $array['user_id'];
    header('location: admin_options');
} else {
    $error = "Invalid Username or Password";
    header('location: admin-login.php?error=' . $error);
}
?>