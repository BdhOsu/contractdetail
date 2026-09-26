<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Auto-create deleted_names table if it doesn't exist
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `deleted_names` (
    `id` INT(11) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(50) NOT NULL,
    `deleted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `deleted_by` VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Count deleted contacts
$del_count = 0;
$del_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM `deleted_names`");
if ($del_query) {
    $row_cnt = mysqli_fetch_assoc($del_query);
    $del_count = $row_cnt['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact App</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #2a5298;
            color: #fff;
            padding: 12px 24px;
        }
        .top-bar h1 {
            margin: 0;
            padding: 0;
            font-size: 20px;
            background: transparent;
            color: #fff;
            font-family: inherit;
        }
        .user-nav {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 14px;
        }
        .nav-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }
        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.35);
        }
        .logout-link {
            background: #e74c3c;
            color: white;
            padding: 6px 14px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
        }
        .logout-link:hover {
            background: #c0392b;
        }
        .alert-box {
            padding: 10px 14px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .alert-info {
            background-color: #e8f4fd;
            color: #1e6bb8;
            border: 1px solid #b8daff;
        }
        .alert-success {
            background-color: #e6f7ea;
            color: #27ae60;
            border: 1px solid #2ecc71;
        }
    </style>
</head>
<body>
    <header class="top-bar">
        <h1>CONTACT APP</h1>
        <div class="user-nav">
            <a href="deleted_contacts.php" class="nav-btn">🗑️ Deleted Contacts (<?php echo $del_count; ?>)</a>
            <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['user']); ?></strong></span>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
    </header>

<div class="main">
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
        <div class="alert-box alert-info">
            ✓ Contact has been logically deleted and archived in the database.
        </div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'restored'): ?>
        <div class="alert-box alert-success">
            ✓ Contact restored successfully.
        </div>
    <?php endif; ?>

    <form action="adddata.php" method="post">
        <label for="name">Name:</label><br>
        <input type="text" name="name" id="name" required><br><br>
        <label for="contact">Number:</label><br>
        <input type="number" name="contact" id="contact" required><br><br>
        <input type="submit" value="Save Contact">
    </form>

    <hr style="margin: 20px 0;">

    <!-- display of stored data -->
    <table border="1" id="t1" style="border-collapse: collapse; min-width: 320px;">
        <thead>
            <tr style="background-color: #f1f2f6;">
                <th>Name</th>
                <th>Number</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM names";
        $result = mysqli_query($conn, $sql);

        if($result && mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $id = $row['id'];
                $name = $row['name'];
                $phone = $row['phone'];
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($name); ?></td>
                    <td><?php echo htmlspecialchars($phone); ?></td>
                    <td> 
                        <a href="edit.php?id=<?php echo $id; ?>">Edit</a> | 
                        <a href="delet.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure you want to delete this contact?');" style="color: #d63031;">Del</a> 
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="3" style="text-align: center; color: #888; padding: 20px;">
                    No contacts found.
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
