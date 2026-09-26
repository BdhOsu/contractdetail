<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, trim($_POST['name'])) : '';
    $phone = isset($_POST['contact']) ? mysqli_real_escape_string($conn, trim($_POST['contact'])) : '';

    if (!empty($name) && !empty($phone)) {
        $sql = "INSERT INTO `names` (`name`, `phone`) VALUES ('$name', '$phone')";
        mysqli_query($conn, $sql);
    }
}

header('Location: index.php');
exit;
?>