<?php
include "dbconfig.php";

date_default_timezone_set('Asia/Yangon');
    $d = date("Y-m-d");
    $t = date("H:i:s");

    if(!empty($_POST['rollno']) )
    {
    	$rollno = $_POST['rollno'];
	    $sql = "INSERT INTO students (id, rollno, attendance, Date, Time)
		
		VALUES ('".$rollno."', '".$rollno."', 1, '".$d."', '".$t."')";
		
		if ($conn->query($sql) === TRUE) {
		    echo "OK";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}


	$conn->close();
?>