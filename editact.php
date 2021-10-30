<!-- Update action of database -->
<?php

include 'db.php';

$id = $_POST['id'];   //fetch from db.php which is id of database
$name=$_POST['name'];   //fetch from edit.php which is id of input type name
$phone=$_POST['contact'];   //fetch from edit.php which is id of input type contact

// "UPDATE `names` SET `name` = '$name', `phone` = '$phone' WHERE `names`.`id` = $id;"

// $sql = "UPDATE 'names' SET 'name'='$name', 'phone'='$numb' WHERE 'id'='$id'";
// $update =mysqli_query($conn, $sql);
$update = mysqli_query ($conn, "UPDATE `names` SET `name` = '$name', `phone` = '$phone' WHERE `names`.`id` = $id");

if($update){
    header("location:index.php");
}
else{
    echo "error";
}
?>