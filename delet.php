<!-- Main action for delet data from database -->
<?php
include 'db.php';

$id = $_GET['id'];

$del = mysqli_query($conn, "DELETE FROM `names` WHERE `names`.`id` = $id");
//this query is fetch from database directly

// $del = mysqli_query($conn, "DELET FROM names where id = '$id'");
// $sql = "DELET fROM names WHERE id='$id'";
// $result = mysqli_query($conn, $sql);
if($del){
    mysqli_close($conn);
    header("location:index.php");
    exit;
}
else
{
    echo"error deleting data";
}
?>