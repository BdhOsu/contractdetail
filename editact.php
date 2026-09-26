<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, trim($_POST['name'])) : '';
    $phone = isset($_POST['contact']) ? mysqli_real_escape_string($conn, trim($_POST['contact'])) : '';

    if ($id > 0 && !empty($name) && !empty($phone)) {
        $update = mysqli_query($conn, "UPDATE `names` SET `name` = '$name', `phone` = '$phone' WHERE `id` = $id");
    }
}

header("Location: index.php");
exit;
?>