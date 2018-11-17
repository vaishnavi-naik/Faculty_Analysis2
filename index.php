<html>
<head>
  <title>Home</title>
  <?php include "./include/headers.html"; ?>
  <link rel="stylesheet" type="text/css" href="css/modal_style.css">
</head>

<body style="background-color: #FFFFF4;">
  <?php  include "./include/navbar.html";  ?>


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

 <div class="container marketing"style ="margin-top: 2%;">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img class="img-circle" src="img/hod.jpg" alt="Generic placeholder image" width="140" height="140">
          <h2>Dr SRIDEVI SARALAYA</h2>
          <p><h3>HOD and Assistant Professor</h3></p>
          <p><a class="btn btn-default" href="cse_events.html" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="img/principal.jpg" alt="Generic placeholder image" width="140" height="140">
          <h2>Dr RIO D'SOUZA</h2>
          <p><h3>Principal</h3></p>
          <p><a class="btn btn-default" href="ece_events.html" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="img/kavitha.jpg" alt="Generic placeholder image" width="140" height="140">
          <h2>Dr Kavitha</h2>
          <p><h3>Assistant Professor</h3></p>
          <p><a class="btn btn-default" href="eee_events.html" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->


      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">TEAM WORK <span class="text-muted"> Know Your Colleagues </span></h2>
          <p class="lead">Teamwork promotes an atmosphere that fosters friendship and loyalty. These close-knit relationships motivate employees in parallel and align them to work harder, cooperate and be supportive of one another. The ability to simultaneously perform as an individual and together with your colleagues or employees in effective teamwork is key to attaining growth and success.</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive center-block" src="img/team.png" alt="Teamwork"  height="500" width="500">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7 col-md-push-5">
          <h2 class="featurette-heading">Performance Measure<span class="text-muted"> Your Success in Your Hand</span></h2>
          <p class="lead">Self-development is the most important benefit for the employee. Performance appraisal allows you to provide positive feedback as well as identify areas for improvement. It motivates employees when supported by a good merit-based compensation system. The visibility provided by a measurement system supports better and faster development of employees in the organization.</p>
        </div>
        <div class="col-md-5 col-md-pull-7">
          <img class="featurette-image img-responsive center-block" src="img/performance.png" alt="Performace Measure" height="600" width="600" style="/*padding-right:20px;max-width:450px;height:420px;*/">
        </div>
      </div>

      <hr class="featurette-divider">


      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Comparative Study<span class="text-muted"> See, Where You Stand</span></h2>
          <p class="lead">If we are perceptive and aware, we’re naturally going to notice those around us and take note of how they are different from us. On the positive end of things, comparison can offer an “information gathering” framework. We may not realize what’s even possible without the model of other people.</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive center-block" src="img/pie.png" alt="Comparative Study"  height="500" width="500">
        </div>
      </div>

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->
 </div>
    <div id="id01" class="modal">

        <form class="modal-content animate" action="adminpage.php">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display = 'none'" class="close" title="Close Modal">&times;</span>
                <img src="img/avatar.png" alt="Avatar" class="avatar">
            </div>

            <div class="container">
            <div>
              <label><b>UserType</b></label>
              
          <select name="usertype" class="form-control" >
            <option value="admin"> Admin</option>
            <option value="staff"> Staff</option>
          
          </select><br>
            </div>
            <label><b>UserId</b></label><br>
           <input type="text" class="form-control" id="userid" placeholder="Enter your Id"><br>
       
        <label><b>Password</b></label>
          <input type="password" class="form-control" id="password" placeholder="Enter your Password"><br>
         

                <button type="submit">Login</button>
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