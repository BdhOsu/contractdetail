<?php
// connection to database is done in this stage

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "contat";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>