<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Contact App</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body.login-body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 35px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-card h2 {
            margin-bottom: 8px;
            color: #1e3c72;
            font-size: 24px;
        }

        .login-card p.subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: left;
        }

        .alert-error {
            background-color: #ffe6e6;
            color: #d63031;
            border: 1px solid #ff7675;
        }

        .alert-success {
            background-color: #e6f7ea;
            color: #27ae60;
            border: 1px solid #2ecc71;
        }

        .form-group {
            margin-bottom: 18px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-weight: 600;
            font-size: 13px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #dcdde1;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2a5298;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #2a5298;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #1e3c72;
        }

        .login-footer {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
            font-size: 12px;
            color: #7f8c8d;
        }

        .login-footer code {
            background: #f1f2f6;
            padding: 2px 6px;
            border-radius: 4px;
            color: #2f3542;
        }
    </style>
</head>
<body class="login-body">
    <div class="login-card">
        <h2>Contact App</h2>
        <p class="subtitle">Please enter your credentials to login</p>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
            <div class="alert alert-error">
                ⚠️ Invalid username or password. Please try again.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'loggedout'): ?>
            <div class="alert alert-success">
                ✓ You have been logged out successfully.
            </div>
        <?php endif; ?>

        <form action="authentication.php" method="POST">
            <div class="form-group">
                <label for="user">Username</label>
                <input type="text" name="user" id="user" placeholder="Enter username" required autofocus>
            </div>

            <div class="form-group">
                <label for="pass">Password</label>
                <input type="password" name="pass" id="pass" placeholder="Enter password" required>
            </div>

            <button type="submit" class="btn-login">Sign In</button>
        </form>

        <div class="login-footer">
            Default credentials: <code>admin</code> / <code>admin123</code>
        </div>
    </div>
</body>
</html>