<?php
$host = "localhost";  
$user = "root";  
$password = '';  
$db_name = "contat";  

// Connect to contat database, with fallback to login database
$con = @mysqli_connect($host, $user, $password, $db_name);  
if (!$con) {  
    $con = @mysqli_connect($host, $user, $password, "login");
    if (!$con) {
        die("Failed to connect with MySQL: " . mysqli_connect_error());  
    }
}  
?>