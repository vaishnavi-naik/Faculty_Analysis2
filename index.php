<html>
<head>
  <title>Home</title>
  <?php include "./include/headers.html"; ?>
  <link rel="stylesheet" type="text/css" href="css/modal_style.css">
</head>

<body style="background-color: #FFFFF4;">
  <?php  include "./include/navbar.html"; 
  include "./include/connection.php";
  if(isset($_POST['userid'])){
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
      echo "<script> alert('wrong data');
      $('#id01').modal('toggle')</script>";
    }
  }
  ?>


  <div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin-top: 90px;">
    <!-- Indicators -->

    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
    </ol>
    <div class="carousel-inner" role="listbox" style="height: 550px;">
      <div class="item active">
        <img class="first-slide" src="img/1.jpg" alt="sjec" style="height: 600px;width:1400px;">
        
        <div class="container">
          <div class="carousel-caption" >
            <h1 style="text-shadow:3px 3px 5px black;margin-top:-50%;color:#c90219;font-size:80px;">WELCOME TO FACULTY ANALYSIS</h1>
            <p></p>
            <p><a class="btn btn-lg btn-primary" onclick="document.getElementById('id01').style.display = 'block'" style="width:auto;margin-top: 90px;" role="button">LOGIN</a></p>
          </div>
        </div>
      </div>

      <div class="item">
        <img class="second-slide" src="img/teach.jpg" alt="TIARA" style="padding-bottom:10px;height:700px;width:1400px;">
        <div class="container">
          <div class="carousel-caption" style="color:#c90219; ">
            <p style="margin-top: -50%; text-shadow:3px 3px 5px black;font-size:55px;">TEAM WORK IS OUR STRENGTH</p>
          </div>
        </div>
      </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div><!-- /.carousel -->



  


    <!-- START THE FEATURETTES -->
<div>
    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7"style="margin-top: -150px;padding-left: 50px;">
        <h2 class="featurette-heading">TEAM WORK <span class="text-muted"> Know Your Colleagues </span></h2>
        <p class="lead"style="font-size: 28px; text-align: justify;">Teamwork promotes an atmosphere that fosters friendship and loyalty. These close-knit relationships motivate employees in parallel and align them to work harder, cooperate and be supportive of one another. The ability to simultaneously perform as an individual and together with your colleagues or employees in effective teamwork is key to attaining growth and success.</p>
      </div>
      <div class="col-md-5"style="margin-top: -50px;">
        <img class="featurette-image img-responsive center-block" src="img/team.png" alt="Teamwork"  height="550" width="550">
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7 col-md-push-5" style="margin-top: -154px;padding-right: 50px;">
        <h2 class="featurette-heading">Performance Measure<span class="text-muted"> Your Success in Your Hand</span></h2>
        <p class="lead"style="font-size: 28px; text-align: justify;">Self-development is the most important benefit for the employee. Performance appraisal allows you to provide positive feedback as well as identify areas for improvement. It motivates employees when supported by a good merit-based compensation system. The visibility provided by a measurement system supports better and faster development of employees in the organization.</p>
      </div>
      <div class="col-md-5 col-md-pull-7" style="margin-top: -50px;">
        <img class="featurette-image img-responsive center-block" src="img/performance.png" alt="Performace Measure" height="610" width="610" style="/*padding-right:20px;max-width:450px;height:420px;*/">
      </div>
    </div>

    <hr class="featurette-divider">


    <div class="row featurette">
      <div class="col-md-7"style="margin-top: -150px;padding-left: 50px;">
        <h2 class="featurette-heading">Comparative Study<span class="text-muted"> See, Where You Stand</span></h2>
        <p class="lead" style="font-size: 28px; text-align: justify;">If we are perceptive and aware, we’re naturally going to notice those around us and take note of how they are different from us. On the positive end of things, comparison can offer an “information gathering” framework. We may not realize what’s even possible without the model of other people.</p>
      </div>
      <div class="col-md-5"style="margin-top: -50px;">
        <img class="featurette-image img-responsive center-block" src="img/pie.png" alt="Comparative Study"  height="500" width="500">
      </div>
    </div>

    <hr class="featurette-divider">

    <!-- /END THE FEATURETTES -->
  </div>



  <div id="id01" class="modal">

    <form class="modal-content animate" id ="loginform" action="login-submit.php" method="POST">
      <div class="imgcontainer">
        <span onclick="document.getElementById('id01').style.display = 'none'" class="close" title="Close Modal">&times;</span>
        <img src="img/avatar.png" alt="Avatar" class="avatar">
      </div>

      <div class="container">
        
        <label><b>UserType</b></label>
        
        <select name="usertype" class="form-control" >
          <option value="admin"> Admin</option>
          <option value="user"> Staff</option>         
        </select><br>
        
        <label><b>UserId</b></label><br>
        <input type="text" class="form-control" id="userid" placeholder="Enter your Id"><br>
        
        <label><b>Password</b></label>
        <input type="password" class="form-control" id="password" placeholder="Enter your Password"><br>
        <p style="color:red; font-size: 15px; text-align: center;"><?php echo isset($error) ? $error : ""; ?></p>

        <button type="submit" value="submit">Login</button>
        <input type="checkbox" checked="checked"> Remember me
      </div>

      <div class="container" style="background-color:#f1f1f1">
        <button type="button" onclick="document.getElementById('id01').style.display = 'none'" class="cancelbtn">Cancel</button>
        <span class="psw">Forgot <a href="#">password?</a></span>
      </div>
    </form>
  </div>


  <?php
  include "include/footer.html";
  ?>


</body>

<script>
        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }
      </script>


      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      </html>