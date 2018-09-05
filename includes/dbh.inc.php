<!-- 

Alexander Murie
Eagleweb, Aug 2018
Purpose: Sets the server and database name, and connects to the SQL database.
 -->


<?php 


$dbServername = "localhost"; 
$dbUsername = "root";
$dbPassword = "";
$dbName = "Eagleweblogin";
$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
	

