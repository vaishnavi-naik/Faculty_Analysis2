<?php 
include "./include/connection.php";

// echo " email: " . $_POST['Email']. " user type: " .$_POST['usertype'], " Password: " .$_POST['password'];
$email = mysqli_real_escape_string($connect, $_POST['Email']);
$password = (mysqli_real_escape_string($connect, $_POST['password']));
$user_type = mysqli_real_escape_string($connect, $_POST['usertype']);

$query = "SELECT * FROM user WHERE email = '$email' AND password = '$password' AND user_type = '$user_type'";
// echo $query;
$query_result = mysqli_query($connect, $query);
$num = mysqli_num_rows($query_result);
// echo $num;
if ($num == 1) {
    $_SESSION['email'] = $email;
    $array = mysqli_fetch_array($query_result);
    $_SESSION['name'] = $array['name'];
    $_SESSION['type'] = $user_type;
    $_SESSION['id'] = $array['user_id'];
    if($array['profile_pic'] == null)
    	$_SESSION['profile_pic'] = "null";
    else
    	$_SESSION['profile_pic'] = "yes";
    if($user_type == 'admin')
        header('location: admin_dash.php');
    else
        header('location: dashboard.php');
} else {
    $error = "Invalid Username or Password";
    header('location: login.php?error=' . $error);
}
?>