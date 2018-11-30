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
	// echo $name;
	// echo empty($_FILES["image"]["tmp_name"]);
	if(!empty($_FILES["image"]["tmp_name"])){
		$check = getimagesize($_FILES["image"]["tmp_name"]);
	  	if($check !== false  && in_array(mime_content_type ($_FILES["image"]["tmp_name"]) , array('image/jpeg','image/png','image/gif'))){
			$image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));  
		  	$query = "INSERT INTO user(`user_type`, `name`, `email`, `password`, `dept`, `profile_pic`) VALUES ('$user_type','$name', '$email', '$pass', '$dept', '$image')";  
		    if(mysqli_query($connect, $query) or die(mysqli_error($connect)))  
		    {  
		    	$msg = "Registration Successful!"; 
		    }
		    header('location: admin_dash.php?msg=' . $msg . "#manageDept");	  	
		}else{
			header('location: admin_dash.php?img="Upload an image!#manageDept"');
		}    
	}else{
		echo "<br>null";
		$query = "INSERT INTO user(`user_type`, `name`, `email`, `password`, `dept`) VALUES ('$user_type', '$name', '$email', '$pass', '$dept')";  
	    if(mysqli_query($connect, $query) or die(mysqli_error($connect)))  
	    {  
	    	$msg = "Registration Successful!"; 
	    }else{
	 		$msg = "User not Registered. Try Again!";
	    }
	    header('location: admin_dash.php?msg=' . $msg ."#manageDept" );
	}
	
}  
