<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<header>
<h1>update contact</h1>
</header>
<?php 
include 'db.php';
$id = $_GET['id'];

$edit =mysqli_query($conn, "SELECT * FROM `names` Where id=$id");
if($edit){
     $row = mysqli_fetch_assoc($edit);
     $contatname = $row['name'];
     $contatphone =$row['phone'];
}

?>
<form action="editact.php" method="post">
<div class="main">
<label for="name">Name:</lable> <br>
<input type="text" name="name" id="name" value = "<?php global $contatname; echo $contatname;  ?>" required><br>
<label for="name">Number:</lable> <br>
<input type="number" name="contact" id="contact" value="<?php global $contatphone; echo $contatphone;  ?>" required><br>
<input type="hidden" name="id" id="id" value= <?php global $id; echo $id;  ?> required>
<input type="submit" value="update"> 


</body>
</html>