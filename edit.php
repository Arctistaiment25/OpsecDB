<?php
if (isset($_SERVER['HTTP_REFERER'])) {
    $referrer = parse_url($_SERVER['HTTP_REFERER']);
    if ($referrer['path'] !== '/main.php' && $referrer['path'] !== '/edit.php') {
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
    die("Database Connection Failed " . $conn->connect_error);
}

$id = $conn->real_escape_string($_GET['id']);
$sql = "SELECT * FROM osints WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $osint = $result->fetch_assoc();
} else {
    die("Post not found ERROR.");
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit or Lookup Osint Posts / Private</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: red;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            position: relative;
        }
        h1, h2 {
            color: red;
            text-align: center;
        }
        form {
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(255, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        form:hover {
            transform: translateY(-10px);
        }
        input[type="text"], textarea {
            width: calc(100% - 16px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid red;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            color: red;
            background-color: #222;
        }
        input[type="text"]:focus, textarea:focus {
            border-color: #ff6666;
        }
        input[type="submit"], .delete-btn {
            background-color: red;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 10px;
        }
        input[type="submit"]:hover, .delete-btn:hover {
            background-color: darkred;
            transform: scale(1.05);
        }
        .success {
            color: #4CAF50;
            text-align: center;
        }
        .error {
            color: #f44336;
            text-align: center;
        }
        p {
            text-align: center;
        }
        .logo {
            position: absolute;
            top: 20px;
            right: 20px;
            max-width: 100px;
        }
    </style>
</head>
<body>

    <img src="pics/icon.png" alt="Logo" class="logo">
    
    <h1>Edit or Lookup Post</h1>
    <form method="POST" action="">
    <label for="title">Titel:</label><br>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($osint['title']) ?>" readonly><br><br>
    
    <label for="osint">Nachricht:</label><br>
    <textarea id="osint" name="osint" rows="4" readonly><?= htmlspecialchars($osint['osint']) ?></textarea><br><br>
    </form>


    <p><a href="main.php" style="color: red;">Back to Homepage</a></p>
</body>
</html>

<?php $conn->close(); ?>
