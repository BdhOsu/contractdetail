<!-- insert data into database  -->

<?php
include 'db.php';
$name=$_POST['name'];   //name is called from index.php ie inpupt type id=name
$phone=$_POST['contact']; //contact is called from index.php ie input type id=contact

echo "Name=". $name ." ". "Number=" . $phone;

// include 'db.php';

$sql = "INSERT INTO names (name, phone) VALUES('$name','$phone')";
$result = mysqli_query($conn, $sql);
if($result){
    header('Location:index.php');
}

?>