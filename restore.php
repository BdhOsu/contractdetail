<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

$id = 0;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
} elseif (isset($_POST['id'])) {
    $id = intval($_POST['id']);
}

if ($id > 0) {
    // 1. Fetch from deleted_names
    $sel_stmt = mysqli_prepare($conn, "SELECT `id`, `name`, `phone` FROM `deleted_names` WHERE `id` = ?");
    if ($sel_stmt) {
        mysqli_stmt_bind_param($sel_stmt, "i", $id);
        mysqli_stmt_execute($sel_stmt);
        $res = mysqli_stmt_get_result($sel_stmt);

        if ($row = mysqli_fetch_assoc($res)) {
            $name = $row['name'];
            $phone = $row['phone'];

            // 2. Insert back into names table
            $ins_stmt = mysqli_prepare($conn, "INSERT INTO `names` (`id`, `name`, `phone`) VALUES (?, ?, ?)
                                               ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `phone` = VALUES(`phone`)");
            if ($ins_stmt) {
                mysqli_stmt_bind_param($ins_stmt, "iss", $id, $name, $phone);
                mysqli_stmt_execute($ins_stmt);
                mysqli_stmt_close($ins_stmt);
            }

            // 3. Remove from deleted_names
            $del_stmt = mysqli_prepare($conn, "DELETE FROM `deleted_names` WHERE `id` = ?");
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

header("Location: deleted_contacts.php?msg=restored");
echo "<script>window.location.href='deleted_contacts.php?msg=restored';</script>";
exit;
?>