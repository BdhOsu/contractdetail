<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="style.css">

    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Document</title>
</head>
<body>
    <header>
<h1>CONTRAT APP</h1>
</header>
<form action="adddata.php" method="post">    <!-- call of adddata.php    -->
<div class="main">
<label for="name">Name:</lable> <br>
<input type="text" name="name" id="name" required><br>
<label for="name">Number:</lable> <br>
<input type="number" name="contact" id="contact" required><br>
<input type="submit" value="save">


<hr>

<!-- display of stored data -->

<table border="2px" id=t1>
<tr>
    <th>name</th>
    <th>number</th>
    <th>option</th>
</tr>

<!-- sql query and call of database -->
<?php

include 'db.php';
$sql = "SELECT * from names";

$result = mysqli_query($conn, $sql);

if($result){
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['id'];
        $name = $row['name'];
        $phone = $row['phone'];
        ?>




<tr>
    <td>
        <?php echo $name; ?>
    </td>
    <td>
        <?php echo $phone; ?>
    </td>
    <td> 
        <a href="edit.php?id=<?php echo $id; ?>">edit</a> 
        <a href="delet.php?id=<?php echo $id; ?>">del</a> 
</td>
</tr>
        <?php

    }
}


?>


</table>
</div>




</body>
</html>
