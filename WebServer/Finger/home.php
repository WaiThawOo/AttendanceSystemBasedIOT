<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: index.html');
  exit();
}

?>


<!DOCTYPE html>
<html>

<head>
  <title style="">FingerPrint Attendance System</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  <link href="css/home.css" rel="stylesheet" type="text/css">
</head>

<body>
  <?php 

  include "dbconfig.php";


  ?>
<div class="head">
    <h1>Mandalay Technological University</h1>
  <h2>Department of <span>CEIT</span></h2>
  <h4>Attendance System Using Biometric Finger Print Sensor</h4>
</div>
<div class="nav">

    <ul>
       
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        
     </ul> 
  
</div>



<?php

include "dbconfig.php";

$sql = "SELECT * FROM students";  

$result= $conn->query($sql);

?>
<div class="tab">

 <table id="rtable">
     <tr>  
                         <th>Id</th>  
                         <th>Rollno</th>  
                         <th class="att">Attendance</th>
                         <th>Date</th>
                         <th>Time</th>
                         
     </tr>
     <?php
     global $result;
     if( ! $result ){
    echo "No Result!";
    }
    else{
     while($row = $result->fetch_assoc() )                                                                                                                 
     {  
        echo '

       <tr>  
         <td>'.$row["id"].'</td> 
         <td>'.$row["rollno"].'</td>  
         <td>'.$row["attendance"].'</td>  
         <td>'.$row["Date"].'</td>
         <td>'.$row["Time"].'</td>
       </tr>  
        ';  
     }
   }
     ?>

    </table>
</div>



    <br/>
   

<div class="foot">
  Copyright©2019 | Biometric Fingerprint Attendance System | Designed & Development by <span>Wai Thaw </span> 

</div>
</body>
</html>