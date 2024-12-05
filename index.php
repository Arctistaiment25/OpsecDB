<?php
session_start();

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
    
    $sql = "SELECT * FROM ids WHERE access_id = '$access_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $_SESSION['access_id'] = $access_id;
        header("Location: main.php");
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
    <title>OSINT DB Access Page</title>
    <style>
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 5px rgba(255, 0, 0, 0.6);
            }
            50% {
                box-shadow: 0 0 20px rgba(255, 0, 0, 1);
            }
            100% {
                box-shadow: 0 0 5px rgba(255, 0, 0, 0.6);
            }
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #0f0f0f, #1a1a1a);
            color: red;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .login-form {
            background: linear-gradient(135deg, #2b2b2b, #222);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
            text-align: center;
            animation: fadeIn 0.8s ease-out;
        }

        input[type="password"] {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 16px 0;
            border: 1px solid red;
            border-radius: 6px;
            background: #111;
            color: #ff6b6b;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="password"]:focus {
            outline: none;
            border-color: #ff6b6b;
            box-shadow: 0 0 8px rgba(255, 107, 107, 0.8);
        }

        input[type="submit"] {
            background: red;
            color: white;
            border: none;
            padding: 14px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        input[type="submit"]:hover {
            background: #ff4d4d;
            animation: pulse 1.5s infinite;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
        }

        .error {
            color: #ff4d4d;
            background: rgba(255, 0, 0, 0.1);
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid rgba(255, 0, 0, 0.3);
        }

        .logo {
            position: absolute;
            top: 20px;
            right: 20px;
            max-width: 100px;
            animation: fadeIn 1.5s ease-out;
        }
    </style>
</head>
<body>

<div class="login-form">
    <h2>OSINT DB - Access</h2>
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="access_id">Enter your Access ID:</label><br>
        <input type="password" name="access_id" id="access_id" required><br><br>
        <input type="submit" value="Login">
    </form>
</div>
<img src="pics/icon.png" alt="Logo" class="logo">

</body>
</html>
