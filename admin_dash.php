<?php
header('Content-Type: text/html; charset=utf-8');
require('include/connection.php');

if(!isset($_SESSION['type'])){
    header('location:login.php');
}

if(isset($_SESSION['type']) && $_SESSION['type']!='admin')
    header('location:index.php');

require('./vendor/autoload.php');
function chartLine($xAxisData, $seriesData, $title = '')
{
    $chart = new Hisune\EchartsPHP\ECharts();
    $xAxis = new Hisune\EchartsPHP\Doc\IDE\XAxis();
    $yAxis = new Hisune\EchartsPHP\Doc\IDE\YAxis();

    $color = ['#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
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

    $chart->initOptions->renderer = 'svg';
        //$chart->initOptions->width = '800px';

    return $chart->render(uniqid());
}
?>

<!doctype html>
<html class="no-js" lang="en">
    <head>

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
        <style type="text/css">
            .cardStyle{
              padding-left: 0px;
              padding-right: 0px;

            }
            .sidebarHeading{
                font-weight: 700;
                text-transform: uppercase;
                font-size: 20px;
            }
            .iclass{
                font-size: 16px; margin-top: 7px;
            }
        </style>
    </head>

    <body>
        <!-- Left Panel -->
        <!-- Dashboard -->
        <?php $user_name = $_SESSION['name'] ?>
        <aside id="left-panel" class="left-panel">
            <nav class="navbar navbar-expand-sm navbar-default navbar-fixed">
                <div id="main-menu" class="main-menu collapse navbar-collapse">
                    <ul class="nav navbar-nav list-group" id="myNav">

                        <li class="active">
                            <a id="menuToggle1" style="cursor:pointer;"><i class="menu-icon fa fa-laptop"></i>Dashboard</a>
                        </li>

                        <li class="sidebarHeading"><a href="#viewPerformance" class="sliding-link"><i class="menu-icon fas fa-chart-line iclass" style="color:#03a9f3;"></i>View Performance</a></li><!-- /.menu-title -->
                        <li><a href="#depPerformance" class="sliding-link"> <i class="menu-icon fas fa-school"></i>Department </a></li>
                        <li><a href="#faculty" class="sliding-link" > <i class="menu-icon fas fa-user-alt"></i>Faculty </a></li>
                        <li><a href="#compare" class="sliding-link"> <i class="menu-icon ti-ruler-pencil"></i>Compare </a></li>
                        <li><a href="#topFaculty" class="sliding-link"> <i class="menu-icon fas fa-award"></i>Top Faculty </a></li>

                        <li class="sidebarHeading"><a href="#manageDept" class="sliding-link"><i class="menu-icon fas fa-code-branch iclass" style="color:#03a9f3;"></i>Manage</a></li><!-- /.menu-title -->
                        <li><a href="#addFaculty" class="sliding-link"> <i class="menu-icon fas fa-user-plus"></i>Faculty </a></li>
                        <li><a href="#addAdmin" class="sliding-link"> <i class="menu-icon fas fa-user-plus"></i>Admin </a></li>
                        <li><a href="#addPerformance" class="sliding-link"> <i class="menu-icon fas fa-stopwatch"></i>Performance Details </a></li>
                        
                        <li class="sidebarHeading"><a href="#personalDetails" class="sliding-link"><i class="menu-icon fas fa-info-circle iclass" style="color:#03a9f3;"></i>Personal Details</a></li><!-- /.menu-title -->
                        <li><a href="#" class="sliding-link"> <i class="menu-icon ti-id-badge"></i>Edit Profile</a></li>
                        <li><a href="#changePass" class="sliding-link"> <i class="menu-icon ti-key"></i>Change Password</a></li>
                        <li><a href="logout.php"> <i class="menu-icon fas fa-sign-out-alt"></i>Logout</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
        </aside>
        <!-- /#left-panel -->

        <!-- Right Panel -->
        <div id="right-panel" class="right-panel">
            <!-- Header-->
            <header id="header" class="header">
                <div class="top-left">
                    <div class="navbar-header" >
                        <a class="navbar-brand" href="./"><img src="img/long_logo_transparent.png" alt="Logo"  ></a>
                        <a id="menuToggle" class="menutoggle" style="cursor: pointer;"><i class="fa fa-bars"></i></a>
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
                                      $row = mysqli_fetch_array($result);                               
                                      echo '<img src="data:image/jpeg;base64,'.base64_encode($row['profile_pic'] ).'" class="user-avatar rounded-circle" />'; 
                                  }else 
                                  echo '<img class="user-avatar rounded-circle" src="img/dummy.png" alt="User">';
                              }
                              ?>
                          </a>

                          <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa- user"></i>My Profile</a>

                            <!-- <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a> -->

                            <a class="nav-link" href="#changePass" id="changePassTrigger1"><i class="fa fa -cog"></i>Settings</a>

                            <a class="nav-link" href="logout.php"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            </header>
            <!-- /#header -->
            <!-- Content -->
            <div class="content">
                <!-- Animated -->
                <div class="animated fadeIn" data-spy="scroll" data-target="#myNav" data-offset="50">
                    <!-- Widgets Top Small Cards -->
                    <div class="row">

                        <div class="col-lg-3 col-md-6" >
                            <div class="card">
                                <div class="card-body">
                                        <div class="stat-widget-five" >
                                            <div class="stat-icon dib flat-color-1">
                                                <i class="pe-7s-medal"></i>
                                            </div>
                                            <div class="stat-content">
                                                <div class="text-left dib">
                                                    <div class="stat-text"><span class="count">45</span></div>
                                                    <div class="stat-heading" >Dept Avg</div>
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
                                        <div class="stat-icon dib flat-color-2">
                                            <i class="pe-7s-star"></i>
                                        </div>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text">Vaishnavi</div>
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
                                                <div class="stat-text"><span class="count">23</span></div>
                                                <div class="stat-heading">Members</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" id="viewPerformance" style="margin-bottom: -9px; width: 100%; padding-left: 0px; padding-right: 0px;">
                        <div class="card bg-flat-color-2">
                            <div class="card-body" style="">
                                <h3 class=" white-color ">VIEW PERFORMANCE</h4>
                            </div>
                        </div>
                    </div>

                    <!-- DEPARTMENT PERFORMANCE -->
                    <div style="height:550px; margin-left: 0px; overflow-y: hidden;" id="depPerformance">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title">YOUR DEPARTMENT </h1> 
                                    <div  >
                                         <?php 
                                         // echo $chart1->render('simple-custom-id');
                                         echo chartLine(
                                            ['SEM RESULTS','ATTENDANCE','PUBLICATIONS','RESEARCH','EXTRA CURRICULUM','STUDENT RATING'],
                                            [
                                                ['name' => '2018-19', 'data' => [11, 20, 40, 15, 35, 20], 'type' => 'line']
                                            ],
                                            ''                                                
                                        );
                                        ?>
                                    </div>
                                </div> 
                            </div>
                        </div><!-- /# column -->
                    </div>

                    <!-- FACULTY PERFORMANCE -->
                    <div style="height:650px; overflow-y: hidden;" id="faculty" >
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body" id="faculty">
                                    <h1 class="card-title">VIEW FACULTY PERFORMANCE</h1>
                                    <div class="col-sm-12" style="margin-left: 0px;" >
                                        <form action="#faculty" method="GET" class="form-inline">
                                            <div class="form-group inline col-md-12">
                                                <label for="faculty_name">Select Faculty:</label>
                                                <select name="faculty_name" style="margin-left: 20px;" class="form-control col-md-4">
                                                    <?php
                                                    $dept = $_SESSION['dept'];
                                                    $query = "SELECT user_id, name FROM user WHERE user_type = 'user' AND dept = '$dept'";
                                                    $result = mysqli_query($connect, $query);
                                                    $num = mysqli_num_rows($result);
                                                    while($array = mysqli_fetch_array($result)){
                                                        $opt_val = $array['user_id'];
                                                        $opt_content = $array['name'];
                                                        echo "<option value = $opt_val>$opt_content</option>";
                                                    }?>                                      
                                                </select>
                                                <button id="Submit" style="margin-left: 20px;" class="btn btn-primary" type="submit">GO</button>    
                                            </div>
                                        </form>
                                        <div id="facultyDetails" style="height: 450px;margin-top: 25px;">
                                            <div class="col-sm-12" style="margin-left: 0px;" >
                                                 <?php 
                                                    echo chartLine(
                                                    ['SEM RESULTS','ATTENDANCE','PUBLICATIONS','RESEARCH','EXTRA CURRICULUM','STUDENT RATING'],
                                                    [
                                                         ['name' => 'FACULTY', 'data' => [5, 20, 40, 10, 10, 20], 'type' => 'bar'],
                                                         ['name' => 'DEPARTMENT TOPPER', 'data' => [15, 10, 30, 40, 20, 30], 'type' => 'bar'],
                                                         ['name' => 'COLLEGE TOPPER', 'data' => [35, 30, 20, 30, 50, 10], 'type' => 'bar']
                                                         
                                                    ],
                                                    ''                                                
                                                );
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- COMPARE DEPARTMENT PERFORMANCE -->
                    <div style="height:550px; overflow-y: hidden; margin-top: 10px;" id="compare" >
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body" id="">
                                    <h1 class="card-title">COMPARE DEPARTMENTS</h1>
                                    <div class="col-sm-12" style="margin-left: 0px;" >
                                        <?php 
                                        echo chartLine(
                                            ['SEM RESULTS','ATTENDANCE','PUBLICATIONS','RESEARCH','EXTRA CURRICULUM','STUDENT RATING'],
                                            [
                                                ['name' => 'Your Department', 'data' => [5,6,7,9,8,6]],
                                                ['name' => 'Dept 2', 'data' => [9,9,6,12,6,3]],
                                                ['name' => 'Dept 3', 'data' => [8,6,4,3,7,2]],
                                                ['name' => 'Dept 4', 'data' => [7,4,8,7,6,6]],
                                                ['name' => 'Dept 5', 'data' => [6,7,6,9,4,7]],
                                            ],
                                            ''                                                
                                        );
                                        ?>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <!-- TOPP FACULTY DETAILS -->
                    <div class="orders" id="topFaculty">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="box-title">Orders </h4>
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

                    <div class="col-md-5" id="manageDept" style="margin-bottom: -9px; width: 100%; padding-left: 0px; padding-right: 0px;">
                        <div class="card bg-flat-color-6" >
                            <div class="card-body" style="">
                                <h3 class=" white-color ">MANAGE DEPARTMENT</h4>
                            </div>
                        </div>
                    </div>

                    <!-- ADD PERFORMANCE -->
                    <div style="height:890px; overflow-y: hidden; " id="addPerformance">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body" id="depPerformance">
                                    <p style="font-size:20px;">MANAGE FACULTY PERFORMANCE</p> <hr>
                                    <h1 class="box-title">ADD PERFORMANCE </h1> 
                                        <form action="performance_submit.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label for="faculty_name" class="col-sm-4 col-form-label">Select Faculty:</label>
                                                <div class="col-sm-4">
                                                    <select name="faculty_name" id="faculty_name" class="form-control">
                                                        <!-- fetching faculty names from the database -->
                                                        <?php
                                                            $dept = $_SESSION['dept'];
                                                            $query = "SELECT user_id, name FROM user WHERE user_type = 'user' AND dept = '$dept'";
                                                            $result = mysqli_query($connect, $query);
                                                            $num = mysqli_num_rows($result);
                                                            while($array = mysqli_fetch_array($result)){
                                                                $opt_val = $array['user_id'];
                                                                $opt_content = $array['name'];
                                                                echo "<option value = $opt_val>$opt_content</option>";
                                                        }?>                                      
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <label for="year" class="col-sm-4 col-form-label">Choose Year</label>
                                                <div class="col-sm-4">
                                                    <select name="year" id="year" class="form-control">
                                                        <option value="2024-25">2024-25</option>
                                                        <option value="2023-24">2023-24 </option>
                                                        <option value="2022-23">2022-23 </option>
                                                        <option value="2021-22">2021-22 </option>
                                                        <option value="2020-21">2020-21 </option>
                                                        <option value="2019-20">2019-20 </option>
                                                        <option value="2018-19" selected="true"> 2018-19</option>
                                                        <option value="2017-18">2017-18 </option>
                                                        <option value="2016-17">2016-17  </option>
                                                        <option value="2015-16">2015-16 </option>
                                                        <option value="2014-15">2014-15</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="sem" class="col-sm-4 col-form-label">Choose Sem</label>
                                                <div class="col-sm-4">
                                                    <select name="sem" id="sem" class="form-control">
                                                        <option value="odd"> ODD</option>
                                                        <option value="even"> EVEN</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <h1 class="box-title">CREDITS FROM ACADEMICS </h1>

                                            <div class="form-group row">
                                                <label for="attendance" class="col-sm-4 col-form-label">Total Attendance </label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" id="attendance" name="attendance" placeholder="Enter Attendance (Exclude %)" min="0.00" max="100.00"step=".1">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tot_research" class="col-sm-4 col-form-label">No of Research works</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" id="tot_research" name="tot_research" placeholder="Enter Total Count" min="0" step="1">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="tot_pub" class="col-sm-4 col-form-label">No of Publications</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" id="tot_pub" name="tot_pub" placeholder="Enter Total Count"min="0" step="1">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tot_org" class="col-sm-4 col-form-label">No of Organizations </label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" id="tot_org" name="tot_org" placeholder="Enter Total Count" min="0" step="1">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tot_extra_act" class="col-sm-4 col-form-label">No of Extra-Curricular Events </label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" id="tot_extra_act" name="tot_extra_act" placeholder="Enter Total Count"min="0" step="1">
                                                </div>
                                            </div>
                                            <hr>
                                            <h1 class="box-title">CREDITS FROM STUDENTS </h1>

                                            <div class="form-group row">
                                                <label for="tot_students" class="col-sm-4 col-form-label">Total Students</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" id="tot_students" name="tot_students" placeholder="Enter The Count" min="0.000" step="1">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tot_pass" class="col-sm-4 col-form-label">No of Students Passed</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" id="tot_pass" name="tot_pass" placeholder="Enter The Count" min="0.000" step="1">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="stud_credits" class="col-sm-4 col-form-label">Student Rating </label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" id="stud_credits" name="stud_credits" placeholder="Enter Rating (out of 10)" min="0.000" max="10.000"step="0.1">
                                                </div>
                                            </div>
                                            <br>
                                            <button type="submit" name="submit" class="btn btn-primary offset-md-1 col-md-2" style="margin-left: center;margin-top: -20px;">Submit</button>
                                            <br>
                                        </form>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <!-- MANAGE FACULTY -->
                    <div style="height:450px; overflow-y: hidden;" id="addFaculty">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body" id="depPerformance">
                                    <p style="font-size:20px;">MANAGE FACULTY </p> <hr>
                                        <form action="performance_submit.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-4 control-label">Name</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                                                </div>
                                            </div>

                                            <input type="hidden" class="form-control" id="utype" name="utype" value="user">

                                            <div class="form-group row">
                                                <label for="email" class="col-sm-4 control-label">Email</label>
                                                <div class="col-sm-5">
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="pass" class="col-sm-4 control-label">Password</label>
                                                <div class="col-sm-5">
                                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="dept" class="col-sm-4 control-label">Department</label>
                                                <div class="col-sm-5">
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

                                            <div class="form-group row">
                                                <label for="image" class="col-sm-4 control-label" >Upload Image:</label>
                                                <!-- <div class="col-sm-7" style="margin-top: 6px;" >
                                                    <input type="file" id="image" name="image">
                                                </div> -->
                                                <div class="custom-file " style="margin-left: 15px; width:385px;">
                                                    <input type="file" class="custom-file-input" id="image">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                            </div>

                                            <div class="alert alert-danger alert-dismissible col-md-offset-1 collapse" role="alert" id ="regFail">
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                              <center><strong>Error!</strong> Upload an image!</center>
                                            </div>

                                            <br>
                                            <button type="submit" name="submit" class="btn btn-primary col-md-offset-5 col-md-4" style="margin-left: center;margin-top: -20px;">Register</button>
                                            <br>
                                        </form>
                                        <div class="alert alert-success alert-dismissible col-md-offset-1 collapse" role="alert" id ="regSuccess">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <center>
                                                <strong>Success!</strong> Registration Successful. <a href="login.php" class="alert-link">Click here to login.</a>
                                            </center>
                                        </div>
                                </div>                   
                            </div>
                        </div>
                    </div>

                    <!-- MANAGE ADMIN -->
                    <div style="height:450px; overflow-y: hidden;" id="addAdmin">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body" id="depPerformance">
                                    <p style="font-size:20px;">MANAGE ADMIN </p> <hr>
                                    <form class="form-horizontal" action="performance_submit.php" method="post" enctype="multipart/form-data">

                                            <div class="form-group row">
                                                <label for="name" class="col-sm-4 control-label">Name</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"required="true">
                                                </div>
                                            </div>

                                            <input type="hidden" class="form-control" id="utype" name="utype" value="admin">


                                            <div class="form-group row">
                                                <label for="email" class="col-sm-4 control-label">Email</label>
                                                <div class="col-sm-5">
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="true">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="pass" class="col-sm-4 control-label">Password</label>
                                                <div class="col-sm-5">
                                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Password"required="true">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="dept" class="col-sm-4 control-label">Department</label>
                                                <div class="col-sm-5">
                                                    <select name="dept" id="dept" class="form-control">
                                                        <option value="CSE" selected="true"> Computer Science and Engineering</option>
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

                                            <div class="form-group row">
                                                <label for="image" class="col-sm-4 control-label" >Upload Image:</label>
                                                <div class="custom-file" style="margin-left:15px;width:385px;">
                                                    <input type="file" class="custom-file-input" id="image">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                            </div>




                                            <div class="alert alert-danger alert-dismissible col-md-offset-1 collapse" role="alert" id ="regFail">
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                              <center><strong>Error!</strong> Upload an image!</center>
                                          </div>
                                          <br>
                                          <button type="submit" name="submit" class="btn btn-primary col-md-offset-5 col-md-4" style="margin-left: center;margin-top: -20px;">Register</button>
                                          <br>
                                    </form>
                                    <div class="alert alert-success alert-dismissible col-md-offset-1 collapse" role="alert" id ="regSuccess">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <center><strong>Success!</strong> Registration Successful. <a href="login.php" class="alert-link">Click here to login.</a></center>
                                    </div>
                                </div>      
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" id ="personalDetails" style="margin-bottom: -9px; width: 100%; padding-left: 0px; padding-right: 0px;">
                        <div class="card bg-flat-color-5">
                            <div class="card-body" style="">
                                <h3 class=" white-color ">PERSONAL DETAILS</h4>
                            </div>
                        </div>
                    </div>

                    <!-- To Do and Live Chat -->
                    <div class="row" id="changePass" style="margin-left: 0px;">                        
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
                        

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title box-title">Live Chat</h4>
                                    <div class="card-content">
                                        <div class="messenger-box">
                                            <ul>
                                                <li>
                                                    <div class="msg-received msg-container">
                                                        <div class="avatar">
                                                           <img src="images/avatar/64-1.jpg" alt="">
                                                           <div class="send-time">11.11 am</div>
                                                       </div>
                                                       <div class="msg-box">
                                                        <div class="inner-box">
                                                            <div class="name">
                                                                John Doe
                                                            </div>
                                                            <div class="meg">
                                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis sunt placeat velit ad reiciendis ipsam
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- /.msg-received -->
                                            </li>
                                            <li>
                                                <div class="msg-sent msg-container">
                                                    <div class="avatar">
                                                       <img src="images/avatar/64-2.jpg" alt="">
                                                       <div class="send-time">11.11 am</div>
                                                    </div>
                                                    <div class="msg-box">
                                                        <div class="inner-box">
                                                            <div class="name">
                                                                John Doe
                                                            </div>
                                                            <div class="meg">
                                                                Hay how are you doing?
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div><!-- /.msg-sent -->
                                        </li>
                                    </ul>
                                    <div class="send-mgs">
                                        <div class="yourmsg">
                                            <input class="form-control" type="text">
                                        </div>
                                        <button class="btn msg-send-btn">
                                            <i class="pe-7s-paper-plane"></i>
                                        </button>
                                    </div>
                                </div><!-- /.messenger-box -->
                            </div>
                                </div> <!-- /.card-body -->
                            </div><!-- /.card -->
                        </div>
                    </div>
                    <!-- /To Do and Live Chat -->

                    <!-- Modal - Calendar - Add New Event -->
                    <div class="modal fade none-border" id="event-modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><strong>Add New Event</strong></h4>
                                </div>
                                <div class="modal-body"></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success save-event waves-effect waves-light">Create event</button>
                                    <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /#event-modal -->

                    <!-- Modal - Calendar - Add Category -->
                    <div class="modal fade none-border" id="add-category">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><strong>Add a category </strong></h4>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label">Category Name</label>
                                                <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name"/>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label">Choose Category Color</label>
                                                <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                                    <option value="success">Success</option>
                                                    <option value="danger">Danger</option>
                                                    <option value="info">Info</option>
                                                    <option value="pink">Pink</option>
                                                    <option value="primary">Primary</option>
                                                    <option value="warning">Warning</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /#add-category -->
                </div>
                <!-- .animated -->
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
        <!-- /#right-panel -->

        <!-- Scripts -->
