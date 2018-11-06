<?php
include "include/navbar.html"
?>

<?php
 
$dataPoints1 = array( 
	array("label"=>"Chrome", "y"=>64.02),
	array("label"=>"Firefox", "y"=>12.55),
	array("label"=>"IE", "y"=>8.47),
	array("label"=>"Safari", "y"=>6.08),
	array("label"=>"Edge", "y"=>4.29),
	array("label"=>"Others", "y"=>4.59)
)
 
?>

<?php

$dataPoints = array( 
	array("y" => 3373.64, "label" => "Germany" ),
	array("y" => 2435.94, "label" => "France" ),
	array("y" => 1842.55, "label" => "China" ),
	array("y" => 1828.55, "label" => "Russia" ),
	array("y" => 1039.99, "label" => "Switzerland" ),
	array("y" => 765.215, "label" => "Japan" ),
	array("y" => 612.453, "label" => "Netherlands" )
);
 
?>
<style type="text/css">
    .wrapper { 
    
  height:550px;
  width: 100%;
  left:0;
  right: 0;
  top: 0;
  bottom: 0;
  position: relative;
background: linear-gradient(124deg, #ff2400, #e81d1d, #e8b71d, #e3e81d, #1de840, #1ddde8, #2b1de8, #dd00f3, #dd00f3);
background-size: 1500% 1500%;

-webkit-animation: rainbow 18s ease infinite;
-z-animation: rainbow 18s ease infinite;
-o-animation: rainbow 18s ease infinite;
  animation: rainbow 18s ease infinite;}

@-webkit-keyframes rainbow {
    0%{background-position:0% 82%}
    50%{background-position:100% 19%}
    100%{background-position:0% 82%}
}
@-moz-keyframes rainbow {
    0%{background-position:0% 82%}
    50%{background-position:100% 19%}
    100%{background-position:0% 82%}
}
@-o-keyframes rainbow {
    0%{background-position:0% 82%}
    50%{background-position:100% 19%}
    100%{background-position:0% 82%}
}
@keyframes rainbow { 
    0%{background-position:0% 82%}
    50%{background-position:100% 19%}
    100%{background-position:0% 82%}
}
  </style>

  <link rel = "stylesheet" href = "css/bootstrap.min.css"/>
  <link rel = "stylesheet" href = "css/mycss.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Gold Reserves"
	},
	axisY: {
		title: "Gold Reserves (in tonnes)"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## tonnes",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();


var chart1 = new CanvasJS.Chart("chartContainer1", {
	animationEnabled: true,
	title: {
		text: "Usage Share of Desktop Browsers"
	},
	subtitles: [{
		text: "November 2017"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
	}]
});
chart1.render();
 
}


</script>


<div  style="width:15%;background-color: #874914;margin-left: 2px; float: left; margin-top: 85px;">

<div id="list-example" class="list-group" style="height: auto;" >

  <a  class="btn btn-primary  btn-block" style="height: 80px;margin-bottom: 30px;margin-top: 20px;padding-top: 30px;" href="#list-item-1">ADD FACULTY</a>
  <a  class="btn btn-primary  btn-block"style="height: 80px;margin-bottom: 30px;padding-top: 30px;" href="#list-item-2">VIEW FACULTY</a>
  <a  class="btn btn-primary  btn-block"style="height: 80px;margin-bottom:30px;padding-top: 30px;" href="#list-item-3">ADD PERFORMANCE</a>
  <a  class="btn btn-primary  btn-block"style="height: 80px;margin-bottom: 30px;padding-top: 30px;" href="#list-item-4">VIEW PERFORMANCE</a>
  <a  class="btn btn-primary  btn-block"style="height: 80px;padding-top: 30px;" href="index.php">LOGOUT</a>
</div>

</div>




