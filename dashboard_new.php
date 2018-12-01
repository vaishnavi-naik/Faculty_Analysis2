<?php
header('Content-Type: text/html; charset=utf-8');
require('include/connection.php');


if(!isset($_SESSION['email'])){
    header('location:login.php');
}
if($_SESSION['type'] == 'Admin' )
    header('location:admin_dash.php');

$GLOBALS['semVal'] = 'even';

require('./vendor/autoload.php');

function chartLine($xAxisData, $seriesData, $title = '')
{
    $chart = new Hisune\EchartsPHP\ECharts();
    $xAxis = new Hisune\EchartsPHP\Doc\IDE\XAxis();
    $yAxis = new Hisune\EchartsPHP\Doc\IDE\YAxis();

    $color = [ 
            '#c23531','#2f4554', '#61a0a8', '#d48265', 
            '#bda29a','#6e7074', '#546570', '#00ff00',
            '#ca8622', '#ff0000','#bda29a','#ff69b4','#ba55d3','#cd5c5c','#ffa500','#40e0d0',
           '#ff7f50','#87cefa','#da70d6','#32cd32','#6495ed','#FB0065','#FCFF00','#00ECFF'
        ];
    shuffle($color);
    shuffle($color);

    $title && $chart->title->text = $title;
    $chart->color = $color;
    $chart->tooltip->trigger = 'axis';
    $chart->toolbox->show = true;
    $chart->toolbox->feature->dataView->show = false;
    $chart->toolbox->feature->magicType->type = ['line', 'bar', 'stack', 'tiled'];
    $chart->toolbox->feature->magicType->title->line = 'Line Chart';
    $chart->toolbox->feature->magicType->title->bar = 'Bar Chart';
    $chart->toolbox->feature->magicType->title->stack = 'Stacked View';
    $chart->toolbox->feature->magicType->title->tiled = 'Tiled View';
    $chart->toolbox->feature->saveAsImage->name = 'My Credits';
    $chart->toolbox->feature->saveAsImage->title = 'Save';
    
    $yAxis->type = 'value';
    $xAxis->type = 'category';
    $xAxis->boundaryGap = false;
    $xAxis->data = $xAxisData;

    foreach($seriesData as $ser){
        $chart->legend->data[] = $ser['name'];
        $series = new \Hisune\EchartsPHP\Doc\IDE\Series();
        $series->name = $ser['name'];
        $series->type = isset($ser['type']) ? $ser['type'] : 'line';
        $series->data = $ser['data'];
        $chart->addSeries($series);
    }

    $chart->addXAxis($xAxis);
    $chart->addYAxis($yAxis);

    $chart->initOptions->renderer = 'canvas';
    //$chart->width = '800px';

    return $chart->render(uniqid());
}
?>
<?php
$connect = mysqli_connect("localhost", "root", "", "faculty");
$user_id= $_SESSION['id'];




function GET_COLLEGE_TOPPER($USER_ID)
{
$YEAR= GETYEAR($USER_ID);
$YEAR = max($YEAR[0]);
$connect = mysqli_connect("localhost", "root", "", "faculty");

$query="SELECT user_id FROM performance where year = '$YEAR' and total_credits=(SELECT max(total_credits) FROM performance where year = '$YEAR') ";

$topper=mysqli_query($connect, $query);  
$num = mysqli_num_rows($topper);
if ($num >= 1)
{
$row = mysqli_fetch_row($topper);

$topper_id=$row[0];
return $topper_id;
}

else{
return 'no data';
}
}

function GET_DEPT_TOPPER()
{

$def = ['2014-19','2017-18'];
$connect = mysqli_connect("localhost", "root", "", "faculty");
$user_id= $_SESSION['id'];

$query="SELECT DISTINCT year FROM performance where user_id = '$user_id' order by year desc ";

$year=mysqli_query($connect, $query);  
$num = mysqli_num_rows($year);
if ($num >= 1)
{
while($row = $year->fetch_row())
{
 $rows[]=$row;
}
return $rows;
}

else{
return  $def;
}
}

// function GETSEM($USER_ID)
// {
// $connect = mysqli_connect("localhost", "root", "", "faculty");

