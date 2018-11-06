<html>
<head>
  <title>Faculty Performance</title>
  <?php include "./include/headers.html"; ?>
  <link rel="stylesheet" type="text/css" href="css/modal_style.css">
</head>
<body>
  <?php  include "./include/navbar.html";  ?>
  <div id="myCarousel" class="carousel slide" data-ride="carousel" style ="height:100%">
    <!-- Indicators -->

    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img class="first-slide" src="img/1.jpg" alt="sjec">
        <img  height="500px" width="1400px">
        <div class="container">
          <div class="carousel-caption">
            <h1>WELCOME TO FACULTY ANALYSIS</h1>
            <p></p>
            <p><a class="btn btn-lg btn-primary" onclick="document.getElementById('id01').style.display = 'block'" style="width:auto;" role="button">LOGIN</a></p>
          </div>
        </div>
      </div>

      <div class="item">
        <img class="second-slide" src="img/tiara.png" alt="TIARA" style="padding-bottom:10px;height:300px;width:300px;">
        <div class="container">
          <div class="carousel-caption" style="color:#595858;font-size:20px;">
            <h1></h1>
            <p >TIARA is a national level fest organised annually at St Joseph Engineering College, Mangaluru</p>
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
  </div>

  <div class="container marketing">

    <!-- Three columns of text below the carousel -->
    <div class="row">
      <div class="col-lg-4">
        <img class="img-circle" src="img/cse1.png" alt="Generic placeholder image" width="140" height="140">
        <h2>Comupter Science</h2>
        <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
        <p><a class="btn btn-default" href="cse_events.html" role="button">View details &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4">
        <img class="img-circle" src="img/ece1.jpg" alt="Generic placeholder image" width="140" height="140">
        <h2>Electronics and Communations</h2>
        <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.</p>
        <p><a class="btn btn-default" href="ece_events.html" role="button">View details &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4">
        <img class="img-circle" src="img/eee1.jpg" alt="Generic placeholder image" width="140" height="140">
        <h2>Electrical and Electronics</h2>
        <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p><a class="btn btn-default" href="eee_events.html" role="button">View details &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->


    <!-- START THE FEATURETTES -->

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">TEAM WORK <span class="text-muted"> Know Your Collegues </span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>
      <div class="col-md-5">
        <img class="featurette-image img-responsive center-block" src="img/teamwork1.jpg" alt="CSE">
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7 col-md-push-5">
        <h2 class="featurette-heading">Performance Measure<span class="text-muted"> Your Success in Your Hand</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>
      <div class="col-md-5 col-md-pull-7">
        <img class="featurette-image img-responsive center-block" src="img/performance.png" alt="Generic placeholder image">
      </div>
    </div>

    <hr class="featurette-divider">


    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">Comparative Study<span class="text-muted"> See,Where Dou You Stand</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>
      <div class="col-md-5">
        <img class="featurette-image img-responsive center-block" src="img/barchart.png" alt="Generic placeholder image">
      </div>
    </div>

    <hr class="featurette-divider">

    <!-- /END THE FEATURETTES -->
  </div>
  <div id="id01" class="modal">

    <form class="modal-content animate" action="adminpage.php">
      <div class="imgcontainer">
        <span onclick="document.getElementById('id01').style.display = 'none'" class="close" title="Close Modal">&times;</span>
        <img src="img_avatar2.png" alt="Avatar" class="avatar">
      </div>

      <div class="container">
        <div>
         <label><b>UserType</b></label>

         <select name="usertype" class="form-control" >
           <option value="admin"> Admin</option>
           <option value="staff"> Staff</option>
           <option value="staff"> Student</option>
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
include "include/footer.html"
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