</body>
        <script type="text/javascript">
            // $("#depTrigger").on('click',function(){
            //     $('html,body').animate({
            //         scrollTop: $('#depPerformance').offset().top-75
            //     }, 1000);
            // });

            // $("#facultyTrigger").on('click',function(){
            //     $('html,body').animate({
            //         scrollTop: $('#faculty').offset().top-75
            //     }, 1000);
            // });
            // $("#compareTrigger").on('click',function(){
            //     $('html,body').animate({
            //         scrollTop: $('#compare').offset().top-75
            //     }, 1000);
            // });
            // $("#topTrigger").on('click',function(){
            //     $('html,body').animate({
            //         scrollTop: $('#topFaculty').offset().top-75
            //     }, 1000);
            // });
            // $("#addFacultyTrigger").on('click',function(){
            //     $('html,body').animate({
            //         scrollTop: $('#addFaculty').offset().top-75
            //     }, 1000);
            // });
            // $("#addAdminTrigger").on('click',function(){
            //     $('html,body').animate({
            //         scrollTop: $('#addAdmin').offset().top-75
            //     }, 1000);
            // });
            // $("#addPerformanceTrigger").on('click',function(){
            //     $('html,body').animate({
            //         scrollTop: $('#addPerformance').offset().top-75
            //     }, 1000);
            // });
            // $("#changePassTrigger").on('click',function(){
            //     $('html,body').animate({
            //         scrollTop: $('#changePass').offset().top-75
            //     }, 1000);
            // });
            // $("#changePassTrigger1").on('click',function(){
            //     $('html,body').animate({
            //         scrollTop: $('#changePass').offset().top-75
            //     }, 1000);
            // });

            // $("#viewTrigger").on('click',function(){
            //     $('html,body').animate({
            //         scrollTop: $('#viewPerformance').offset().top-75
            //     }, 1000);
            // });

            // $("#manageTrigger").on('click',function(){
            //     $('html,body').animate({
            //         scrollTop: $('#manageDept').offset().top-75
            //     }, 1000);
            // });

            // $("#personalTrigger").on('click',function(){
            //     $('html,body').animate({
            //         scrollTop: $('#personalDetails').offset().top-75
            //     }, 1000);
            // });

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
        <script src="js/confirmPass.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
        <script src="assets/js/main.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/simpleweather@3.1.0/jquery.simpleWeather.min.js"></script>
        <script src="assets/js/init/weather-init.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
        <script src="assets/js/init/fullcalendar-init.js"></script>
    
</html>