// $YEAR1= GETYEAR($USER_ID);
// $YEAR=$YEAR1[0][0];

// $query = "SELECT min(sem) FROM performance WHERE user_id = '$USER_ID' and year='$YEAR'" ;

// if((mysqli_query($connect, $query) ) or die(mysqli_error($connect)))
// {  
//         $res=mysqli_query($connect, $query); 
//         $row = mysqli_fetch_row($res);
       
//         $num = mysqli_num_rows($res);

//         if($num==0)
//         {
//            return 'no sem';
//         }

//         else
//         {
//             return $row;
//         }



    
// }
// }


function GETYEAR($USER_ID)
{

$def = ['2014-19','2017-18'];
$connect = mysqli_connect("localhost", "root", "", "faculty");
;

$query="SELECT DISTINCT year FROM performance where user_id = '$USER_ID' order by year desc ";

$year=mysqli_query($connect, $query);  
$num = mysqli_num_rows($year);
if ($num >= 1)
{
while($row = $year->fetch_row())
{
 $rows[]=$row;
}
return $rows;
}

else{
return  $def;
}
}

function YEARSUM($YEAR,$USER_ID)
{

$TOTALODD=MYPOINTS($YEAR,'odd',$USER_ID);
$TOTALEVEN=MYPOINTS($YEAR,'even',$USER_ID);
for ($i=0;$i<count($TOTALODD);$i++)
{
$TOTALYEAR[$i]=round(($TOTALODD[$i]+$TOTALEVEN[$i])/2.0, 2);
}

return $TOTALYEAR;


}


function MYPOINTS($YEAR,$SEM,$USER_ID){
$connect = mysqli_connect("localhost", "root", "", "faculty");

$MYPOINTS_EVEN= array(0.0,0.0,0.0,0.0,0.0,0.0,0.0);
$MYPOINTS_ODD= array(0.0,0.0,0.0,0.0,0.0,0.0,0.0);

$query = "SELECT DISTINCT academic_id,student_id FROM performance WHERE user_id = '$USER_ID' and year='$YEAR' and sem='$SEM'" ;

if((mysqli_query($connect, $query) ) or die(mysqli_error($connect)))
{  
        $res=mysqli_query($connect, $query); 
        $row = mysqli_fetch_row($res);
        
        $academic_id=$row[0];
        $stud_id=$row[1];


        $query1 = "SELECT * FROM `academic_performance` WHERE academic_id='$academic_id'" ;
        $academic=mysqli_query($connect, $query1); 
        $ad = mysqli_fetch_row($academic);
        $num = mysqli_num_rows($academic);

        $query2 = "SELECT * FROM `student_performance` WHERE student_id='$stud_id'" ;
        $student=mysqli_query($connect, $query2); 
        $sd = mysqli_fetch_row($student);
        $num1 = mysqli_num_rows($student);


        if($num==0)
        {
            $ad = array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0);
        }

        if($num1==0)
        {
            $sd = array(0.0,0.0,0.0,0.0,0.0,0.0);
        }
        
        
        $MYPOINTS_SEM[0]=$ad[4];
        $MYPOINTS_SEM[1]=$ad[2];
        $MYPOINTS_SEM[2]=$ad[8];
        $MYPOINTS_SEM[3]=$ad[6];
        $MYPOINTS_SEM[4]=$ad[10];
        $MYPOINTS_SEM[5]=$sd[4];
        $MYPOINTS_SEM[6]=$sd[1];
        return $MYPOINTS_SEM;

    
}
}

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin - Faculty Analysis</title>
        <meta name="description" content="Faculty Analysis">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
        <link rel="shortcut icon" href="newfav.ico" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
        <link rel="stylesheet" type="text/css" href="css/all.css">
        <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
        <link rel="stylesheet" href="assets/css/style.css">
        
        <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />
  
    <style>
        #weatherWidget .currentDesc {
            color: #ffffff!important;
        }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }
    </style>
</head>

