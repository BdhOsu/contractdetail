<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$contatname = '';
$contatphone = '';

$edit = mysqli_query($conn, "SELECT * FROM `names` WHERE id = $id");
if ($edit && mysqli_num_rows($edit) > 0) {
    $row = mysqli_fetch_assoc($edit);
    $contatname = $row['name'];
    $contatphone = $row['phone'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>UPDATE CONTACT</h1>
</header>
<form action="editact.php" method="post">
<div class="main">
    <label for="name">Name:</label><br>
    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($contatname); ?>" required><br><br>
    <label for="contact">Number:</label><br>
    <input type="number" name="contact" id="contact" value="<?php echo htmlspecialchars($contatphone); ?>" required><br><br>
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" required>
    <input type="submit" value="Update"> 
    <a href="index.php" style="margin-left: 10px;">Cancel</a>
</div>
</form>
</body>
</html>