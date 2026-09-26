<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Accept ID from GET or POST
$id = 0;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
} elseif (isset($_POST['id'])) {
    $id = intval($_POST['id']);
}

if ($id > 0) {
    $deleted_by = isset($_SESSION['user']) ? $_SESSION['user'] : 'Admin';

    // Auto-create deleted_names table if it doesn't exist
    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `deleted_names` (
        `id` INT(11) NOT NULL,
        `name` VARCHAR(255) NOT NULL,
        `phone` VARCHAR(50) NOT NULL,
        `deleted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `deleted_by` VARCHAR(100) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // 1. Fetch contact details from active names table
    $sel_stmt = mysqli_prepare($conn, "SELECT `id`, `name`, `phone` FROM `names` WHERE `id` = ?");
    if ($sel_stmt) {
        mysqli_stmt_bind_param($sel_stmt, "i", $id);
        mysqli_stmt_execute($sel_stmt);
        $res = mysqli_stmt_get_result($sel_stmt);

        if ($row = mysqli_fetch_assoc($res)) {
            $name = $row['name'];
            $phone = $row['phone'];

            // 2. Insert into deleted_names archive table
            $ins_stmt = mysqli_prepare($conn, "INSERT INTO `deleted_names` (`id`, `name`, `phone`, `deleted_by`) 
                                               VALUES (?, ?, ?, ?)
                                               ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `phone` = VALUES(`phone`), `deleted_at` = CURRENT_TIMESTAMP, `deleted_by` = VALUES(`deleted_by`)");
            if ($ins_stmt) {
                mysqli_stmt_bind_param($ins_stmt, "isss", $id, $name, $phone, $deleted_by);
                mysqli_stmt_execute($ins_stmt);
                mysqli_stmt_close($ins_stmt);
            }

            // 3. Delete from active names table so it is hidden from user
            $del_stmt = mysqli_prepare($conn, "DELETE FROM `names` WHERE `id` = ?");
            if ($del_stmt) {
                mysqli_stmt_bind_param($del_stmt, "i", $id);
                mysqli_stmt_execute($del_stmt);
                mysqli_stmt_close($del_stmt);
            }
        }
        mysqli_stmt_close($sel_stmt);
    }
}

mysqli_close($conn);

// Redirect back to index.php
header("Location: index.php?msg=deleted");
echo "<script>window.location.href='index.php?msg=deleted';</script>";
exit;
?>