<html>
	<head>
		<title>Registration</title>
		<?php include "./include/headers.html"; ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

	</head>
	<body>
		<?php  include "./include/navbar.html";  
        if(isset($_GET['msg']))
        echo '<script>$(document).ready(function(){$("#regSuccess").show();});</script>';
        if(isset($_GET['img']))
        echo '<script>$(document).ready(function(){$("#regFail").show();});</script>';
        ?>
		<div class="col-md-offset-3 col-md-6 regDiv">
			<h1 style="text-align: center;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REGISTRATION FORM</h1>
            <hr style="width:100%;margin-top:10px; margin-left: 40px;" class="hr1">
			<form class="form-horizontal" action="reg_submit.php" method="post" enctype="multipart/form-data">

				<div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Name</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-7">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="pass" class="col-sm-4 control-label">Password</label>
                    <div class="col-sm-7">
                        <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
                    </div>
                </div>

			  <div class="form-group">
                <label for="dept" class="col-sm-4 control-label">Department</label>
                <div class="col-sm-7">
                    <select name="dept" id="dept" class="form-control">
                        <option value="CSE"> Computer Science and Engineering</option>
                        <option value="CIV"> Civil Engineering</option>
                        <option value="CE"> Chemical Engineering</option>
                        <option value="EEE"> Electronics and Electrical Engineering </option>
                        <option value="ECE"> Electronics and Communication </option>
                        <option value="ISE"> Information Science and Engineering</option>
                        <option value="ME"> Mechanical Engineering</option>
                        <option value="NA"> Not applicable</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="image" class="col-sm-4 control-label" >Upload Image:</label>
                <div class="col-sm-7" style="margin-top: 6px;" >
                    <input type="file" id="image" name="image">
                </div>
            </div>

            
            <div class="alert alert-danger alert-dismissible col-md-offset-1 collapse" role="alert" id ="regFail">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <center><strong>Error!</strong> Upload an image!</center>
            </div>
            <br>
			<button type="submit" name="submit" class="btn btn-primary col-md-offset-5 col-md-4" style="margin-left: center;margin-top: -20px;">Register</button>
           <br>
			</form>
            <div class="alert alert-success alert-dismissible col-md-offset-1 collapse" role="alert" id ="regSuccess">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <center><strong>Success!</strong> Registration Successful. <a href="login.php" class="alert-link">Click here to login.</a></center>
            </div>
		</div>

		<?php
		include "include/footer.html";
		?>
	</body>
</html>
