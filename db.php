<!-- connection to database is done in this stage -->

<?php
$host= "localhost";
$user= "root";
$pass= "";
$dbname="contat";

$conn = mysqli_connect($host, $user, $pass, $dbname) or die();
// echo "data has been stored";

?>