<?php
    header('Content-Type: text/html; charset=utf-8');
    require('include/connection.php');



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

    function MYPOINTS($YEAR,$SEM,$USER_ID){
        $connect = mysqli_connect("localhost", "root", "", "faculty");

        $MYPOINTS_EVEN= array(0.0,0.0,0.0,0.0,0.0,0.0,0.0);
        $MYPOINTS_ODD= array(0.0,0.0,0.0,0.0,0.0,0.0,0.0);

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
                {
                    $ad = array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0);
                }

                if($num1==0)
                {
                    $sd = array(0.0,0.0,0.0,0.0,0.0,0.0);
                }
                if($num2==0)
                {
                    $pd = array(0.0);
                }
                
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
        $div=2.0;
        $TOTALODD=MYPOINTS2($YEAR,'odd',$USER_ID);
        $TOTALEVEN=MYPOINTS2($YEAR,'even',$USER_ID);
        if(($TOTALODD[0]==0.0)or($TOTALEVEN[0]==0.0))
        {
            $div=1.0;
        }
        for ($i=0;$i<count($TOTALODD);$i++)
            $TOTALYEAR[$i]=round(($TOTALODD[$i]+$TOTALEVEN[$i])/$div, 2);

        return $TOTALYEAR;
    }

    function YEARSUM1($YEAR,$USER_ID){
        $div=2.0;

        $TOTALODD=MYPOINTS($YEAR,'odd',$USER_ID);
        $TOTALEVEN=MYPOINTS($YEAR,'even',$USER_ID);
        if(($TOTALODD[0]==0.0)or($TOTALEVEN[0]==0.0))
        {
            $div=1.0;
        }
        for ($i=0;$i<count($TOTALODD);$i++)
            $TOTALYEAR[$i]=round(($TOTALODD[$i]+$TOTALEVEN[$i])/$div, 2);

        return $TOTALYEAR;
    }


?>


