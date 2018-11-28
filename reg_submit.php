<?php
include "include/connection.php";
$msg="";

if(isset($_POST["submit"]))  
{  
	$name = $_POST["name"];
	$email = $_POST["email"];
	$pass = $_POST["pass"];
	$dept = $_POST["dept"];
	if (!empty($_FILES["image"]["tmp_name"])){
		$check = getimagesize($_FILES["image"]["tmp_name"]);
	  	if($check !== false  && in_array(mime_content_type ($_FILES["image"]["tmp_name"]) , array('image/jpeg','image/png','image/gif'))){
			$image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));  
		  	$query = "INSERT INTO user(name, email, password, dept, profile_pic) VALUES ('$name', '$email', '$pass', '$dept', '$image')";  
		    if(mysqli_query($connect, $query) or die(mysqli_error($connect)))  
		    {  
		    	$msg = "Registration Successful!"; 
		    }
		    header('location: register.php?msg=' . $msg);	  	
		}else{
			header('location: register.php?img="Upload an image!"');
		}    
	}else{
		$query = "INSERT INTO user(name, email, password, dept) VALUES ('$name', '$email', '$pass', '$dept')";  
	    if(mysqli_query($connect, $query) or die(mysqli_error($connect)))  
	    {  
	    	$msg = "Registration Successful!"; 
	    }else{
	 		$msg = "User not Registered. Try Again!";
	    }
	    header('location: register.php?msg=' . $msg);
	}
	
}  
