<head>
  <title>Login</title>
  <?php include "include/headers.html"; ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/ValidationFormScript.js"></script>
  <script src="js/bootstrap-show-password.min.js"></script>
</head>
<body>
  <?php include "include/navbar.php" ;
  include "./include/connection.php";

  if(isset($_SESSION['email']))
    header('location:dashboard.php');

  if(isset($_GET['error']))
    echo '<script>$(document).ready(function(){$("#loginError").show();});</script>';
  ?>

  <div class="col-sm-offset-3 col-sm-6 loginPage">
    <center><H1>LOGIN</H1></center>
    <hr style="width:80%;margin-top:10px; margin-left: 70px;" class="hr1">
    <form class="form-horizontal" action="login-submit.php" method= "POST" id="form1">

      <div class="form-group">
        <label for="usertype" class="col-sm-3 control-label">User Type</label>
        <div class="col-sm-7">
          <select name="usertype" class="form-control">
            <option value="admin"> Admin</option>
            <option value="user"> Staff</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="Email">Email</label>
        <div class="col-md-7">
          <div class="input-group"> <span class="input-group-addon"><i class="far fa-envelope"></i></span>
            <input id="mail" name="Email" type="email" placeholder="Enter Your Email" class="form-control input-md">
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label" for="Password">Password</label>
        <div class="col-md-7">
          <div class="input-group"> <span class="input-group-addon"><i class="fas fa-key"></i></span>
            <input id="password" name="password" type="password" placeholder="Enter Your Password" class="form-control input-md">
          </div>
        </div>
      </div>

      <div class="alert alert-danger alert-dismissible collapse col-md-offset-2 col-md-8" role="alert" id="loginError" data-alert="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <center><strong>Sorry!</strong> Invalid Username or Password. Try Again!</center>
      </div>

      <div class="form-group">

        <div class="col-md-offset-5 col-md-4"> 
          <button id="Submit" class="btn btn-lg btn-success" type="submit">Login</button>
        </div>
      </div>    
    </form>
    <script type="text/javascript">

        $("#password").password('toggle');

    </script>


  </div>
</body>