<!doctype html>
<html class="no-js" lang="en">
    <head>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>TEST - Faculty Analysis</title>
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
        <style type="text/css">
        .cardStyle{
          padding-left: 0px;
          padding-right: 0px;
        }
        th, td {
            text-align: center;
        }
        #loading {
            background: url('img/loading1.gif') no-repeat center center;
            position: absolute;
            height: 100%;
            width: 100%;
            margin-left:-140px;
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
                    <ul class="nav navbar-nav">

                        <li class="active">
                            <a id="menuToggle1" style="cursor:pointer;"><i class="menu-icon fa fa-laptop"></i>Dashboard</a>
                        </li>

                        <li class="menu-title"><a href="#viewPerformance" id="viewTrigger">View Performance</a></li><!-- /.menu-title -->
                        <li><a href="#depPerformance" id="depTrigger"> <i class="menu-icon fas fa-school"></i>Department </a></li>
                        <li><a href="#faculty" id="facultyTrigger"> <i class="menu-icon fas fa-user-alt"></i>Faculty </a></li>
                        <li><a href="#compare" id="compareTrigger"> <i class="menu-icon ti-ruler-pencil"></i>Compare </a></li>
                        <li><a href="#topFaculty" id="topTrigger"> <i class="menu-icon fas fa-award"></i>Top Faculty </a></li>

                        <li class="menu-title"><a href="#manageDept" id="manageTrigger">Manage</a></li><!-- /.menu-title -->
                        <li><a href="#addFaculty" id="addFacultyTrigger"> <i class="menu-icon fas fa-user-plus"></i>Faculty </a></li>
                        <li><a href="#addAdmin" id="addAdminTrigger"> <i class="menu-icon fas fa-user-plus"></i>Admin </a></li>
                        <li><a href="#addPerformance" id="addPerformanceTrigger"> <i class="menu-icon fas fa-stopwatch"></i>Performance Details </a></li>
                        
                        <li class="menu-title"><a href="#personalDetails" id="personalTrigger">Personal Details</a></li><!-- /.menu-title -->
                        <li><a href="#"> <i class="menu-icon ti-id-badge"></i>Edit Profile</a></li>
                        <li><a href="#changePass" id="changePassTrigger"> <i class="menu-icon ti-key"></i>Change Password</a></li>
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
                                      echo '<img src="data:image/jpeg;base64,'.base64_encode($row['profile_pic'] ).'" class="user-avatar rounded-circle" />'; 
                                  }else 
                                  echo '<img class="user-avatar rounded-circle" src="img/dummy.png" alt="User">';
                              }
                              ?>
                          </a>

                          <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa- user"></i>My Profile</a>

                            <a class="nav-link" href="#changePass" id="changePassTrigger1"><i class="fa fa -cog"></i>Settings</a>

                            <a class="nav-link" href="logout.php"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            </header>
            <!-- /#header -->
            
            <!-- <div id="loading"></div> -->

            <!-- Content -->
            <div id="content">
            <div class="content">
                <!-- Animated -->
                <div class="animated fadeIn">

                    
                    <!-- TOPP FACULTY DETAILS -->
                   <!--  <div class="orders" id="topFaculty">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="box-title">TOP FACULTY IN YOUR DEPARTMENT</h4>
                                    </div>
                                    <div class="card-body--">
                                        <br>
                                        <?php
                                                // $adminDept = $_SESSION['dept'];
                                                // $sql = "SELECT DISTINCT user_id FROM performance WHERE year ='2018-19' AND user_id IN (SELECT user_id FROM user WHERE dept = 'CSE') ORDER BY total_credits DESC";
                                                // $res = mysqli_query($connect, $sql)  or die(mysqli_error($connect));
                                                // while ($row = mysqli_fetch_array($res)){ 
                                                //     $user_ids[] = $row['user_id'];
                                                // }
                                                // $topUserCount = mysqli_num_rows($res);

                                                // $sql = "SELECT name, profile_pic FROM user WHERE user_id = $user_ids[0]";
                                                // for($i = 1 ; $i < $topUserCount ; $i++)
                                                //     $sql .= " OR user_id = $user_ids[$i]";                                                   
                                                    
                                                // $res = mysqli_query($connect, $sql)  or die(mysqli_error($connect));
                                                // while($row = mysqli_fetch_array($res)){
                                                //     $names[] = $row['name'];
                                                //     $pics[] = $row['profile_pic'];
                                                // }
                                                // for($i = 0 ; $i < $topUserCount ; $i++){
                                                //     $userCredits = YEARSUM('2018-19', $user_ids[$i]);
                                                //     $academic_credits[] = $userCredits[7];
                                                //     $student_credits[] = $userCredits[8];
                                                //     $overall_credits[] = $userCredits[9];
                                                // }
                                            ?>  
                                        <div class="table-stats order-table ov-h">
                                           
                                            
                                            <table class="table ">
                                                <thead>
                                                    <tr>
                                                        <th class="serial">#</th>
                                                        <th class="avatar">Image</th>
                                                        <th>Name</th>
                                                        <th>Academic</th>
                                                        <th>Student</th>
                                                        <th>Overall</th>
                                                        <th>Department</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                
                                                    <?php
                                                    // for($i = 0 ; $i < $topUserCount ; $i++){
                                                    //     $rank = $i+1;
                                                    //     echo "<tr><td>$rank.</td>";
                                                    //     if($pics[$i] == NULL)
                                                    //         echo '<td><img class="user-avatar rounded-circle" src="img/dummy.png" alt="User" height="24" width="24"></td>';
                                                    //     else echo "<td><img class='user-avatar rounded-circle' src='data:image/jpeg;base64,".base64_encode($pics[$i])." height='24' width='24' class='img-thumnail'/></td>";
                                                    //     echo "
                                                    //     <td>$names[$i]</td>
                                                    //     <td>$academic_credits[$i]</td>
                                                    //     <td>$student_credits[$i]</td>
                                                    //     <td>$overall_credits[$i]</td>
                                                    //     <td><span class='badge badge-complete'>$adminDept</span></td>
                                                    //     </tr>";
                                                    // }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div>
                                </div> 
                            </div>


                        </div>
                    </div> -->

                    <!-- TOP FACULTY - INSTITUTION DETAILS -->
                    <div class="orders1" id="topFaculty1">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="box-title">TOP FACULTY IN YOUR INSTITUTION</h4>
                                    </div>
                                    <div class="card-body--">
                                        <?php                                            
                                            // $user_ids = array();
                                            // $sql = "SELECT DISTINCT user_id FROM performance WHERE year ='2018-19'  ORDER BY total_credits DESC";
                                            // $res = mysqli_query($connect, $sql)  or die(mysqli_error($connect));
                                            // while ($row = mysqli_fetch_array($res)){ 
                                            //     $user_ids[] = $row['user_id'];
                                            //     // echo $row['user_id']."<br>";
                                            // }
                                            // $topUserCount = mysqli_num_rows($res);

                                            // // construct query to obtain user details
                                            // $sql = "SELECT user_id, name, profile_pic,dept FROM user WHERE user_id = $user_ids[0]";
                                            // for($i = 1 ; $i < $topUserCount ; $i++)
                                            //     $sql .= " OR user_id = $user_ids[$i]";                                                   
                                                
                                            // $res = mysqli_query($connect, $sql)  or die(mysqli_error($connect));
                                            // while($row = mysqli_fetch_array($res)){
                                            //     $id = $row['user_id'];
                                            //     $val=0;
                                            //     foreach($user_ids as $order){
                                            //         if($order == $id)
                                            //             $index = $val;
                                            //         $val+=1;
                                            //     }
                                            //     // echo $index." ". $row['name']."<br>";
                                            //     $names[$index] = $row['name'];
                                            //     $pics[$index] = $row['profile_pic'];
                                            //     $depts[$index] = $row['dept'];
                                            //     $ids[$index] = $row['user_id'];
                                            // }
                                            // // echo '$user_ids:<br>';
                                            // for($i = 0 ; $i < $topUserCount ; $i++){
                                            //     $userCredits = YEARSUM1('2018-19', $user_ids[$i]);
                                               
                                            //     $academic_credits[$i] = $userCredits[7];
                                            //     $student_credits[$i] = $userCredits[8];
                                            //     $overall_credits[$i] = $userCredits[9];
                                            //     // echo "ID: " . $user_ids[$i] . " Academic C:" . $academic_credits[$i] ." ". $userCredits[7] . "<br>";
                                            // }
                                        ?>

                                        <?php
                                            $sql = "SELECT P.user_id ,U.name,U.profile_pic,AVG(total_credits) as avgg, U.dept FROM performance P, user U where U.user_id = P.user_id AND year='2018-19' group by P.user_id ORDER BY AVG(total_credits) DESC";
                                            $res = mysqli_query($connect, $sql);
                                            $i=0;
                                            while($row = mysqli_fetch_array($res)){
                                                $user_ids[$i] = $row['user_id'];
                                                $names[$i] = $row['name'];
                                                $pics[$i] = $row['profile_pic'];
                                                $depts[$i] = $row['dept'];
                                                $total[$i] = number_format($row['avgg'], 2, '.', '');
                                                // echo $row['user_id'];
                                                // echo $row['avgg'];

                                                $i+=1;
                                            }
                                            $topUserCount = $i;
                                            for($i = 0 ; $i < $topUserCount ; $i++){
                                                $userCredits = YEARSUM1('2018-19', $user_ids[$i]);
                                                $academic_credits[$i] = $userCredits[7];
                                                $student_credits[$i] = $userCredits[8];
                                                $overall_credits[$i] = $userCredits[9];
                                                // echo "ID: " . $user_ids[$i] . " Academic C:" . $academic_credits[$i] ." ". $userCredits[7] . "<br>";
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
                                                        <th>Total</th>
                                                        <th>Department</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                
                                                    <?php
                                                        $rank=0;
                                                        for($i = 0 ; $i < $topUserCount ; $i++){
                                                        // foreach($ids as $id){
                                                            // echo "<br>";
                                                            // echo "ID: " . $user_ids[$i] . " Academic C:" . $academic_credits[$i];

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
                                                            <td>$total[$i]</td>
                                                            ";
                                                            if($depts[$i] == $adminDept)
                                                                echo "<td><span class='badge badge-complete'>$depts[$i]</span></td>";
                                                            else echo "<td><span class='badge badge-pending'>$depts[$i]</span></td>";
                                                            echo "</tr>";
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
        </div>
            <!-- /.site-footer -->
        </div>
        <!-- /#right-panel -->

        <!-- Scripts -->

        <script type="text/javascript">
            
            $("a[href^=#]").click(function(e) { e.preventDefault(); var dest = $(this).attr('href'); console.log(dest); $('html,body').animate({ scrollTop: $(dest).offset().top-75 }, 2000); });




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
        <!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
        <script src="js/addPerformanceValidation.js"></script> -->

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
    </body>
</html>
