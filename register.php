<html>
	<head>
		<title>Registration</title>
		<?php include "./include/headers.html"; ?>
		<link rel="stylesheet" type="text/css" href="css/modal_style.css">
	</head>
	<body>
		<?php  include "./include/navbar.html";  ?>
		<div class="col-md-offset-3 col-md-6 regDiv">
			<h1 style="text-align: center;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REGISTRATION FORM</h1>
            <hr style="width:100%;margin-top:10px; margin-left: 40px;" class="hr1">
			<form class="form-horizontal" action="reg_submit.php" method="post" enctype="multipart/form-data">

				<div class="form-group">
                    <label for="name" class="col-sm-4 control-label" style="padding-top: 15px;">Name</label>
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
                    <label for="pass" class="col-sm-4 control-label"  style="padding-top: 15px;">Password</label>
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
			  
			<p style="color:red; font-size: 15px;"><?php echo isset($_GET['img']) ? $_GET['img'] : ""; ?></p><br>
			<button type="submit" name="submit" class="btn btn-primary col-md-offset-5 col-md-4" style="margin-left: center;margin-top: -20px;">Register</button>
			<br><br><p style="color:green; font-size: 25px; text-align: center;"><?php echo isset($_GET['msg']) ? $_GET['msg'] : ""; ?></p>
			</form>
		</div>

		<?php
		include "include/footer.html";
		?>
	</body>
</html>
