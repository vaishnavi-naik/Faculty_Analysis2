<?php
    header('Content-Type: text/html; charset=utf-8');
    require('include/connection.php');

    // redirects to the login page if the user isn't loggeed in
    if(!isset($_SESSION['type'])){
        header('location:login.php');
    }

    // only allows admins access to the page, redirects others to the index page
    if(isset($_SESSION['type']) && $_SESSION['type']!='Admin')
        header('location:index.php');

    require('./vendor/autoload.php');

    // renders a chart for the given data using the EchartsPHP library
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

    // returns an array of the different credit values for the given sem and year of the given user
    function MYPOINTS($YEAR,$SEM,$USER_ID){
        $connect = mysqli_connect("localhost", "root", "", "faculty");
        $query = "SELECT DISTINCT academic_id, student_id, perf_id FROM performance WHERE user_id = '$USER_ID' and year='$YEAR' and sem='$SEM'" ;

        if((mysqli_query($connect, $query) ) or die(mysqli_error($connect)))
        {  
            $res=mysqli_query($connect, $query); 
            $row = mysqli_fetch_row($res);
            
            $academic_id=$row[0];
            $stud_id=$row[1];
            $perf_id=$row[2];

            $query1 = "SELECT * FROM `academic_performance` WHERE academic_id='$academic_id'" ;
            $academic=mysqli_query($connect, $query1); 
            $ad = mysqli_fetch_row($academic);
            $num = mysqli_num_rows($academic);

            $query2 = "SELECT * FROM `student_performance` WHERE student_id='$stud_id'" ;
            $student=mysqli_query($connect, $query2); 
            $sd = mysqli_fetch_row($student);
            $num1 = mysqli_num_rows($student);

            $query3 = "SELECT total_credits FROM `performance` WHERE perf_id ='$perf_id'" ;
            $student=mysqli_query($connect, $query3); 
            $pd = mysqli_fetch_row($student);
            $num2 = mysqli_num_rows($student);

            if($num==0)
                $ad = array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0);

            if($num1==0)
                $sd = array(0.0,0.0,0.0,0.0,0.0,0.0);
            
            if($num2==0)
                $pd = array(0.0);
            
            $MYPOINTS_SEM[0]=$ad[4];
            $MYPOINTS_SEM[1]=$ad[2];
            $MYPOINTS_SEM[2]=$ad[8];
            $MYPOINTS_SEM[3]=$ad[6];
            $MYPOINTS_SEM[4]=$ad[10];
            $MYPOINTS_SEM[5]=$sd[4];
            $MYPOINTS_SEM[6]=$sd[1];
            $MYPOINTS_SEM[7]=$ad[11];
            $MYPOINTS_SEM[8]=$sd[5];
            $MYPOINTS_SEM[9]=$pd[0];

            return $MYPOINTS_SEM;
        }
    }

    // returns an array of the different credit values for the given sem and year of the given user
    function MYPOINTS2($YEAR,$SEM,$USER_ID){
        $connect = mysqli_connect("localhost", "root", "", "faculty");
        $query = "SELECT DISTINCT academic_id, student_id, perf_id FROM performance WHERE user_id = '$USER_ID' and year='$YEAR' and sem='$SEM'" ;

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

    // return the sum of the credits for the even and odd sem of the given year
    function YEARSUM($YEAR,$USER_ID){
        $TOTALODD=MYPOINTS2($YEAR,'odd',$USER_ID);
        $TOTALEVEN=MYPOINTS2($YEAR,'even',$USER_ID);
        for ($i=0;$i<count($TOTALODD);$i++)
            $TOTALYEAR[$i]=round(($TOTALODD[$i]+$TOTALEVEN[$i])/2.0, 2);

        return $TOTALYEAR;
    }

    function YEARSUM1($YEAR,$USER_ID){
        $TOTALODD=MYPOINTS($YEAR,'odd',$USER_ID);
        $TOTALEVEN=MYPOINTS($YEAR,'even',$USER_ID);
        for ($i=0;$i<count($TOTALODD);$i++)
            $TOTALYEAR[$i]=round(($TOTALODD[$i]+$TOTALEVEN[$i])/2.0, 2);

        return $TOTALYEAR;
    }

    function GETYEAR($USER_ID)
    {

        $def = ['2014-19','2017-18'];
        $connect = mysqli_connect("localhost", "root", "", "faculty");

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

?>

<!doctype html>
<html class="no-js" lang="en">
    <head>
        
        <meta charset="utf-8">
        <title>Admin - Faculty Analysis</title>
        <meta name="description" content="Faculty Analysis">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="newfav.ico" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">

        <link rel="stylesheet" type="text/css" href="css/all.css">
        <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
        <script src="js/confirmPass.js"></script>

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
            th, td{
                text-align: center;
            }
            #loading {
            /*background: white;*/
            background: #f1f2f7;
            position: absolute;
            height: 5000px;
            width: 100%;
            z-index: 999999;
        }
        </style>
    </head>

    <body>
        <!-- PHP CODE TO TRIGGER THE ALERTS FOR CHANGE PASSWORD AND USER/ADMIN REGISTRATION-->
        <?php 
            $user_name = $_SESSION['name']; 
            $adminDept = $_SESSION['dept'];
            if(isset($_GET['msg']))
                echo '<script>$(document).ready(function(){$("#passSuccess").show();});</script>';
            if(isset($_GET['error']))
                echo '<script>$(document).ready(function(){$("#passFail").show();});</script>';
            if(isset($_GET['userError']))
                echo '<script>$(document).ready(function(){$("#regFailUser").show();});</script>';
            if(isset($_GET['adminError']))
                echo '<script>$(document).ready(function(){$("#regFailAdmin").show();});</script>';
            if(isset($_GET['userSuccess']))
                echo '<script>$(document).ready(function(){$("#regSuccessUser").show();});</script>';
            if(isset($_GET['adminSuccess']))
                echo '<script>$(document).ready(function(){$("#regSuccessAdmin").show();});</script>';
        ?>
        <!-- Left Panel -->
        <!-- Dashboard -->
        <aside id="left-panel" class="left-panel">
            <nav class="navbar navbar-expand-sm navbar-default navbar-fixed" id="myNav">
                <div id="main-menu" class="main-menu collapse navbar-collapse">
                    <ul class="nav navbar-nav list-group">
                        <li class="active">
                            <a  href="admin_dash.php" class="sliding-link"><i class="menu-icon fa fa-laptop"></i>Dashboard</a>
                        </li>
                        <!-- <li class="active">
                            <a id="menuToggle1" style="cursor:pointer;"><i class="menu-icon fa fa-laptop"></i>Dashboard</a>
                        </li> -->

                        <li class="sidebarHeading"><a href="#viewPerformance" class="sliding-link"  style="color:#03a9f3; font-weight: 900;"><i class="menu-icon fas fa-chart-line iclass" style="color:#03a9f3; font-weight: 900;"></i>View Performance</a></li><!-- /.menu-title -->
                        <li><a href="#depPerformance" class="sliding-link"> <i class="menu-icon fas fa-school"></i>Department </a></li>
                        <li><a href="#faculty" class="sliding-link" > <i class="menu-icon fas fa-user-alt"></i>Faculty </a></li>
                        <li><a href="#compare" class="sliding-link"> <i class="menu-icon ti-ruler-pencil"></i>Compare </a></li>
                        <li><a href="#topFaculty" class="sliding-link"> <i class="menu-icon fas fa-award"></i>Top Faculty </a></li>

                        <li class="sidebarHeading"><a href="#manageDept" class="sliding-link" style="color:#03a9f3; font-weight: 900;"><i class="menu-icon fas fa-code-branch iclass" style="color:#03a9f3;"></i>Manage</a></li><!-- /.menu-title -->
                        <li><a href="#addFaculty" class="sliding-link"> <i class="menu-icon fas fa-user-plus"></i>Faculty </a></li>
                        <li><a href="#addAdmin" class="sliding-link"> <i class="menu-icon fas fa-user-plus"></i>Admin </a></li>
                        <li><a href="#addPerformance" class="sliding-link"> <i class="menu-icon fas fa-stopwatch"></i>Performance Details </a></li>
                        
                        <li class="sidebarHeading"><a href="#personalDetails" class="sliding-link" style="color:#03a9f3; font-weight: 900;"><i class="menu-icon fas fa-info-circle iclass" style="color:#03a9f3;"></i>Personal Details</a></li><!-- /.menu-title -->
                        <li><a href="#changePass" class="sliding-link"> <i class="menu-icon ti-id-badge"></i>Edit Profile</a></li>
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
                                      echo '<img src="data:image/jpeg;base64,'.base64_encode($row['profile_pic'] ).'" class="user-avatar rounded-circle" height=40 width=40/>'; 
                                  }else 
                                  echo '<img class="user-avatar rounded-circle" src="img/dummy.png" alt="User">';
                              }
                              ?>
                          </a>

                          <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#changePass"><i class="fas fa-user"></i>My Profile</a>

                            <!-- <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a> -->

                            <a class="nav-link" href="#changePass" id="changePassTrigger1"><i class="fas fa-cog"></i>Settings</a>

                            <a class="nav-link" href="logout.php"><i class="fas fa-power-off"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            </header>
            <!-- /#header -->

            <!-- LOADING GIF APPEARS AS THE PAGE LOADS -->
            <div id="loading">
                <!-- <img src="img/loading1.gif" style="margin-left: 120px;" /> -->
                <img src="img/loading2.gif" style="margin-left: 350px;margin-top: 140px;" />
            </div>
            <!-- Content -->
            <div id="content">
            <div class="content">
                <!-- Animated -->
                <div class="animated fadeIn" id="contentDivs">
                    <!-- Widgets Top Small Cards -->
                    <div class="row" id="widgets">
                        <div class="col-lg-3 col-md-6" >
                            <div class="card">
                                <div class="card-body">
                                        <div class="stat-widget-five" >
                                            <div class="stat-icon dib flat-color-1">
                                                <i class="pe-7s-medal"></i>
                                            </div>
                                            <div class="stat-content">
                                                <div class="text-left dib">
                                                    <?php
                                                        $sql = "SELECT AVG(total_credits) FROM performance WHERE user_id IN(SELECT user_id FROM user WHERE dept = '$adminDept')";
                                                        $res = mysqli_query($connect, $sql);
                                                        $row = mysqli_fetch_row($res);
                                                    ?>
                                                    <!-- <div class="stat-text"><span class="count"></span></div> -->
                                                    <div class="stat-text"><?php echo number_format($row[0], 2, '.', '');?></div>
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
                                                <?php 
                                                    $sql = "SELECT user_id,avg(total_credits) FROM performance WHERE year='2018-19'group by user_id ORDER BY total_credits DESC LIMIT 1";
                                                    $res = mysqli_query($connect, $sql);
                                                    $row = mysqli_fetch_row($res);
                                                    $topper_id = $row[0];
                                                    $sql = "SELECT name FROM user WHERE user_id = $topper_id";
                                                    $res = mysqli_query($connect, $sql);
                                                    $row = mysqli_fetch_row($res);

                                                ?>
                                                <div class="stat-text"><?=$row[0]?></div>
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
                                                <?php 
                                                    $res = mysqli_query($connect, "SELECT SUM(tot_pub) FROM academic_performance WHERE academic_id IN (SELECT academic_id FROM performance WHERE user_id IN (SELECT user_id from user WHERE dept = '$adminDept') )");
                                                    $count = mysqli_fetch_row($res);
                                                ?>
                                                <div class="stat-text"><span class="count"><?=$count[0]?></span></div>
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
                                                <?php 
                                                    $res = mysqli_query($connect, "SELECT COUNT(*) FROM user WHERE dept = '$adminDept'");
                                                    $count = mysqli_fetch_row($res);
                                                ?>
                                                <div class="stat-text"><span class="count"><?=$count[0]?></span></div>
                                                <div class="stat-heading">Members</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- HEADING - VIEW PERFORMANCE -->
                    <div class="col-md-5" id="viewPerformance" style="margin-bottom: -9px; width: 100%; padding-left: 0px; padding-right: 0px;">
                        <div class="card bg-flat-color-2">
                            <div class="card-body" style="">
                                <h2 class=" white-color ">VIEW PERFORMANCE</h2>
                            </div>
                        </div>
                    </div>

                    <!-- DEPARTMENT PERFORMANCE -->
                    <div style="height:525px; margin-left: 0px; overflow-y: hidden;" id="depPerformance">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">YOUR DEPARTMENT </h3> 
                                    <div  >
                                        <?php 
                                        $sql_academic = "SELECT AVG(att_credits),AVG(pub_credits),AVG(res_credits),AVG(ext_credits) FROM academic_performance WHERE academic_id IN (SELECT academic_id FROM performance WHERE user_id IN (SELECT user_id from user WHERE dept = '$adminDept') AND year = '2018-19')";
                                        $res_academic = mysqli_query($connect, $sql_academic);
                                        $row_academic = mysqli_fetch_row($res_academic);

                                        $sql_student = "SELECT AVG(pass_credits), AVG(stud_credits) FROM student_performance WHERE student_id IN(SELECT academic_id FROM performance WHERE user_id IN (SELECT user_id from user WHERE dept = '$adminDept') AND year = '2018-19')";
                                        $res_student = mysqli_query($connect, $sql_student);
                                        $row_student = mysqli_fetch_row($res_student);

                                        $tot_result = array_merge($row_academic, $row_student);

                                         
                                        echo chartLine(
                                            ['ATTENDANCE','PUBLICATIONS','RESEARCH','EXTRA CURRICULUM','SEM RESULTS','STUDENT RATING'],
                                            [
                                                ['name' => '2018-19', 'data' => $tot_result, 'type' => 'line']
                                            ],
                                            'Department Performance'                                                
                                        );
                                        ?>
                                    </div>
                                </div> 
                            </div>
                        </div><!-- /# column -->
                    </div>

                    <!-- FACULTY PERFORMANCE -->
                    <div style="height:600px; margin-left: 0px; overflow-y: hidden;" id="faculty" >
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body" id="faculty">
                                    <h3 class="card-title">VIEW FACULTY PERFORMANCE</h3>
                                    <div class="col-sm-12" style="margin-left: 0px;" >
                                        <form action="#faculty" method="GET" class="form-inline">
                                            <div class="form-group inline col-md-12">
                                                <label for="faculty_name">Select Faculty:</label>
                                                <select name="faculty_name" style="margin-left: 20px;" class="form-control col-md-4">
                                                    <?php
                                                    $dept = $_SESSION['dept'];
                                                    $query = "SELECT user_id, name FROM user WHERE user_type = 'User' AND dept = '$dept' AND user_id IN (SELECT DISTINCT user_id FROM performance)";
                                                    $result = mysqli_query($connect, $query);
                                                    $num = mysqli_num_rows($result);
                                                    while($array = mysqli_fetch_array($result)){
                                                        $opt_val = $array['user_id'];
                                                        $opt_content = $array['name'];
                                                        echo "<option value = $opt_val>$opt_content</option>";
                                                    }?>                                      
                                                </select>
                                                <button id="facultySubmit" value="facultySubmit" style="margin-left: 20px;" class="btn btn-primary" type="submit">GO</button>    
                                            </div>
                                        </form>
                                         <?php if(isset($_GET['faculty_name'])){?>
                                        <div id="facultyDetails" style="height: 400px;margin-top: 50px;">
                                           
                                            <div class="col-sm-12" style="margin-left: 0px;">
                                                <?php 
                                                    $USER_ID = $_GET['faculty_name'];
                                                    $sql = "SELECT name FROM user WHERE user_id = $USER_ID";
                                                    $res = mysqli_query($connect, $sql);
                                                    $row = mysqli_fetch_row($res);


                                                    $yr=GETYEAR($USER_ID);
                                                    $i=0;

                                                    $yrs = array('Y1 No Data','Y2 No Data','Y3 No Data','Y4 No Data','Y5 No Data');

                                                    foreach ($yr as $r) {
                                                       $yrs[$i] = $r[0];
                                                       $i++;                                                     
                                                    }
                                                   
                                                    echo chartLine(
                                                    ['ATTENDANCE','PUBLICATIONS','RESEARCH','ORGANIZATIONS','ACTIVITIES','SEM RESULTS','STUDENT RATING'],
                                                    [

                                                        ['name' => $yrs[0], 'data' => YEARSUM($yrs[0],$USER_ID), 'type' => 'line'],
                                                        ['name' => $yrs[1], 'data' => YEARSUM($yrs[1],$USER_ID), 'type' => 'line'],
                                                        ['name' => $yrs[2], 'data' => YEARSUM($yrs[2],$USER_ID), 'type' => 'line'],
                                                        ['name' => $yrs[3], 'data' => YEARSUM($yrs[3],$USER_ID), 'type' => 'line'],
                                                        ['name' => $yrs[4], 'data' => YEARSUM($yrs[4],$USER_ID), 'type' => 'line']
                                                    ],
                                                    "$row[0]");
                                                ?>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- COMPARE DEPARTMENT PERFORMANCE -->
                    <div style="height:525px; overflow-y: hidden; margin-top: 10px;" id="compare" >
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body" id="">
                                    <h3 class="card-title">COMPARE DEPARTMENTS</h3>
                                    <div class="col-sm-12" style="margin-left: 0px;" >
                                        <?php 
                                        echo chartLine(
                                            ['ATTENDANCE','PUBLICATIONS','RESEARCH','EXTRA CURRICULUM','SEM RESULTS','STUDENT RATING'],
                                            [
                                                ['name' => 'Your Department', 'data' => $tot_result],
                                                ['name' => 'Dept 2', 'data' => [9,9,6,12,6,3]],
                                                ['name' => 'Dept 3', 'data' => [8,6,4,3,7,2]],
                                                ['name' => 'Dept 4', 'data' => [7,4,8,7,6,6]],
                                                ['name' => 'Dept 5', 'data' => [6,7,6,9,4,7]],
                                            ],
                                            'Compare 2018-19'                                                
                                        );
                                        ?>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <!-- TOP FACULTY DETAILS -->
                    <div class="orders" id="topFaculty">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="box-title">TOP FACULTY IN YOUR DEPARTMENT</h4>
                                    </div>
                                    <div class="card-body--">
                                        <?php
                                                
                                                $sql = "SELECT DISTINCT user_id FROM performance WHERE year ='2018-19' AND user_id IN (SELECT user_id FROM user WHERE dept = '$adminDept') ORDER BY total_credits DESC";
                                                $res = mysqli_query($connect, $sql)  or die(mysqli_error($connect));
                                                while ($row = mysqli_fetch_array($res)){ 
                                                    $user_ids[] = $row['user_id'];
                                                }
                                                $topUserCount = mysqli_num_rows($res);

                                                // construct query to obtain user details
                                                $sql = "SELECT name, profile_pic FROM user WHERE user_id = $user_ids[0]";
                                                for($i = 1 ; $i < $topUserCount ; $i++)
                                                    $sql .= " OR user_id = $user_ids[$i]";                                                   
                                                    
                                                $res = mysqli_query($connect, $sql)  or die(mysqli_error($connect));
                                                while($row = mysqli_fetch_array($res)){
                                                    $names[] = $row['name'];
                                                    $pics[] = $row['profile_pic'];
                                                }
                                                for($i = 0 ; $i < $topUserCount ; $i++){
                                                    $userCredits = YEARSUM1('2018-19', $user_ids[$i]);
                                                    $academic_credits[] = $userCredits[7];
                                                    $student_credits[] = $userCredits[8];
                                                    $overall_credits[] = $userCredits[9];
                                                }
                                            ?>  
                                        <div class="table-stats order-table ov-h">
                                           
                                            
                                            <table class="table ">
                                                <thead>
                                                    <tr>
                                                        <th class="serial">#</th>
                                                        <th class="avatar">Image</th>
                                                        <!-- <th>something</th> -->
                                                        <th>Name</th>
                                                        <th>Academic Credits</th>
                                                        <th>Student Credits</th>
                                                        <th>Overall Credits</th>
                                                        <th>Department</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                
                                                    <?php
                                                    for($i = 0 ; $i < $topUserCount ; $i++){
                                                        $rank = $i+1;
                                                        echo "<tr><td>$rank.</td>";
                                                        if($pics[$i] == NULL)
                                                            echo '<td><img class="user-avatar rounded-circle" src="img/dummy.png" alt="User" height="24" width="24"></td>';
                                                        else echo "<td><img class='user-avatar rounded-circle' src='data:image/jpeg;base64,".base64_encode($pics[$i])." height='24' width='24' class='img-thumnail'/></td>";
                                                        echo "
                                                        <td>$names[$i]</td>
                                                        <td>$academic_credits[$i]</td>
                                                        <td>$student_credits[$i]</td>
                                                        <td>$overall_credits[$i]</td>
                                                        <td><span class='badge badge-complete'>$adminDept</span></td>
                                                        </tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div> <!-- /.table-stats -->
                                    </div>
                                </div> <!-- /.card -->
                            </div>  <!-- /.col-lg-8 -->
                        </div>
                    </div>

                    <!-- HEADING - MANAGE DEPARTMENT -->
                    <div class="col-md-5" id="manageDept" style="margin-bottom: -9px; width: 100%; padding-left: 0px; padding-right: 0px;">
                        <div class="card bg-flat-color-6" >
                            <div class="card-body" style="">
                                <h3 class=" white-color ">MANAGE DEPARTMENT</h4>
                            </div>
                        </div>
                    </div>
               
                    <!-- ADD FACULTY -->
                    <div style="margin-bottom: 25px; " id="addFaculty">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body" id="depPerformance">
                                    <p style="font-size:20px;">ADD FACULTY </p> <hr>
                                        <form action="reg_submit.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-4 control-label">Name</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="dept" class="col-sm-4 control-label">Department</label>
                                                <div class="col-sm-5">
                                                    <select name="dept" id="dept" class="form-control">
                                                        <option value="cse" selected="true"> Computer Science and Engineering</option>
                                                        <option value="cve"> Civil Engineering</option>
                                                        <option value="ce"> Chemical Engineering</option>
                                                        <option value="eee"> Electronics and Electrical Engineering </option>
                                                        <option value="ece"> Electronics and Communication </option>
                                                        <option value="bca">Bachelor of Computer Applications</option>
                                                        <option value="mba">Master of Business Administration</option>
                                                        <option value="me"> Mechanical Engineering</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="email" class="col-sm-4 control-label">Register As</label>
                                                <div class="col-sm-5">
                                                 <input readonly class="form-control" id="utype" name="utype" value="User">
                                             </div>
                                            </div>

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
                                                <label for="image" class="col-sm-4 control-label" >Upload Image:</label>
                                                <div class="custom-file " style="margin-left: 15px; width:385px;">
                                                    <input type="file" class="custom-file-input" id="image">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                            </div>

                                            <div class="alert alert-danger alert-dismissible offset-md-2 col-md-8 collapse" role="alert" id ="regFailUser">
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                              <center><strong>Error!</strong> <?php $error = $_GET['userError']; echo "$error"; ?></center>
                                            </div>

                                            <br>
                                            <button type="submit" name="submit" class="btn btn-primary col-md-offset-5 col-md-4" style="margin-left: center;margin-top: -20px;">Register</button>
                                            <br>
                                        </form><br>
                                        <div class="alert alert-success alert-dismissible offset-md-3 col-md-6 collapse" role="alert" id ="regSuccessUser">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <center><strong>Success!</strong> Registration Successful.</center>
                                        </div>
                                </div>                   
                            </div>
                        </div>
                    </div>

                    <!-- ADD ADMIN -->
                    <div style="margin-bottom: 25px; " id="addAdmin">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body" id="depPerformance">
                                    <p style="font-size:20px;">ADD ADMIN </p> <hr>
                                    <form class="form-horizontal" action="reg_submit.php" method="post" enctype="multipart/form-data">

                                            <div class="form-group row">
                                                <label for="name" class="col-sm-4 control-label">Name</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"required="true">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="dept" class="col-sm-4 control-label">Department</label>
                                                <div class="col-sm-5">
                                                    <select name="dept" id="dept" class="form-control">
                                                        <option value="cse" selected="true"> Computer Science and Engineering</option>
                                                        <option value="cve"> Civil Engineering</option>
                                                        <option value="ce"> Chemical Engineering</option>
                                                        <option value="eee"> Electronics and Electrical Engineering </option>
                                                        <option value="ece"> Electronics and Communication </option>
                                                        <option value="bca">Bachelor of Computer Applications</option>
                                                        <option value="mba">Master of Business Administration</option>
                                                        <option value="me"> Mechanical Engineering</option>
                                                     
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="email" class="col-sm-4 control-label">Register As</label>
                                                <div class="col-sm-5">
                                                 <input readonly class="form-control" id="utype" name="utype" value="Admin">
                                             </div>
                                            </div>

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
                                                <label for="image" class="col-sm-4 control-label" >Upload Image:</label>
                                                <div class="custom-file " style="margin-left: 15px; width:385px;">
                                                    <input type="file" class="custom-file-input" id="image">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                            </div>

                                            <div class="alert alert-danger alert-dismissible offset-md-2 col-md-8 collapse" role="alert" id ="regFailAdmin">
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                              <center><strong>Error!</strong> <?php $error = $_GET['adminError']; echo "$error"; ?></center>
                                            </div>
                                          <br>
                                          <button type="submit" name="submit" class="btn btn-primary col-md-offset-5 col-md-4" style="margin-left: center;margin-top: -20px;">Register</button>
                                          <br>
                                    </form><br>
                                    <div class="alert alert-success alert-dismissible offset-md-3 col-md-6 collapse" role="alert" id ="regSuccessAdmin">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <center><strong>Success!</strong> Registration Successful.</center>
                                    </div>
                                </div>      
                            </div>
                        </div>
                    </div>

                    <!-- ADD PERFORMANCE -->
                    <div style="height:890px; overflow-y: hidden; " id="addPerformance">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body" id="depPerformance">
                                    <p style="font-size:20px;">ADD FACULTY PERFORMANCE</p> <hr>
                                    <h1 class="box-title">ADD PERFORMANCE </h1> 
                                        <form action="performance_submit.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label for="faculty_name" class="col-sm-4 col-form-label">Select Faculty:</label>
                                                <div class="col-sm-4">
                                                    <select name="faculty_name" id="faculty_name" class="form-control">
                                                        <!-- fetching faculty names from the database -->
                                                        <?php
                                                            $dept = $_SESSION['dept'];
                                                            $query = "SELECT user_id, name FROM user WHERE user_type = 'User' AND dept = '$dept'";
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

                    <!-- HEADING - PERSONAL DETAILS -->
                    <div class="col-md-4" id ="personalDetails" style="margin-bottom: -9px; width: 100%; padding-left: 0px; padding-right: 0px;">
                        <div class="card bg-flat-color-5">
                            <div class="card-body" style="">
                                <h3 class=" white-color ">PERSONAL DETAILS</h4>
                            </div>
                        </div>
                    </div>

                    <!-- CHANGE PASSWORD -->
                    <div class="row" id="changePass" style="margin-left: 0px;">                        
                        <div class="card col-lg-6">
                            <div class="card-body">
                                <h4 class="card-title box-title">Change Password</h4>
                                <div class="card-content">
                                    <form class="form-horizontal" action="change_password.php" method= "POST" id="passForm">
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
                        
                        <!-- EDIT PROGILE -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title box-title">Edit Profile</h4>
                                    <div class="card-content">
                                        <br><p style="font-size: 50px;line-height: 50px;">Feature Coming Soon!<br>Stay Tuned.</p>
                                    </div>
                                </div> <!-- /.card-body -->
                            </div><!-- /.card -->
                        </div>
                    </div>
                    
                </div>
                <!-- .animated -->
            </div>
            <!-- /.content -->
            <div class="clearfix"></div>

            <!-- Footer -->
            <footer class="site-footer" style="margin-top: 30px;">
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
        </div>
        </div>
        <!-- /#right-panel -->

        <!-- SCRIPTS -->
        <!-- LOCAL SCRIPTS -->
        <script type="text/javascript">

            $(window).ready(function() {
                $('#loading').hide();
            });

            $('.custom-file input').change(function (e) {
                $(this).next('.custom-file-label').html(e.target.files[0].name);
            });

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

            $(document).ready(function(){

               $("div").mouseenter(function(){
                 var id = $(this).attr('id');
                 $('a').removeClass('active');
                 $("[href=#"+id+"]").addClass('active');
               });

            });
        </script>

        <!-- OTHER SCRIPTS -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
        <script src="js/confirmPass.js"></script>

    </body>
</html>
