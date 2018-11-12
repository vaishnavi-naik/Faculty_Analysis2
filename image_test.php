<table class="table table-bordered">  
     <tr>  
          <th>Image</th>  
     </tr>  
<?php  
include "include/connection.php";
$query = "SELECT * FROM user";  
$result = mysqli_query($connect, $query);  
while($row = mysqli_fetch_array($result))  
{  
     echo '  
          <tr>  
               <td>  
                    <img src="data:image/jpeg;base64,'.base64_encode($row['profile_pic'] ).'" height="200" width="200" class="img-thumnail" />  
               </td>  
          </tr>  
     ';  
}  
?>  
</table>  