<div data-spy="scroll" data-target="#list-example" data-offset="0" class="scrollspy-example"style="margin-left:  16%;margin-top: -550px; overflow-y: scroll; position:relative;">

	<div>
		 <img class="first-slide" src="img/1.jpg" alt="sjec" height="550px" width="100%">
         
	</div>

	<div style="padding-top: 30px;">

  <h4 id="list-item-1">ADD FACULTY</h4>

 <div class="wrapper">

 	<form class="form-horizontal" action = "#" method= "GET">
    <div class="form-group">
      <label for="fname" class="col-sm-4 control-label">Full Name</label>
      <div class="col-sm-7">
        <input type="text" class="form-control" id="fname" placeholder="Enter your first name">
      </div>
    </div>
   
    <div class="form-group">
      <label for="coll" class="col-sm-4 control-label">College</label>
      <div class="col-sm-7">
        <input type="text" class="form-control" id="coll" placeholder="Enter your College name">
      </div>
    </div>

    <div class="form-group">
      <label for="email" class="col-sm-4 control-label">Email</label>
      <div class="col-sm-7">
        <input type="email" class="form-control" id="email" placeholder="Email">
      </div>
    </div>
    <div class="form-group">
      <label for="phone" class="col-sm-4 control-label">Mobile Number</label>
      <div class="col-sm-7">
        <input type="tel" class="form-control" id="phone" placeholder="Mobile Number">
      </div>
    </div>



    <div class="form-group">
        <label for="male" class="col-sm-4 control-label">Gender</label>
        <div class="col-sm-4 radio">
          <input type="radio" value="Male" name="male">Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" value="Female" name="male"/>Female
        </div>
      </br></br>
    </div>

  <div class="form-group">
    <label for="date" class="col-sm-4 control-label">Date Of Birth</label>
    <div class="col-sm-7">
      <input type="date"  class="form-control" id="date"name="date"/>
    </div>
  </div>


<div class="form-group">
    <label for="course" class="col-sm-4 control-label">Course</label>
    <div class="col-sm-7">
      <select name="course" class="form-control">
         <option>B.E / B.Tech</option>
         <option>MCA</option>
         <option>MBA</option>
       </select>
    </div>
  </div>

<div class="form-group">
    <label for="dept" class="col-sm-4 control-label">Department</label>
    <div class="col-sm-7">
      <select name="dept" class="form-control">
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
    <label for="year" class="col-sm-4 control-label">Year</label>
    <div class="col-sm-7">
      <select name="year" class="form-control">
       <option value="1"> 1</option>
       <option value="2"> 2</option>
       <option value="3"> 3</option>
       <option value="4"> 4</option>
      </select>
    </div>
  </div>

<div class="form-group">
  <label for="event" class="col-sm-4 control-label">Event</label>
  <div class="col-sm-7">
    <select name="event" class="form-control">
     <optgroup label="CSE">
     <option  value="codebuzz"> CodeBuzz</option>
     <option value="techroadies"> TechRoadies</option>
     <option value="robowars"> Robo-wars</option>
     <option value="technovanza"> Technovanza</option>
     <option value="rushhour"> Rush Hour</option>
     <option value="mindspark"> Mindspark</option>
     <option value="coderunner"> CodeRunner</option>
     <option value="digihunt"> DigiHunt</option>
     </optgroup>
     <optgroup label="ECE">
     <option value="ece1">ECE Event 1</option>
     <option value="ece2">ECE Event 2</option>
     <option value="ece3">ECE Event 3</option>
     <option value="ece4">ECE Event 4</option>
     </optgroup>
     <optgroup label="EEE">
     <option value="eee1">EEE Event 1</option>
     <option value="eee2">EEE Event 2</option>
     <option value="eee3">EEE Event 3</option>
     <option value="eee4">EEE Event 4</option>
     </optgroup>
    </select>
  </div>
</div>

<center><input class="btn btn-lg btn-primary" type ="button" value="Register"/></center>

</form>

 </div>

</div>
 <hr>
<div style=" position: relative;">
  <h4 id="list-item-2">VIEW FACULTY</h4>
  <p>..is anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.</p>
</div>

 <h4 id="list-item-3">ADD PERFORMANCE</h4>
 <p>..is anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.</p>



 <h4 id="list-item-4">VIEW PERFORMANCE</h4>

 <div id="chartContainer1" style="height: 500px; width: 100%;"></div>

<div id="chartContainer" style="height: 500px; width: 100%;"></div>

</div>
