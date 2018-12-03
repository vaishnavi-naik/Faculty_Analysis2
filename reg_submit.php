<?php
include "include/connection.php";
$msg="";

if(isset($_POST["submit"]))  
{  
	$name = $_POST["name"];
	$email = $_POST["email"];
	$pass = $_POST["pass"];
	$dept = $_POST["dept"];
	$user_type=$_POST["utype"];

	$sql = "SELECT email FROM user WHERE email = '$email'";
	$res = mysqli_query($connect, $sql);
	if(mysqli_num_rows($res)>0)
		if($user_type == 'User')
			header("location:admin_dash.php?userError=Email already registered. Try a Different Email.#addFaculty");
		else 
			header("location:admin_dash.php?adminError=Email already registered. Try a Different Email.#addAdmin");
	if(!empty($_FILES["image"]["tmp_name"])){
		$check = getimagesize($_FILES["image"]["tmp_name"]);
	  	if($check !== false  && in_array(mime_content_type ($_FILES["image"]["tmp_name"]) , array('image/jpeg','image/png','image/gif'))){
			$image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));  
		  	$query = "INSERT INTO user(`user_type`, `name`, `email`, `password`, `dept`, `profile_pic`) VALUES ('$user_type','$name', '$email', '$pass', '$dept', '$image')";  
		    if(mysqli_query($connect, $query) or die(mysqli_error($connect)))  
		    {  
		    	$msg = "Registration Successful!"; 
		    }
		}else{
			if($user_type == 'User')
				header('location:admin_dash.php?userError="Upload an image!"#addFaculty');
			else 
				header('location:admin_dash.php?adminError="Upload an image!"#addAdmin');
		}    
	}else{
		$query = "INSERT INTO user(`user_type`, `name`, `email`, `password`, `dept`) VALUES ('$user_type', '$name', '$email', '$pass', '$dept')";  
	    if(mysqli_query($connect, $query) or die(mysqli_error($connect)))  
	    {  
	    	$msg = "Registration Successful!"; 

	    }
	}
	if($user_type == 'User')
		header('location:admin_dash.php?userSuccess="' . $msg . '"#addFaculty');
	else 
		header('location:admin_dash.php?adminSuccess="' . $msg . '"#addAdmin');
}  
