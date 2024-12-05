<?php
if (isset($_SERVER['HTTP_REFERER'])) {
    $referrer = parse_url($_SERVER['HTTP_REFERER']);
    if ($referrer['path'] !== '/manage_choose.php' && $referrer['path'] !== '/manage_users.php') {
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
session_start();
$host = 'localhost';
$db = 'osint_db';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

function checkUserAccess($conn, $sessionUser, $sessionAccessId) {
    $sql = "SELECT * FROM ids WHERE user = '$sessionUser' AND access_id = '$sessionAccessId'";
    $result = $conn->query($sql);
    return $result->num_rows > 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $access_id = $conn->real_escape_string($_POST['access_id']);
    
    $sql = "INSERT INTO ids (user, access_id) VALUES ('$username', '$access_id')";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>User Add Succesfully</p>";
    } else {
        echo "<p class='error'>Error: " . $conn->error . "</p>";
    }
}

if (isset($_GET['delete_user'])) {
    $user_id = $conn->real_escape_string($_GET['delete_user']);
    $sql = "DELETE FROM ids WHERE id = $user_id";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>User Deleted Succesfully</p>";
    } else {
        echo "<p class='error'>Error while deleting: " . $conn->error . "</p>";
    }
}

$search_result = null;
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search_username'])) {
    $username = $conn->real_escape_string($_GET['search_username']);
    $sql = "SELECT * FROM ids WHERE user LIKE '%$username%'";
    $search_result = $conn->query($sql);
}

$search_id_result = null;
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search_access_id'])) {
    $access_id = $conn->real_escape_string($_GET['search_access_id']);
    $sql = "SELECT * FROM ids WHERE access_id = '$access_id'";
    $search_id_result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OPSEC DB - User Management</title>
    <style>

        body { font-family: Arial, sans-serif; background-color: black; color: red; }
        h1, h2 { color: red; }
        .form-container, .user-list { max-width: 600px; margin: 20px auto; }
        input[type="text"], input[type="submit"] {
            width: calc(100% - 16px);
            margin: 8px 0;
            padding: 8px;
            border-radius: 4px;
            background-color: #222;
            color: red;
            border: 1px solid red;
        }
        .success { color: green; text-align: center; }
        .error { color: red; text-align: center; }
        .user-list ul { list-style-type: none; padding: 0; }
        .user-list li { padding: 10px; background: #333; margin: 5px 0; border-radius: 4px; display: flex; justify-content: space-between; }
        .delete-btn { background-color: red; color: white; padding: 5px 10px; border-radius: 4px; cursor: pointer; }
        .delete-btn:hover { background-color: darkred; }
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
    <h1 class="titleperms">User Access and Permission</h1>
    <img src="pics/icon.png" alt="Logo" class="logo">
    <div class="form-container">
        <h2>Add User</h2>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="access_id">Access ID:</label>
            <input type="text" name="access_id" id="access_id" required>
            
            <input type="submit" name="add_user" value="Add User">
        </form>
    </div>

    <div class="form-container">
        <h2>Search Username</h2>
        <form method="GET" action="">
            <input type="text" name="search_username" placeholder="Username">
            <input type="submit" value="Search">
            <a href="manage_choose.php" class="back-btn">Back</a>
        </form>
        
        <?php if ($search_result && $search_result->num_rows > 0): ?>
            <div class="user-list">
                <ul>
                    <?php while ($row = $search_result->fetch_assoc()): ?>
                        <li><?= $row['user'] ?> (Access ID: <?= $row['access_id'] ?>)
                            <a href="?delete_user=<?= $row['id'] ?>" class="delete-btn">Löschen</a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        <?php elseif ($search_result): ?>
            <p>No User Found.</p>
        <?php endif; ?>
    </div>

    <div