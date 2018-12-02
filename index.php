<html>
<head>
  <title>Home</title>
  <?php include "./include/headers.html"; ?>
</head>

<body style="background-color: #FFFFF4;">
  <?php  
  include "./include/connection.php";
  include "./include/navbar.php"; 
  ?>


  <div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin-top: 90px;">
    <!-- Indicators -->

    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
    </ol>
    <div class="carousel-inner" role="listbox" style="height: 550px;">
      <div class="item active">
        <img class="first-slide" src="img/1.jpg" alt="sjec" style="height: 550px;width:1400px;">
        
        <div class="container">
          <div class="carousel-caption" >
            <h1 style="text-shadow:3px 3px 5px black;color:white;font-size:60px;font-family: 'Raleway', sans-serif;font-weight: 600">WELCOME TO FACULTY ANALYSIS</h1>
            <p></p>
            <?php if(isset($_SESSION['email'])){?>
              <p><a class="btn btn-lg btn-primary" href="dashboard_new.php" style="width:auto;margin-top: 50px;margin-bottom: 70px;" role="button">GO TO DASHBOARD</a></p>
            <?php }else{?>
            <p><a class="btn btn-lg btn-primary" href="login.php" style="width:auto;margin-top: 150px;" role="button">LOGIN</a></p>
            <?php }?>
          </div>
        </div>
      </div>

      <div class="item">
        <img class="second-slide" src="img/teach.jpg" alt="TIARA" style="padding-bottom:10px;height:560px;width:1200px;margin-left: 40px;">
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
  <div class="container marketing">
    <hr class="featurette-divider">
    <div class="row featurette">
      <div class="col-md-7" style="margin-top: -150px;padding-left: 50px;">
        <h2 class="featurette-heading">TEAM WORK <span class="text-muted" > Know Your Colleagues </span></h2>
        <p class="lead"style="text-align: justify;">Teamwork promotes an atmosphere that fosters friendship and loyalty. These close-knit relationships motivate employees in parallel and align them to work harder, cooperate and be supportive of one another. The ability to simultaneously perform as an individual and together with your colleagues or employees in effective teamwork is key to attaining growth and success.</p>
      </div>
      <div class="col-md-5"style="margin-top: -50px;">
        <img class="featurette-image img-responsive center-block" src="img/team.png" alt="Teamwork"  height="550" width="550">
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7 col-md-push-5" style="margin-top: -154px;padding-right: 50px;">
        <h2 class="featurette-heading">Performance Measure<span class="text-muted"> Your Success in Your Hand</span></h2>
        <p class="lead"style="text-align: justify;">Self-development is the most important benefit for the employee. Performance appraisal allows you to provide positive feedback as well as identify areas for improvement. It motivates employees when supported by a good merit-based compensation system. The visibility provided by a measurement system supports better and faster development of employees in the organization.</p>
      </div>
      <div class="col-md-5 col-md-pull-7" style="margin-top: -50px;">
        <img class="featurette-image img-responsive center-block" src="img/performance.png" alt="Performace Measure" height="610" width="610" style="/*padding-right:20px;max-width:450px;height:420px;*/">
      </div>
    </div>

    <hr class="featurette-divider">


    <div class="row featurette">
      <div class="col-md-7"style="margin-top: -150px;padding-left: 50px;">
        <h2 class="featurette-heading">Comparative Study<span class="text-muted"> See, Where You Stand</span></h2>
        <p class="lead"style="text-align: justify;" >If we are perceptive and aware, we’re naturally going to notice those around us and take note of how they are different from us. On the positive end of things, comparison can offer an “information gathering” framework. We may not realize what’s even possible without the model of other people.</p>
      </div>
      <div class="col-md-5"style="margin-top: -50px;">
        <img class="featurette-image img-responsive center-block" src="img/pie.png" alt="Comparative Study"  height="500" width="500">
      </div>
    </div>

    <hr class="featurette-divider">

    <!-- /END THE FEATURETTES -->
  </div>

  <?php
  include "include/footer.html";
  ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>