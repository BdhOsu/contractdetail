<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Auto-create table if not yet created
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `deleted_names` (
    `id` INT(11) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(50) NOT NULL,
    `deleted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `deleted_by` VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$result = mysqli_query($conn, "SELECT * FROM `deleted_names` ORDER BY `deleted_at` DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted Contacts (Trash) - Contact App</title>
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
        .badge {
            background: #e74c3c;
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 12px;
        }
        .restore-btn {
            background-color: #27ae60;
            color: white !important;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
        }
        .restore-btn:hover {
            background-color: #219150;
            text-decoration: none !important;
        }
        .alert-success {
            background: #e6f7ea;
            color: #27ae60;
            border: 1px solid #2ecc71;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header class="top-bar">
        <h1>CONTACT APP - DELETED CONTACTS</h1>
        <div class="user-nav">
            <a href="index.php" class="nav-btn">← Back to Active Contacts</a>
            <span>User: <strong><?php echo htmlspecialchars($_SESSION['user']); ?></strong></span>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
    </header>

<div class="main" style="max-width: 800px;">
    <h2>🗑️ Logically Deleted Contacts Archive</h2>
    <p style="color: #666; font-size: 14px; margin-top: 5px; margin-bottom: 20px;">
        These records were hidden from the user interface and archived into the <code>deleted_names</code> database table.
    </p>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'restored'): ?>
        <div class="alert-success">✓ Contact restored successfully to active list!</div>
    <?php endif; ?>

    <table border="1" id="t1" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background-color: #f1f2f6;">
                <th>ID</th>
                <th>Name</th>
                <th>Number</th>
                <th>Deleted On</th>
                <th>Deleted By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($row['deleted_at'])); ?></td>
                    <td><?php echo htmlspecialchars($row['deleted_by'] ? $row['deleted_by'] : 'Admin'); ?></td>
                    <td>
                        <a href="restore.php?id=<?php echo $row['id']; ?>" class="restore-btn" onclick="return confirm('Restore this contact to active list?');">Restore</a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="6" style="text-align: center; color: #888; padding: 25px;">
                    No deleted contacts in the archive.
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
