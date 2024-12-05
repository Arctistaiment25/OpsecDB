<?php
if (isset($_SERVER['HTTP_REFERER'])) {
    $referrer = parse_url($_SERVER['HTTP_REFERER']);
    if ($referrer['path'] !== '/manage_choose.php' && $referrer['path'] !== '/manage_access_login.php' && $referrer['path'] !== '/manage_binaryconverter.php' && $referrer['path'] !== '/manage_chat.php' && $referrer['path'] !== '/manage_users.php' && $referrer['path'] !== '/manage_main.php') {
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>OSINT DB Staff Choosing Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: red;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-form {
            background-color: #333;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(255, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .logo {
            position: absolute;
            top: 20px;
            right: 20px;
            max-width: 100px;
        }

        .button {
            background-color: red;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: darkred;
        }
        .back-btn {
            position: absolute;
            top: 75px;
            right: 140px;
            background-color: red;
            color: white;
            padding: 10px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .back-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<div class="login-form">
    <h2>OSINT DB - Staff Access Pages</h2>
    <?php if (isset($error)): ?>
        <p style="color: #f44336;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="access_id">Panels:</label><br><br>
        <a href="manage_access_login.php" class="back-btn">Back</a>
        <button class="button" type="button" onclick="window.location.href='manage_main.php'">Manage Posts</button>
        <button class="button" type="button" onclick="window.location.href='manage_users.php'">User Access</button>
        <button class="button" type="button" onclick="window.location.href='manage_chat.php'">Staff Chat</button>
        <button class="button" type="button" onclick="window.location.href='manage_binaryconverter.php'">Decrypter / Encrypter</button>
        <button class="button" type="button" onclick="window.location.href='https://www.exploit-db.com/'">ExploitDB</button>
    </form>
</div>

<img src="pics/icon.png" alt="Logo" class="logo">
</body>
</html>
