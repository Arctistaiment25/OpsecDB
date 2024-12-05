<?php
session_start();
if (isset($_SERVER['HTTP_REFERER'])) {
    $referrer = parse_url($_SERVER['HTTP_REFERER']);
    if ($referrer['path'] !== '/manage_chat.php' && $referrer['path'] !== '/manage_choose.php') {
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = $conn->real_escape_string($_POST['message']);
    $date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO staff_chat (message, date) VALUES ('$message', '$date')";
    if (!$conn->query($sql)) {
        $error = "Failed to save message.";
    }
}

if (isset($_POST['delete_all'])) {
    $sql = "TRUNCATE TABLE staff_chat";
    $conn->query($sql);
}

$sql = "SELECT * FROM staff_chat ORDER BY date DESC";
$result = $conn->query($sql);
$messages = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>OSINT DB Chat - Staff Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: red;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        .chat-container {
            background-color: #333;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(255, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
        }

        .message-list {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #222;
            border: 1px solid red;
            border-radius: 4px;
        }

        .message {
            margin-bottom: 10px;
        }

        .message span {
            color: #999;
            font-size: 0.9em;
        }

        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 12px 0;
            border: 1px solid red;
            border-radius: 4px;
            background-color: #222;
            color: red;
            box-sizing: border-box;
        }

        input[type="submit"], .delete-btn {
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

        input[type="submit"]:hover, .delete-btn:hover {
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

<div class="chat-container">
    <h2>OSINT DB - Staff Chat</h2>
    <div class="message-list">
        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message">
                    <strong><?= htmlspecialchars($msg['message']) ?></strong>
                    <br>
                    <span><?= htmlspecialchars($msg['date']) ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No Message Found.</p>
        <?php endif; ?>
    </div>

    <form method="POST" action="">
        <input type="text" name="message" placeholder="Type your message..." required>
        <input type="submit" value="Send">
    </form>

    <form method="POST" action="">
        <!-- <input type="hidden" name="delete_all" value="1">
        <button class="delete-btn" type="submit">Delete All Messages</button> -->
    </form>
    <a href="manage_choose.php" class="back-btn">Back</a>
</div>
<img src="pics/icon.png" alt="Logo" class="logo">

</body>
</html>
