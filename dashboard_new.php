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

    $connect = mysqli_connect("localhost", "root", "", "faculty");
    $user_id= $_SESSION['id'];

    function YEARSUM1($YEAR,$USER_ID){
        $TOTALODD=MYPOINTS2($YEAR,'odd',$USER_ID);
        $TOTALEVEN=MYPOINTS2($YEAR,'even',$USER_ID);
        for ($i=0;$i<count($TOTALODD);$i++)
            $TOTALYEAR[$i]=round(($TOTALODD[$i]+$TOTALEVEN[$i])/2.0, 2);

        return $TOTALYEAR;
    }

    function MYPOINTS2($YEAR,$SEM,$USER_ID){
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

    function GET_COLLEGE_TOPPER($USER_ID,$SEM){
        $YEAR= GETYEAR($USER_ID);
        $YEAR = max($YEAR[0]);
        $connect = mysqli_connect("localhost", "root", "", "faculty");

        $query="SELECT user_id  FROM performance where year = '$YEAR' and sem='$SEM' and total_credits=(SELECT max(total_credits) FROM performance where year = '$YEAR' and sem='$SEM')" ;

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

    function GET_DEPT_TOPPER($USER_ID,$SEM)
    {
        $YEAR= GETYEAR($USER_ID);
        $YEAR = max($YEAR[0]);
        $DEPT=$_SESSION['dept'];
        $connect = mysqli_connect("localhost", "root", "", "faculty");

        $query = "SELECT DISTINCT user_id FROM performance WHERE year ='$YEAR' AND sem='$SEM' AND user_id IN (SELECT user_id FROM user WHERE dept = '$DEPT') ORDER BY total_credits DESC";

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

    function GETYEAR($USER_ID)
    {

        $def = [['2018-19'],['2017-18']];
        $connect = mysqli_connect("localhost", "root", "", "faculty");
        ;

        $query="SELECT max(year) FROM performance where user_id = '$USER_ID' order by year desc ";

        $year=mysqli_query($connect, $query);  
        $num = mysqli_num_rows($year);
        if ($num >= 0)
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

    function GETYEAR_ALL($USER_ID)
    {

        $def = [['2018-19'],['2017-18']];
        $connect = mysqli_connect("localhost", "root", "", "faculty");
        ;

        $query="SELECT DISTINCT year FROM performance where user_id = '$USER_ID' order by year desc ";

        $year=mysqli_query($connect, $query);  
        $num = mysqli_num_rows($year);
        if ($num >= 0)
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

        
    }


    function MYPOINTS($YEAR,$SEM,$USER_ID)
    {
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
        <meta charset="utf-8">
        <title>User - Faculty Analysis</title>
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
    </head>

    <body>
        <?php $user_name = $_SESSION['name']; 
            if(isset($_GET['msg']))
                echo '<script>$(document).ready(function(){$("#passSuccess").show();});</script>';
            if(isset($_GET['error']))
                echo '<script>$(document).ready(function(){$("#passFail").show();});</script>';
        ?>

        <!-- DASHBOARD -->
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
                        <li class="sidebarHeading"><a href="#comparePerformance" class="sliding-link"><i class="menu-icon fas fa-chart-line iclass" style="color:#03a9f3;"></i><b>COMPARISON</b></a></li>
                        <li><a href="#compareTopperEven" class="sliding-link"> <i class="menu-icon fas fa-school"></i>For Even Sem</a></li>
                        <li><a href="#compareTopperOdd" class="sliding-link"> <i class="menu-icon fas fa-school"></i>For Odd Sem</a></li>
                        
                        <li><a href="#prevYear" class="sliding-link"> <i class="menu-icon ti-ruler-pencil"></i>For Previous Years</a></li>
                        <li><a href="#topFaculty" class="sliding-link"> <i class="menu-icon fas fa-award"></i>View Toppers</a></li>
                        

                        <li class="sidebarHeading"><a href="#personalDetails" class="sliding-link"><i class="menu-icon fas fa-info-circle iclass" style="color:#03a9f3;"></i><b>MANAGE ACCOUNT</b></a></li>
                        <li><a href="#changePass" class="sliding-link"> <i class="menu-icon ti-key"></i>Change Password</a></li>
                        <li><a href="#changePass" class="sliding-link"> <i class="menu-icon ti-id-badge"></i>Edit Profile</a></li>
                        <li><a href="logout.php"> <i class="menu-icon fas fa-sign-out-alt"></i>Logout</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
        </aside>
        <!-- Right Panel -->
        <div id="right-panel" class="right-panel">
            <!-- TOP HEADER-->
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

                                <a class="nav-link" href="#changePass" class="sliding-link"><i class="fas fa-cog"></i>Settings</a>

                                <a class="nav-link" href="logout.php" ><i class="fas fa-power-off"></i>Logout</a>
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
                        <!-- YOUR SCORE -->
                        <div class="col-lg-3 col-md-6" >
                            <div class="card">
                                <div class="card-body">
                                    <a href="#mypoints">
                                    <div class="stat-widget-five" >
                                        <div class="stat-icon dib flat-color-1">
                                            <i class="pe-7s-star"></i>
                                        </div>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <?php
                                                    $USER_ID=$_SESSION['id'];
                                                    $YEAR=GETYEAR($USER_ID);
                                                    $YEAR = max($YEAR[0]);
                                                    $sql = "SELECT total_credits FROM performance WHERE user_id ='$USER_ID' and year='$YEAR' and sem='even'";
                                                    $res1 = mysqli_query($connect, $sql);
                                                    $row1 = mysqli_fetch_row($res1);
                                                    $num1 = mysqli_num_rows($res1);
                                                    if($num1==0)
                                                    {
                                                    $row1[0]=0;
                                                    }

                                                    $sq2 = "SELECT total_credits FROM performance WHERE user_id ='$USER_ID' and year='$YEAR' and sem='odd'";
                                                    $res2 = mysqli_query($connect, $sq2);
                                                    $row2 = mysqli_fetch_row($res2);
                                                    $num2 = mysqli_num_rows($res2);
                                                    if($num2==0)
                                                    {
                                                    $row2[0]=0;
                                                    }
                                                    $row=($row1[0]+$row2[0])/2;
                                                ?>
                                                <div class="stat-text"><span class="count"><?php echo number_format($row, 2, '.', '');?></span></div>
                                                <div class="stat-heading" >Your Score</div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- TOP SCORE -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="stat-widget-five">
                                        <div class="stat-icon dib flat-color-2">
                                            <i class="pe-7s-medal"></i>
                                        </div>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <?php
                                                $USER_ID=$_SESSION['id'];
                                                $YEAR=GETYEAR($USER_ID);
                                                $YEAR = max($YEAR[0]);
                                                $sql = "SELECT max(total_credits) FROM performance WHERE year='$YEAR' and sem='even'";
                                                $res1 = mysqli_query($connect, $sql);
                                                $row1 = mysqli_fetch_row($res1);
                                                $num1 = mysqli_num_rows($res1);
                                                if($num1==0)
                                                {
                                                $row1[0]=0;
                                                }

                                                $sq2 = "SELECT max(total_credits) FROM performance WHERE  year='$YEAR' and sem='odd'";
                                                $res2 = mysqli_query($connect, $sq2);
                                                $row2 = mysqli_fetch_row($res2);
                                                $num2 = mysqli_num_rows($res2);
                                                if($num2==0)
                                                {
                                                $row2[0]=0;
                                                }
                                                $row=($row1[0]+$row2[0])/2;

                                                ?>                                      
                                                <div class="stat-text"><?php echo number_format($row, 2, '.', '');?></span></div>
                                                <div class="stat-heading">Top Score</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DEPARTMENTS -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="stat-widget-five">
                                        <div class="stat-icon dib flat-color-3">
                                            <i class="menu-icon fas fa-school"></i>
                                        </div>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count">8</span></div>
                                                <div class="stat-heading">Departments</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- USERS -->
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
                                                        $res = mysqli_query($connect, "SELECT COUNT(*) FROM user WHERE user_type = 'user'");
                                                        $count = mysqli_fetch_row($res);
                                                    ?>
                                                <div class="stat-text"><span class="count"><?=$count[0]?></span></div>
                                                <div class="stat-heading">Users</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Widgets -->

                    <!-- HEADING - VIEW PERFORMANCE -->
                    <div class="col-md-4" id="viewPerformance" style="margin-bottom: -9px; width: 100%; padding-left: 0px; padding-right: 0px;">
                        <div class="card bg-flat-color-2">
                            <div class="card-body" style="">
                                <h3 class=" white-color ">MY PERFORMANCE</h4>
                            </div>
                        </div>
                    </div>

                    <!-- MY PERFORMANCE - EVEN SEM -->
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

                    <!-- MY PERFORMANCE - ODD SEM -->
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

                    <!-- MY PERFORMANCE - THIS YEAR -->
                    <div style="height:550px; overflow-y: hidden;margin-left:-12px;" id="thisYear">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title">ALL ABOUT THIS YEAR!!</h2> 
                                    <div>
                                        <?php 
                                            $USER_ID= $_SESSION['id'];
                                            $yr=GETYEAR($USER_ID);
                                            $i=0;

                                            foreach ($yr as $r) {
                                                $yrs[$i] = $r[0];
                                                $i++;
                                            }
                                            $YEAR1=max($yr);
                                            $EVEN='even';
                                            $ODD='odd';
                                            if(strlen($YEAR1[0]>1))
                                                $YEAR=$YEAR1[0];
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

                    <!-- HEADING - COMPARE PERFORMANCE -->
                    <div class="col-md-5" id="comparePerformance" style="margin-bottom: -9px; width: 100%; padding-left: 0px; padding-right: 0px;">
                        <div class="card bg-flat-color-2">
                            <div class="card-body" style="">
                                <h3 class=" white-color ">COMPARE PERFORMANCE</h4>
                            </div>
                        </div>
                    </div>      

                    <!-- COMPARISON - EVEN SEM -->
                    <div style="height:580px;margin-left:-12px;" id="compareTopperEven">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title">MY STATUS FOR EVEN SEM!</h2>
                                    <?php 
                                        $USER_ID=$_SESSION['id'];

                                        $yrs = array('Y1 No Data','Y2 No Data','Y3 No Data','Y4 No Data','Y5 No Data');

                                        $yr=GETYEAR($USER_ID);
                                        $YEAR = max($yr[0]);
                                        $COLL_TOPPER=GET_COLLEGE_TOPPER($USER_ID,'even');
                                        $DEPT_TOPPER=GET_DEPT_TOPPER($USER_ID,'even');
                                        
                                        echo chartLine(
                                            ['ATTENDANCE','PUBLICATIONS','RESEARCH','ORGANIZATIONS','ACTIVITIES','SEM RESULTS','STUDENT RATING'],
                                            [
                                                 ['name' => 'MY SCORE', 'data' => MYPOINTS($YEAR,'even',$USER_ID), 'type' => 'line'],
                                                 ['name' => 'DEPARTMENT TOPPER', 'data' =>MYPOINTS($YEAR,'even',$DEPT_TOPPER), 'type' => 'line'],
                                                 ['name' => 'COLLEGE TOPPER', 'data' => MYPOINTS($YEAR,'even',$COLL_TOPPER), 'type' => 'line']
                                            ],
                                            '' 
                                        );
                                    ?>
                                </div>
                            </div> 
                        </div>
                    </div>

                    <!-- COMPARISON - ODD SEM -->
                    <div style="height:580px;margin-left:-12px;" id="compareTopperOdd">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title">MY STATUS FOR ODD SEM!</h2>
                                    <?php 
                                        $USER_ID=$_SESSION['id'];
                                        $yrs = array('Y1 No Data','Y2 No Data','Y3 No Data','Y4 No Data','Y5 No Data');
                                        $yr=GETYEAR($USER_ID);
                                        $YEAR = max($yr[0]);
                                        $COLL_TOPPER=GET_COLLEGE_TOPPER($USER_ID,'odd');
                                        echo chartLine(
                                            ['ATTENDANCE','PUBLICATIONS','RESEARCH','ORGANIZATIONS','ACTIVITIES','SEM RESULTS','STUDENT RATING'],
                                            [
                                                ['name' => 'MY SCORE', 'data' => MYPOINTS($YEAR,'odd',$USER_ID), 'type' => 'line'],
                                                ['name' => 'DEPARTMENT TOPPER', 'data' => MYPOINTS($YEAR,'odd',$DEPT_TOPPER), 'type' => 'line'],
                                                ['name' => 'COLLEGE TOPPER', 'data' =>  MYPOINTS($YEAR,'odd',$COLL_TOPPER), 'type' => 'line']
                                            ],'' 
                                        );
                                    ?>
                                </div>
                            </div> 
                        </div>
                    </div>
                                        
                                     
                    <!-- COMPARISON - PREVIOUS YEARS -->
                    <div style="height:550px; overflow-y: hidden;margin-left:-12px;" id="prevYear">
                        <div class="col-sm-12 cardStyle">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title">DID I IMPROVE..?</h2> 
                                   <?php 
                                       $yr=GETYEAR_ALL($USER_ID);
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
                                            'FOR PAST 5 YEARS'                                                
                                        );
                                    ?>
                                </div>
                            </div> 
                        </div>
                    </div>
                       
                    <!-- TOPPERS -->
                    <div class="orders" id="topFaculty">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="card-title">RANK LIST FOR THIS YEAR! </h2>
                                    </div>
                                    <div class="card-body--">
                                        <?php
                                            $YEAR= GETYEAR($USER_ID);
                                            $YEAR = max($YEAR[0]);
                                            $DEPT=$_SESSION['dept'];
                                            
                                            $sql = "SELECT DISTINCT user_id FROM performance WHERE year ='$YEAR'  ORDER BY total_credits DESC";
                                            $res = mysqli_query($connect, $sql)  or die(mysqli_error($connect));
                                            while ($row = mysqli_fetch_array($res)){ 
                                                $user_ids[] = $row['user_id'];
                                            }
                                            $topUserCount = mysqli_num_rows($res);

                                            // construct query to obtain user details
                                            $sql = "SELECT name, profile_pic,dept FROM user WHERE user_id = $user_ids[0]";
                                            for($i = 1 ; $i < $topUserCount ; $i++)
                                                $sql .= " OR user_id = $user_ids[$i]";                                                   
                                                
                                            $res = mysqli_query($connect, $sql)  or die(mysqli_error($connect));
                                            while($row = mysqli_fetch_array($res)){
                                                $names[] = $row['name'];
                                                $pics[] = $row['profile_pic'];
                                                $dept[]=$row['dept'];
                                            }
                                            for($i = 0 ; $i < $topUserCount ; $i++){
                                                $userCredits = YEARSUM1($YEAR, $user_ids[$i]);
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
                                                            <td><span class='badge badge-complete'>$dept[$i]</span></td>
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
                    
                    <!-- HEADING - MANAGE ACCOUNT -->
                    <div class="col-md-4" id ="personalDetails" style="padding-bottom: 5px; width: 100%; padding-left: 0px; padding-right: 0px;">
                        <div class="card bg-flat-color-2">
                            <div class="card-body" >
                                <h3 class=" white-color ">MANAGE ACCOUNT</h4>
                            </div>
                        </div>
                    </div>
                    <!-- CHANGE PASSWORD AND EDIT PROFILE-->
                    <div class="row" id="changePass" style="margin-left: 0px;">      
                        <!-- CHANGE PASSWORD -->
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

                        <!-- EDIT PROFILE -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title box-title">Edit Profile</h4>
                                    <div class="card-content">
                                        <br><p style="font-size: 50px;line-height: 50px;">Feature Coming Soon!<br>Stay Tuned.</p>
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

        <!-- SCRIPTS -->
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
        <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
        <script src="js/confirmPass.js"></script>
    </body>
</html>