<body>
 <?php $user_name = $_SESSION['name']; 
        if(isset($_GET['msg']))
            echo '<script>$(document).ready(function(){$("#passSuccess").show();});</script>';
        if(isset($_GET['error']))
            echo '<script>$(document).ready(function(){$("#passFail").show();});</script>';

        ?>
        <aside id="left-panel" class="left-panel">
            <nav class="navbar navbar-expand-sm navbar-default navbar-fixed">
                <div id="main-menu" class="main-menu collapse navbar-collapse">
                    <ul class="nav navbar-nav list-group" id="myNav">

                        <li class="active">
                            <a id="menuToggle1" style="cursor:pointer;"><i class="menu-icon fa fa-laptop"></i>Dashboard</a>
                        </li>

                        <li class="sidebarHeading"><a href="#viewPerformance" class="sliding-link"><i class="menu-icon fas fa-chart-line iclass" style="color:#03a9f3;"></i><b>MY PERFORMANCE</b></a></li><!-- /.menu-title -->
                        <li><a href="#evenSem" class="sliding-link" > <i class="menu-icon fas fa-user-alt"></i>In Even Sem </a></li>
                        <li><a href="#oddSem" class="sliding-link" > <i class="menu-icon fas fa-user-alt"></i>In Odd Sem </a></li>
                        <li><a href="#thisYear" class="sliding-link"> <i class="menu-icon ti-ruler-pencil"></i>In This Year</a></li>
                        <li class="sidebarHeading"><a href="#viewPerformance" class="sliding-link"><i class="menu-icon fas fa-chart-line iclass" style="color:#03a9f3;"></i><b>COMPARISON</b></a></li>
                        <li><a href="#compareTopperEven" class="sliding-link"> <i class="menu-icon fas fa-school"></i>For Odd Sem</a></li>
                        <li><a href="#compareTopperOdd" class="sliding-link"> <i class="menu-icon fas fa-school"></i>For Even Sem</a></li>
                        
                        <li><a href="#prevYear" class="sliding-link"> <i class="menu-icon ti-ruler-pencil"></i>For Previous Years</a></li>
                        <li><a href="#topFaculty" class="sliding-link"> <i class="menu-icon fas fa-award"></i>View Toppers</a></li>
                        

                        <li class="sidebarHeading"><a href="#personalDetails" class="sliding-link"><i class="menu-icon fas fa-info-circle iclass" style="color:#03a9f3;"></i><b>MANAGE ACCOUNT</b></a></li>
                        <!--<li><a href="#personalDetails" class="sliding-link"> <i class="menu-icon ti-id-badge"></i>Edit Profile</a></li>-->
                        <li><a href="#changePass" class="sliding-link"> <i class="menu-icon ti-key"></i>Change Password</a></li>
                        <!--<li><a href="logout.php"> <i class="menu-icon fas fa-sign-out-alt"></i>Logout</a></li>-->
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
        </aside>
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header" >
                    <a class="navbar-brand" href="./"><img src="img/long_logo_transparent.png" alt="Logo"  ></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div style="padding-top: 15px;">
                        <p><?=$user_name;?></p>
                    </div>

                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php 


                            if($_SESSION['profile_pic'] == "null")
                                echo '<img class="user-avatar rounded-circle" src="img/dummy.png" alt="User">';
                            else{
                                $email = $_SESSION['email'];
                                $query = "SELECT profile_pic from user where email = '$email'";  
                                $result = mysqli_query($connect, $query);  
                                if(mysqli_num_rows($result) == 1){
                                  $row= mysqli_fetch_array($result);                               
                                  echo '<tr>
                                            <td>
                                                <img src="data:image/jpeg;base64,'.base64_encode($row['profile_pic'] ).'" class="user-avatar rounded-circle" />
                                            </td>
                                        </tr>'; 
                                }else 
                                  echo '<img class="user-avatar rounded-circle" src="img/dummy.png" alt="User">';
                            }
                            ?>
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#personalDetails"><i class="fa fa- user"></i>My Profile</a>

                            <!-- <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a> -->

                            <a class="nav-link" href="#personalDetails" class="sliding-link"><i class="fa fa -cog"></i>Settings</a>

                            <a class="nav-link" href="logout.php" ><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>

                </div>
            </div>




        </header>
        <!-- /#header -->
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">
                    
                    <div class="col-lg-3 col-md-6" >
                        
                        <div class="card">
                            <div class="card-body">
                                <a href="#mypoints">
                                <div class="stat-widget-five" >
                                    <div class="stat-icon dib flat-color-1">
                                        <i class="pe-7s-medal"></i>
                                    </div>

                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count">10</span></div>
                                            <div class="stat-heading" >Your Rank</div>
                                        </div>
                                    </div>

                                </div>
                            </a>
                            </div>
                        </div>
                    </div>
                

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-2">
                                        <i class="pe-7s-star"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text">Vaishnavi</span></div>
                                            <div class="stat-heading">Topper</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3">
                                        <i class="pe-7s-copy-file"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count">40</span></div>
                                            <div class="stat-heading">Publications</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-4">
                                        <i class="pe-7s-users"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count">2986</span></div>
                                            <div class="stat-heading">Clients</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Widgets -->
                <!--  Traffic  -->

                    <div class="col-md-4" id="viewPerformance" style="margin-bottom: -9px; width: 100%; padding-left: 0px; padding-right: 0px;">
                        <div class="card bg-flat-color-2">
                            <div class="card-body" style="">
                                <h3 class=" white-color ">MY PERFORMANCE</h4>
                            </div>
                        </div>
                    </div>


                <div  style="height:550px; margin-left:-12px;" id="evenSem">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body" >
                                
                                    <h2 class="card-title">MY PERFORMANCE IN EVEN SEM!</h2>
                                 
                                         <?php

                                            $USER_ID= $_SESSION['id'];
                                   
                                            $yr=GETYEAR($USER_ID);
                                            $i=0;
                                            $YEAR = max($yr[0]);


                                           
                                            echo chartLine(
                                                ['ATTENDANCE','PUBLICATIONS','RESEARCH','ORGANIZATIONS','ACTIVITIES','SEM RESULTS','STUDENT RATING'],
                                                [
                                                    ['name' => $YEAR.' EVEN', 'data' =>MYPOINTS($YEAR,'even',$USER_ID),'type' => 'line'],
                                                   
                                                ],
                                               'CREDITS FOR '.$YEAR.' EVEN SEM'                                                
                                            );
                                        
                                         ?>
                                    
                                
                                </div> 
                            </div>
                        </div><!-- /# column -->
                    </div>

        <div  style="height:550px; margin-left:-12px;" id="oddSem">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body" >
                                
                                    <h2 class="card-title">MY PERFORMANCE IN ODD SEM!</h2>
                                 
                                         <?php

                                            $USER_ID= $_SESSION['id'];
                                            
                                            $yr=GETYEAR($USER_ID);
                                            $i=0;
                                            $YEAR = max($yr[0]);


                                            echo chartLine(
                                                ['ATTENDANCE','PUBLICATIONS','RESEARCH','ORGANIZATIONS','ACTIVITIES','SEM RESULTS','STUDENT RATING'],
                                                [
                                                    ['name' => $YEAR.' ODD', 'data' =>MYPOINTS($YEAR,'odd',$USER_ID),'type' => 'line'],
                                                   
                                                ],
                                               'CREDITS FOR '.$YEAR.' ODD SEM'                                                
                                            );
                                        
                                         ?>
                                    
                                
                                </div> 
                            </div>
                        </div><!-- /# column -->
                    </div>

                <div style="height:550px; overflow-y: hidden;margin-left:-12px;" id="thisYear">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title">ALL ABOUT THIS YEAR!!</h2> 
                                    <div  >
                                         <?php 
                                            $USER_ID= $_SESSION['id'];
                                            $yr=GETYEAR($USER_ID);
                                            $i=0;

                                            foreach ($yr as $r) {

                                            $yrs[$i] = $r[0];

                                           // echo $yrs[$i];
                                            $i++;
                                           // echo "<br>";
                                            }

                                         $YEAR1=max($yr);
                                         $EVEN='even';
                                         $ODD='odd';

                                        
                                        if(strlen($YEAR1[0]>1))
                                        {
                                            $YEAR=$YEAR1[0];

                                        }
                                 // echo $chart1->render('simple-custom-id');
                                   echo chartLine(

                                                ['ATTENDANCE','PUBLICATIONS','RESEARCH','ORGANIZATIONS','ACTIVITIES','SEM RESULTS','STUDENT RATING'],

                                                [
                                                    ['name' => 'ODD SEM', 'data'  =>MYPOINTS($YEAR,$ODD,$USER_ID),'type' => 'line'],
                                                    ['name' => 'EVEN SEM', 'data' =>MYPOINTS($YEAR,$EVEN,$USER_ID),  'type' => 'line']
                                                ],
                                                'CREDITS FOR '.$YEAR1[0]                                                
                                            );
                                    ?>
                                    </div>
                                </div> 
                            </div>
                        </div><!-- /# column -->
                    </div>

         


                    <div style="height:550px;margin-left:-12px;" id="compareTopperEven">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body">
                                <h2 class="card-title">MY STATUS FOR EVEN SEM!</h2>
                                
                                    <div  >
                                                   <?php 
                                                   $USER_ID=$_SESSION['id'];

                                                    $yrs = array('Y1 No Data','Y2 No Data','Y3 No Data','Y4 No Data','Y5 No Data');

                                                      $yr=GETYEAR($USER_ID);
                                                       $YEAR = max($yr[0]);
                                                       $COLL_TOPPER=GET_COLLEGE_TOPPER($USER_ID,'even');
                                                       echo "<h1>".$COLL_TOPPER."<h2>";


                                                   
                                                   // echo $SEM1[0];
                                                   // echo $YEAR;
                                                    
                                                    echo chartLine(
                                                    ['ATTENDANCE','PUBLICATIONS','RESEARCH','ORGANIZATIONS','ACTIVITIES','SEM RESULTS','STUDENT RATING'],
                                                    [
                                                         ['name' => 'MY SCORE', 'data' => YEARSUM($YEAR,$USER_ID), 'type' => 'line'],
                                                         ['name' => 'DEPARTMENT TOPPER', 'data' =>YEARSUM($YEAR,'0'), 'type' => 'line'],
                                                         ['name' => 'COLLEGE TOPPER', 'data' => YEARSUM($YEAR,$COLL_TOPPER), 'type' => 'line']

                                                         // ['name' => 'DEPARTMENT TOPPER', 'data' => [15, 10, 30, 40, 20, 30,60], 'type' => 'line'],
                                                         // ['name' => 'COLLEGE TOPPER', 'data' => [35, 30, 20, 30, 50, 10,35], 'type' => 'line']
                                                         
                                                    ],
                                                    'COMPARISON FOR '.$YEAR.' EVEN SEM' 
                                                );
                                                    ?>
                                     </div>
                                 </div>
                                </div> 
                            </div>
                        </div><!-- /# column -->
                    


         <div style="height:550px; overflow-y: hidden;margin-left:-12px;" id="prevYear">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body">
                                <h2 class="card-title">DID I IMPROVE..?</h2> 
                                    <div >
                                                   <?php 

                                                   $yr=GETYEAR($USER_ID);
                                                   $i=0;

                                                   $yrs = array('Y1 No Data','Y2 No Data','Y3 No Data','Y4 No Data','Y5 No Data');

                                                   foreach ($yr as $r) {
                                                       $yrs[$i] = $r[0];
                                                       $i++;
                                                       
                                                   }
                                                   // echo "<h4>YEARS</h4><br>";
                                                   // echo "<h4>".$yrs[0]."</h4><br>";
                                                   // echo "<h4>".$yrs[1]."</h4><br>";
                                                   // echo "<h4>".$yrs[2]."</h4><br>";
                                                   // echo "<h4>".$yrs[3]."</h4><br>";
                                                   // echo "<h4>YEARSUM</h1><br>";
                                                   // echo "<h4>".YEARSUM($yrs[3],$USER_ID)[0]."</h4><br>";
                                                   // echo "<h4>".YEARSUM($yrs[3],$USER_ID)[1]."</h4><br>";
                                                   // echo "<h4>".YEARSUM($yrs[3],$USER_ID)[2]."</h4><br>";
                                                   // echo "<h4>".YEARSUM($yrs[3],$USER_ID)[3]."</h4><br>";


                                                    echo chartLine(
                                                    ['ATTENDANCE','PUBLICATIONS','RESEARCH','ORGANIZATIONS','ACTIVITIES','SEM RESULTS','STUDENT RATING'],
                                                    [

                                                         ['name' => $yrs[0], 'data' => YEARSUM($yrs[0],$USER_ID), 'type' => 'line'],
                                                         ['name' => $yrs[1], 'data' => YEARSUM($yrs[1],$USER_ID), 'type' => 'line'],
                                                         ['name' => $yrs[2], 'data' => YEARSUM($yrs[2],$USER_ID), 'type' => 'line'],
                                                         ['name' => $yrs[3], 'data' => YEARSUM($yrs[3],$USER_ID), 'type' => 'line'],
                                                         ['name' => $yrs[4], 'data' => YEARSUM($yrs[4],$USER_ID), 'type' => 'line']

                                                    ],
                                                    'FOR PAST 5 YEARS'                                                
                                                );
                                                ?>

                                            </div>    
                                     </div>
                                </div> 
                            </div>
                        </div><!-- /# column -->
                   
                    <div class="orders" id="topFaculty">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="card-title">RANK LIST FOR THIS YEAR! </h2>
                                    </div>
                                    <div class="card-body--">
                                        <div class="table-stats order-table ov-h">
                                            <table class="table ">
                                                <thead>
                                                    <tr>
                                                        <th class="serial">#</th>
                                                        <th class="avatar">Avatar</th>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Product</th>
                                                        <th>Quantity</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="serial">1.</td>
                                                        <td class="avatar">
                                                            <div class="round-img">
                                                                <a href="#"><img class="rounded-circle" src="images/avatar/1.jpg" alt=""></a>
                                                            </div>
                                                        </td>
                                                        <td> #5469 </td>
                                                        <td>  <span class="name">Louis Stanley</span> </td>
                                                        <td> <span class="product">iMax</span> </td>
                                                        <td><span class="count">231</span></td>
                                                        <td>
                                                            <span class="badge badge-complete">Complete</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="serial">2.</td>
                                                        <td class="avatar">
                                                            <div class="round-img">
                                                                <a href="#"><img class="rounded-circle" src="images/avatar/2.jpg" alt=""></a>
                                                            </div>
                                                        </td>
                                                        <td> #5468 </td>
                                                        <td>  <span class="name">Gregory Dixon</span> </td>
                                                        <td> <span class="product">iPad</span> </td>
                                                        <td><span class="count">250</span></td>
                                                        <td>
                                                            <span class="badge badge-complete">Complete</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="serial">3.</td>
                                                        <td class="avatar">
                                                            <div class="round-img">
                                                                <a href="#"><img class="rounded-circle" src="images/avatar/3.jpg" alt=""></a>
                                                            </div>
                                                        </td>
                                                        <td> #5467 </td>
                                                        <td>  <span class="name">Catherine Dixon</span> </td>
                                                        <td> <span class="product">SSD</span> </td>
                                                        <td><span class="count">250</span></td>
                                                        <td>
                                                            <span class="badge badge-complete">Complete</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="serial">4.</td>
                                                        <td class="avatar">
                                                            <div class="round-img">
                                                                <a href="#"><img class="rounded-circle" src="images/avatar/4.jpg" alt=""></a>
                                                            </div>
                                                        </td>
                                                        <td> #5466 </td>
                                                        <td>  <span class="name">Mary Silva</span> </td>
                                                        <td> <span class="product">Magic Mouse</span> </td>
                                                        <td><span class="count">250</span></td>
                                                        <td>
                                                            <span class="badge badge-pending">Pending</span>
                                                        </td>
                                                    </tr>
                                                    <tr class=" pb-0">
                                                        <td class="serial">5.</td>
                                                        <td class="avatar pb-0">
                                                            <div class="round-img">
                                                                <a href="#"><img class="rounded-circle" src="images/avatar/6.jpg" alt=""></a>
                                                            </div>
                                                        </td>
                                                        <td> #5465 </td>
                                                        <td>  <span class="name">Johnny Stephens</span> </td>
                                                        <td> <span class="product">Monitor</span> </td>
                                                        <td><span class="count">250</span></td>
                                                        <td>
                                                            <span class="badge badge-complete">Complete</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> <!-- /.table-stats -->
                                    </div>
                                </div> <!-- /.card -->
                            </div>  <!-- /.col-lg-8 -->


                        </div>
                    </div>
                

                
              
            


            <div class="col-md-4" id ="personalDetails" style="padding-bottom: 5px; width: 100%; padding-left: 0px; padding-right: 0px;">
                        <div class="card bg-flat-color-2">
                            <div class="card-body" >
                                <h3 class=" white-color ">MANAGE ACCOUNT</h4>
                            </div>
                        </div>
            </div>

                    <!-- To Do and Live Chat -->
                    <div class="row" id="changePass" style="margin-left: 0px;">                        
                        <div class="card col-lg-6">
                            <div class="card-body">
                                <h4 class="card-title box-title">Change Password</h4>
                                <div class="card-content">
                                    <form class="form-horizontal" action="change_password_user.php" method= "POST" id="passForm">
                                        <div class="form-group">
                                            <label class="col-md-6 control-label" for="oldpassword">Old Password</label>
                                            <div class="col-md-7">
                                                <div class="input-group"> <span class="input-group-addon"><i class="fas fa-key"></i></span>
                                                    <input id="oldpassword" name="oldpassword" type="password" placeholder="Enter Old Password" class="form-control input-md">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-6 control-label" for="newpassword">New Password</label>
                                                <div class="col-md-7">
                                                    <div class="input-group"> <span class="input-group-addon"><i class="fas fa-key"></i></span>
                                                        <input id="newpassword" name="newpassword" type="password" placeholder="Enter New Password" class="form-control input-md">
                                                    </div>
                                                </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-6 control-label" for="newpassword1">Confirm Password</label>
                                            <div class="col-md-7">
                                                <div class="input-group"> <span class="input-group-addon"><i class="fas fa-key"></i></span>
                                                    <input id="newpassword1" name="newpassword1" type="password" placeholder="Confirm New Password" class="form-control input-md">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="alert alert-danger alert-dismissible offset-md-1 col-md-10 collapse" role="alert" id ="passFail">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <center><strong>Error!</strong> &nbsp; Wrong Password Entered</center>
                                        </div>

                                        <div class="col-md-offset-5 col-md-4"> 
                                            <button id="Submit" class="btn btn-success" type="submit">Change</button>
                                        </div>
                                    </form>
                                    <div class="alert alert-success alert-dismissible offset-md-2 col-md-8 collapse" style="margin-top: 10px;" role="alert" id ="passSuccess">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <center><strong>Success!</strong> Password Changed!</center>
                                    </div>                                               
                                </div>
                            </div>
                        </div>
                        
    
                    </div>
         
                
                </div>


        </div>
        <!-- /.content -->
        <div class="clearfix"></div>
        <!-- Footer -->
             <footer class="site-footer">
                <div class="footer-inner bg-white">
                    <div class="row">
                        <div class="col-sm-6">
                            Copyright &copy; 2018 Faculty Analysis
                        </div>
                        <div class="col-sm-6 text-right">
                            By Vaishnavi N Naik | Siddhartha N
                        </div>
                    </div>
                </div>
            </footer>
        <!-- /.site-footer -->
    </div>


 


    <script type="text/javascript">
           $(".sliding-link").click(function(e) {
                // e.preventDefault();
                var aid = $(this).attr("href");
                $('html,body').animate({scrollTop: $(aid).offset().top-75},'slow');
            });

            $(document).ready(function() {
                $('html, body').hide();

                if (window.location.hash) {
                    setTimeout(function() {
                        $('html, body').scrollTop(0).show();
                        $('html, body').animate({
                            scrollTop: $(window.location.hash).offset().top-75
                            }, 3000)
                    }, 0);
                }
                else {
                    $('html, body').show();
                }
            });
            </script>
    <!-- /#right-panel -->

    <!-- Scripts -->

        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
        <script src="js/confirmPass.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
        <script src="assets/js/main.js"></script>
         <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
        <script src="js/confirmPass.js"></script>


        <script src="https://cdn.jsdelivr.net/npm/simpleweather@3.1.0/jquery.simpleWeather.min.js"></script>
        <script src="assets/js/init/weather-init.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
        <script src="assets/js/init/fullcalendar-init.js"></script>
     </body>
    <!--Local Stuff-->
   
</html>
