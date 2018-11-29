<?php

header('Content-Type: text/html; charset=utf-8');
require('include/connection.php');

if(!isset($_SESSION['email'])){
    header('location:login.php');
}
if($_SESSION['type'] == 'admin' )
    header('location:admin_dash.php');

require('./vendor/autoload.php');

function chartLine($xAxisData, $seriesData, $title = '')
{
    $chart = new Hisune\EchartsPHP\ECharts();
    $xAxis = new Hisune\EchartsPHP\Doc\IDE\XAxis();
    $yAxis = new Hisune\EchartsPHP\Doc\IDE\YAxis();

    $color = [ 
            '#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', 
            '#bda29a','#6e7074', '#546570', '#c4ccd3'
            //'#ca8622', '#ff0000','#bda29a','#6e7074', '#546570','#ff69b4','#ba55d3','#cd5c5c','#ffa500','#40e0d0',
           // '#ff7f50','#87cefa','#da70d6','#32cd32','#6495ed','#FB0065','#FCFF00','#00ECFF'
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
   // $chart->initOptions->height = '1000px';

    return $chart->render(uniqid());
}
?>
<?php
$GLOBALS['MYPOINTS_EVEN']= array(0.0,0.0,0.0,0.0,0.0,0.0,0.0);
$GLOBALS['MYPOINTS_ODD']= array(0.0,0.0,0.0,0.0,0.0,0.0,0.0);
$GLOBALS['user_id']= $_SESSION['id'];
try
{
$year=mysqli_query($connect,"SELECT max(year) as maxy FROM performance where user_id='$user_id'");
$yr=mysqli_fetch_row($year);
$query = "SELECT academic_id,student_id FROM performance WHERE user_id = '$user_id' and year='$yr[0]'and sem='even'" ;

if((mysqli_query($connect, $query) ) or die(mysqli_error($connect)))
{  
        $res=mysqli_query($connect, $query); 
        $row = mysqli_fetch_row($res);
        
        $GLOBALS['academic_id']=$row[0];
        $GLOBALS['stud_id']=$row[1];
      
    
}

$query1 = "SELECT * FROM `academic_performance` WHERE academic_id='$academic_id'" ;
$academic=mysqli_query($connect, $query1); 
$GLOBALS['ad'] = mysqli_fetch_row($academic);


$query2 = "SELECT * FROM `student_performance` WHERE student_id='$stud_id'" ;
$student=mysqli_query($connect, $query2); 
$GLOBALS['sd'] = mysqli_fetch_row($student);

mysqli_close($connect);

$MYPOINTS_EVEN[0]=$ad[4];
$MYPOINTS_EVEN[1]=$ad[2];
$MYPOINTS_EVEN[2]=$ad[8];
$MYPOINTS_EVEN[3]=$ad[6];
$MYPOINTS_EVEN[4]=$ad[10];
$MYPOINTS_EVEN[5]=$sd[4];
$MYPOINTS_EVEN[6]=$sd[1];
}
catch(Exception $ex)
{

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
        <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script>
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
 <?php $user_name = $_SESSION['name'] ?>
        <aside id="left-panel" class="left-panel">
            <nav class="navbar navbar-expand-sm navbar-default navbar-fixed">
                <div id="main-menu" class="main-menu collapse navbar-collapse">
                    <ul class="nav navbar-nav list-group" id="myNav">

                        <li class="active">
                            <a id="menuToggle1" style="cursor:pointer;"><i class="menu-icon fa fa-laptop"></i>Dashboard</a>
                        </li>

                        <li class="sidebarHeading"><a href="#viewPerformance" class="sliding-link"><i class="menu-icon fas fa-chart-line iclass" style="color:#03a9f3;"></i><b>MY PERFORMANCE</b></a></li><!-- /.menu-title -->
                        <li><a href="#thisSem" class="sliding-link" > <i class="menu-icon fas fa-user-alt"></i>My Credits </a></li>
                        <li><a href="#compareTopper" class="sliding-link"> <i class="menu-icon fas fa-school"></i>Comparison</a></li>
                        <li><a href="#thisYear" class="sliding-link"> <i class="menu-icon ti-ruler-pencil"></i>This Year</a></li>
                        <li><a href="#prevYear" class="sliding-link"> <i class="menu-icon ti-ruler-pencil"></i>Previous Years</a></li>
                        <li><a href="#topFaculty" class="sliding-link"> <i class="menu-icon fas fa-award"></i>Rank List</a></li>
                        

                        <li class="sidebarHeading"><a href="#personalDetails" class="sliding-link"><i class="menu-icon fas fa-info-circle iclass" style="color:#03a9f3;"></i><b>MANAGE ACCOUNT</b></a></li>
                        <li><a href="#personalDetails" class="sliding-link"> <i class="menu-icon ti-id-badge"></i>Edit Profile</a></li>
                        <li><a href="#changePass" class="sliding-link"> <i class="menu-icon ti-key"></i>Change Password</a></li>
                        <li><a href="logout.php"> <i class="menu-icon fas fa-sign-out-alt"></i>Logout</a></li>
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


                 <div  style="height:550px; margin-left:-12px;" id="thisSem">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title">SEE WHAT YOU HAVE EARNED..!</h1> 
                                    <div>
                                         <?php   

                                         
                                            echo chartLine(
                                                ['ATTENDANCE','PUBLICATIONS','RESEARCH','ORGANIZATIONS','EXTRA CURRICULUM','SEM RESULTS','STUDENT RATING'],
                                                [
                                                    ['name' => 'THIS SEM', 'data' =>$MYPOINTS,'type' => 'line'],
                                                   
                                                ],
                                               'YOUR CREDITS FOR THE SEM'                                                
                                            );
                                         ?>
                                    </div>
                                </div> 
                            </div>
                        </div><!-- /# column -->
                    </div>




                    <div style="height:500px; overflow-y: hidden;margin-left:-12px;" id="compareTopper">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <h1 class="card-title">SEE WHERE YOU STAND..!</h1> 
                                    <div  >
                                                   <?php 
                                                    echo chartLine(
                                                    ['ATTENDANCE','PUBLICATIONS','RESEARCH','ORGANIZATIONS','EXTRA CURRICULUM','SEM RESULTS','STUDENT RATING'],
                                                    [
                                                         ['name' => 'YOU SCORE', 'data' => [5, 20, 40, 10, 10, 20], 'type' => 'line'],
                                                         ['name' => 'DEPARTMENT TOPPER', 'data' => [15, 10, 30, 40, 20, 30], 'type' => 'line'],
                                                         ['name' => 'COLLEGE TOPPER', 'data' => [35, 30, 20, 30, 50, 10], 'type' => 'line']
                                                         
                                                    ],
                                                    'PERFORMANCE IN THIS SEM'                                                
                                                );
                                                ?>
                                     </div>
                                </div> 
                            </div>
                        </div><!-- /# column -->
                    


                 <div style="height:550px; overflow-y: hidden;margin-left:-12px;" id="thisYear">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title">HOW DO YO FEEL NOW..!</h1> 
                                    <div  >
                                         <?php 
                                 // echo $chart1->render('simple-custom-id');
                                   echo chartLine(
                                                ['ATTENDANCE','PUBLICATIONS','RESEARCH','ORGANIZATIONS','EXTRA CURRICULUM','SEM RESULTS','STUDENT RATING'],
                                                [
                                                    ['name' => 'ODD SEM', 'data'  =>[15, 10, 30, 40, 20, 30,40],'type' => 'line'],
                                                    ['name' => 'EVEN SEM', 'data' =>$MYPOINTS,  'type' => 'line']
                                                ],
                                                'YOUR CREDITS FOR THE YEAR'                                                
                                            );
                                    ?>
                                    </div>
                                </div> 
                            </div>
                        </div><!-- /# column -->
                    </div>

                 <div style="height:500px; overflow-y: hidden;margin-left:-12px;" id="prevYear">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <h1 class="card-title">DID YOU IMPROVE..?</h1> 
                                    <div  >
                                                   <?php 
                                                    echo chartLine(
                                                    ['ATTENDANCE','PUBLICATIONS','RESEARCH','ORGANIZATIONS','EXTRA CURRICULUM','SEM RESULTS','STUDENT RATING'],
                                                    [
                                                         ['name' => '2018-19', 'data' => [5, 20, 40, 10, 10, 20], 'type' => 'line'],
                                                         ['name' => '2017-18', 'data' => [15, 10, 30, 40, 20, 30], 'type' => 'line'],
                                                         ['name' => '2016-18', 'data' => [25, 30, 10, 50, 10, 40], 'type' => 'line'],
                                                         ['name' => '2015-16', 'data' => [35, 30, 20, 30, 50, 10], 'type' => 'line']
                                                    ],
                                                    'YOUR OVERALL VIEW'                                                
                                                );
                                                ?>
                                     </div>
                                </div> 
                            </div>
                        </div><!-- /# column -->
                   
                    <div class="orders" id="topFaculty">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h1 class="card-title">RANK LIST..! </h1>
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
                

                </div>
              
            


            <div class="col-md-4" id ="personalDetails" style="padding-bottom: 5px; width: 100%; padding-left: 0px; padding-right: 0px;">
                        <div class="card bg-flat-color-2">
                            <div class="card-body" style="">
                                <h3 class=" white-color ">MANAGE ACCOUNT</h4>
                            </div>
                        </div>
                    </div>

                    <!-- To Do and Live Chat -->
                    <div class="row" style="margin-left:0px;"id="changePass" >                        
                        <div class="card col-lg-6">
                            <div class="card-body">
                                <h4 class="card-title box-title">Change Password</h4>
                                <div class="card-content">
                                    <form class="form-horizontal" action="change_password.php" method= "POST" id="form1">
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

                                        <div class="col-md-offset-5 col-md-4"> 
                                            <button id="Submit" class="btn btn-lg btn-success" type="submit">Change</button>
                                        </div>
                                    </form>                                                
                                </div>
                            </div> <!-- /.card-body -->
                        </div><!-- /.card -->
            <!-- .animated -->
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>

    <!--  Chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>

    <!--Chartist Chart-->
    <script src="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-pie@1.0.0/src/jquery.flot.pie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/simpleweather@3.1.0/jquery.simpleWeather.min.js"></script>
    <script src="assets/js/init/weather-init.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
    <script src="assets/js/init/fullcalendar-init.js"></script>

    <!--Local Stuff-->
    

</html>
