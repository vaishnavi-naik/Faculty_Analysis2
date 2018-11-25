<?php
include 'include/connection.php';
$email = $_SESSION['email'];
$query = "SELECT profile_pic from user where email = '$email'";  
$result = mysqli_query($connect, $query);  
if(mysqli_num_rows($result) == 1){
  $row = mysqli_fetch_array($result);                               
  echo '<tr>
            <td>
                <img src="data:image/jpeg;base64,'.base64_encode($row['profile_pic'] ).'" class="user-avatar rounded-circle" />
            </td>
        </tr>'; 
}else 
  echo '<img class="user-avatar rounded-circle" src="img/dummy.png" alt="User Avatar">';
?>

