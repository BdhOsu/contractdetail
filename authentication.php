<?php
session_start();
include('logincon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['user']) ? trim($_POST['user']) : '';
    $password = isset($_POST['pass']) ? trim($_POST['pass']) : '';

    if (!empty($username) && !empty($password)) {
        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($con, "SELECT id, username, password FROM login WHERE username = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                // Verify plaintext password or hashed password
                if ($row['password'] === $password || password_verify($password, $row['password'])) {
                    $_SESSION['user'] = $row['username'];
                    header("Location: index.php");
                    exit;
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
    // Redirect back to login with error parameter if authentication fails
    header("Location: login.php?error=invalid");
    exit;
} else {
    header("Location: login.php");
    exit;
}
?>