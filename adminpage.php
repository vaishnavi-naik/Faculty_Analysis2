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
	array("y" => 8.9, "label" => "Sem Results" ),
	array("y" => 6.5, "label" => "Publications" ),
	array("y" => 5.9, "label" => "Extra Curriculum" ),
	array("y" => 8.0, "label" => "Research" ),
	array("y" => 9.8, "label" => "Attendance" ),
	array("y" => 8.5, "label" => "Student Rating" )
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

  <script src="canvas/jquery.canvasjs.min.js"></script>


<script>




window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Your Earning For This Sem"
	},
	axisY: {
		title: "Your Credits"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.##",
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



var chart2 = new CanvasJS.Chart("chartContainer2", {
  animationEnabled: true,
  title:{
    text: "DID YOU IMPROVE YOURSELF?"
  },  
  axisY: {
    title: "What You Have Earned",
    titleFontColor: "#4F81BC",
    lineColor: "#4F81BC",
    labelFontColor: "#4F81BC",
    tickColor: "#4F81BC"
  },
 
  toolTip: {
    shared: true
  },
  legend: {
    cursor:"pointer",
    itemclick: toggleDataSeries
  },
  data: [{
    type: "column",
    name: "Previous Sem Performance",
    legendText: "Previous Sem Performance",
    showInLegend: true, 
    dataPoints:[
      { label: "Sem Results", y: 8.5 },
      { label: "Publications", y: 7.0 },
      { label: "Extra Curriculum", y: 9.0 },
      { label: "Research", y: 5.0 },
      { label: "Attendance", y: 10.0 },
      { label: "Student Rating", y: 9.0 }
    ]
  },
  {
    type: "column", 
    name: "This Sem Performance",
    legendText: "This Sem Performance",
    axisYType: "secondary",
    showInLegend: true,
    dataPoints:[
      { label: "Sem Results", y: 9.5},
      { label: "Publications", y: 8.0 },
      { label: "Extra Curriculum", y: 6.0 },
      { label: "Research", y: 4.5 },
      { label: "Attendance", y: 9.0 },
      { label: "Student Rating", y: 8.5 }
    ]
  }]
});
chart2.render();

function toggleDataSeries(e) {
  if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    e.dataSeries.visible = false;
  }
  else {
    e.dataSeries.visible = true;
  }
  chart2.render();
}


var chart3 = new CanvasJS.Chart("chartContainer3", {
  animationEnabled: true,
  title:{
    text: "SEE, WHERE DO YOU STAND."
  },
  axisY: {
    title: "CREDITS"
  },
  legend: {
    cursor:"pointer",
    itemclick : toggleDataSeries
  },
  toolTip: {
    shared: true,
    content: toolTipFormatter
  },
  data: [{
    type: "bar",
    showInLegend: true,
    name: "Institute Topper",
    color: "gold",
    dataPoints: [
      { y: 9.5, label: "Student Rating" },
      { y: 8.0, label: "Research" },
      { y: 10.0, label: "Attendance" },
      { y: 9.0, label: "Extra Curriculum" },
      { y: 6.0, label: "Publications" },
      { y: 10.0, label: "Sem Results" }
      ]
  },
  {
    type: "bar",
    showInLegend: true,
    name: "Department Topper",
    color: "silver",
    dataPoints: [
      { y: 7.5, label: "Student Rating" },
      { y: 7.0, label: "Research" },
      { y: 9.0, label: "Attendance" },
      { y: 8.5, label: "Extra Curriculum" },
      { y: 6.0, label: "Publications" },
      { y: 10.0, label: "Sem Results" }
    ]
  },
  {
    type: "bar",
    showInLegend: true,
    name: "Your Performance",
    color: "#A57164",
    dataPoints: [
      { y: 7.0, label: "Student Rating" },
      { y: 6.0, label: "Research" },
      { y: 8.5, label: "Attendance" },
      { y: 8.5, label: "Extra Curriculum" },
      { y: 5.0, label: "Publications" },
      { y: 9.0, label: "Sem Results" }
    ]
  }

  ]
});
chart3.render();

function toolTipFormatter(e) {
  var str = "";
  var total = 0 ;
  var str3;
  var str2 ;
  for (var i = 0; i < e.entries.length; i++){
    var str1 = "<span style= \"color:"+e.entries[i].dataSeries.color + "\">" + e.entries[i].dataSeries.name + "</span>: <strong>"+  e.entries[i].dataPoint.y + "</strong> <br/>" ;
    total = e.entries[i].dataPoint.y + total;
    str = str.concat(str1);
  }
  str2 = "<strong>" + e.entries[0].dataPoint.label + "</strong> <br/>";
  str3 = "<span style = \"color:Tomato\">Total: </span><strong>" + total + "</strong><br/>";
  return (str2.concat(str)).concat(str3);
}

function toggleDataSeries(e) {
  if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    e.dataSeries.visible = false;
  }
  else {
    e.dataSeries.visible = true;
  }
  chart3.render();
}


 
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
		 <img class="first-slide" src="img/teachers.jpg" alt="sjec" height="550px" width="100%">
         
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



<center><input class="btn btn-lg btn-primary" type ="button" value="Register"/></center>

</form>

 </div>

</div>
 <hr>
<div style=" position: relative;">
  <h4 id="list-item-2">VIEW FACULTY</h4>
  <p>..is anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident o reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.</p>
</div>

 <h4 id="list-item-3">ADD PERFORMANCE</h4>
 <p>..is anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat exceptt culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor repqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.</p>



 <h4 id="list-item-4">VIEW PERFORMANCE</h4>

 <div id="chartContainer1" style="height: 530px; width: 100%;"></div>

<div id="chartContainer" style="height: 530px; width: 100%;"></div>

<div id="chartContainer2" style="height: 530px; width: 100%;"></div>
<div id="chartContainer3" style="height: 530px; width: 90%;"></div>

</div>
