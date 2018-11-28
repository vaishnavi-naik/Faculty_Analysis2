<?php 
include "./include/connection.php";

$user_id=mysqli_real_escape_string($connect, $_POST['faculty_name']);
$year=mysqli_real_escape_string($connect, $_POST['year']);
$sem=mysqli_real_escape_string($connect, $_POST['sem']);
$attendance=mysqli_real_escape_string($connect, $_POST['attendance']);
$att_credits = $attendance / 10;

$tot_research=mysqli_real_escape_string($connect, $_POST['tot_research']);
$res_credits = $tot_research * 10 /5;

$tot_pub=mysqli_real_escape_string($connect, $_POST['tot_pub']);
$pub_credits = $tot_pub * 10 /7;

$tot_org=mysqli_real_escape_string($connect, $_POST['tot_org']);
$org_credits=$tot_org*10/5;

$tot_extra_act=mysqli_real_escape_string($connect, $_POST['tot_extra_act']);
$ext_credits=$tot_extra_act*10/5;

$tot_students=mysqli_real_escape_string($connect, $_POST['tot_students']);
$tot_pass=mysqli_real_escape_string($connect, $_POST['tot_pass']);
$pass_credits = $tot_pass / $tot_students * 10;

$stud_credits=mysqli_real_escape_string($connect, $_POST['stud_credits']);

$tot_academics_credits = ($att_credits + $res_credits + $pub_credits + $org_credits + $ext_credits)/5;
$tot_student_credits = ($pass_credits + $stud_credits) / 2;

$query1 = "INSERT INTO `academic_performance`(`tot_pub`, `pub_credits`, `attendance`, `att_credits`, `tot_org`, `org_credits`, `tot_research`, `res_credits`, `tot_extra_act`, `ext_credits`, `tot_credits`) VALUES('$tot_pub','$pub_credits','$attendance','$att_credits','$tot_org','$org_credits','$tot_research','$res_credits','$tot_extra_act','$ext_credits','$tot_academics_credits')";
$id_query = "SELECT LAST_INSERT_ID()";
$error_flag = 0;
if((mysqli_query($connect, $query1) ) or die(mysqli_error($connect)))
{  
    $academic_perf_res = mysqli_query($connect, $id_query) or die(mysqli_error($connect));
    if(mysqli_num_rows($academic_perf_res) == 1){
        $row = mysqli_fetch_row($academic_perf_res);
        $academic_id = $row[0];
    }
}

$query2 = "INSERT INTO `student_performance`(`stud_credits`, `tot_students`, `tot_pass`, `pass_credits`, `total_credits`) VALUES('$stud_credits','$tot_students','$tot_pass','$pass_credits','$tot_student_credits')";

if((mysqli_query($connect, $query2) ) or die(mysqli_error($connect)))
{  
    $student_perf_res = mysqli_query($connect, $id_query) or die(mysqli_error($connect));
    if(mysqli_num_rows($student_perf_res) == 1){
        $row = mysqli_fetch_row($student_perf_res);
        $student_perf_id = $row[0];
    }
}

$query3 = "INSERT INTO `performance`(`user_id`, `year`, `sem`, `academic_id`, `student_id`) VALUES('$user_id','$year','$sem','$academic_id','$student_perf_id')";
if((mysqli_query($connect, $query3)) or die(mysqli_error($connect))){
    $successMsg = "Inserted Data Successfully";
}

header('location: admin_dash.php?successMsg='.$successMsg.'#addPerformance');

 // echo "Academic ID:" . $academic_id;
 // echo "<br>Student Performance ID:" . $student_perf_id;
?>