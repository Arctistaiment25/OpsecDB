<?php
session_start();
if (isset($_SERVER['HTTP_REFERER'])) {
    $referrer = parse_url($_SERVER['HTTP_REFERER']);
    if ($referrer['path'] !== '/main.php' && $referrer['path'] !== '/manage_users.php' && $referrer['path'] !== '/manage_access_login.php' && $referrer['path'] !== '/manage_choose.php') {
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
$host = 'localhost';
$db = 'osint_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['access_id'])) {
    $access_id = $conn->real_escape_string($_POST['access_id']);
    
    $sql = "SELECT * FROM manager_ids WHERE access_id = '$access_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $_SESSION['access_id'] = $access_id;
        header("Location: manage_choose.php");
        exit();
    } else {
        $error = "Invalid Access ID";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>OSINT DB login - Staff Access</title>
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

        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 12px 0;
            border: 1px solid red;
            border-radius: 4px;
            background-color: #222;
            color: red;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: red;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"]:hover {
            background-color: darkred;
        }

        .logo {
            position: absolute;
            top: 20px;
            right: 20px;
            max-width: 100px;
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
    <h2>OSINT DB - Staff Access</h2>
    <?php if (isset($error)): ?>
        <p style="color: #f44336;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="access_id">Enter your Access ID:</label><br>
        <input type="password" name="access_id" id="access_id" required><br><br>
        <input type="submit" value="Login">
        <a href="main.php" class="back-btn">Back</a>
    </form>
</div>
<img src="pics/icon.png" alt="Logo" class="logo">
</body>
</html>
