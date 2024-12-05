<?php 
if (isset($_SERVER['HTTP_REFERER'])) {
    $referrer = parse_url($_SERVER['HTTP_REFERER']);
    if ($referrer['path'] !== '/manage_main.php' && $referrer['path'] !== '/manage_choose.php' && $referrer['path'] !== '/manage_edit.php') {
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $osint = $conn->real_escape_string($_POST['osint']);

    $sql = "INSERT INTO osints (title, osint) VALUES ('$title', '$osint')";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Post Saved Successfully!</p>";
    } else {
        echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM osints WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Post Deleted Successfully!</p>";
    } else {
        echo "<p class='error'>Error while deleting: " . $conn->error . "</p>";
    }
}

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql_total = "SELECT COUNT(*) AS total FROM osints";
$result_total = $conn->query($sql_total);
$total_rows = $result_total->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT * FROM osints ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$search_result = null;
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search_title = $conn->real_escape_string($_GET['search_title']);
    $sql = "SELECT * FROM osints WHERE title LIKE '%$search_title%'";
    $search_result = $conn->query($sql);
}

$id_search_result = null;
if (isset($_GET['search_id'])) {
    $search_id = (int)$_GET['search_id'];
    $sql = "SELECT * FROM osints WHERE id = $search_id";
    $id_search_result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opsec Homepage / Staff Access</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: red;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
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
            transform: translateY(-5px);
        }
        input[type="text"], textarea {
            width: calc(100% - 16px);
            padding: 8px;
            margin: 8px 0;
            border: 1px solid red;
            border-radius: 4px;
            font-size: 16px;
            color: red;
            background-color: #222;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus, textarea:focus {
            border-color: #ff6666;
        }
        input[type="submit"] {
            background-color: red;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        input[type="submit"]:hover {
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
        ul {
            list-style-type: none;
            padding: 0;
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
        }
        ul li {
            background-color: #444;
            padding: 8px;
            margin: 8px 0;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(255, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        ul li:hover {
            transform: translateX(10px);
        }
        a {
            text-decoration: none;
            color: red;
            margin-right: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: bold;
            font-size: 16px;
            margin-left: auto;
        }
        .delete-btn:hover {
            background-color: darkred;
        }
        .delete-btn:focus {
            outline: none;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            background-color: red;
            color: white;
            transition: background-color 0.3s;
        }
        .pagination a:hover {
            background-color: darkred;
        }
        .pagination a.active {
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

    <img src="pics/icon.png" alt="Logo" class="logo">
    <h1>Opsec DB - Staff Access</h1>
    <form method="POST" action="">
        <label for="title">Title</label><br>
        <input type="text" id="title" name="title" required><br><br>
        
        <label for="osint">Description:</label><br>
        <textarea id="osint" name="osint" rows="4" cols="50" required></textarea><br><br>
        
        <input type="submit" name="save" value="Save">
    </form>

    <h2>Search Osint (Title)</h2>
    <form method="GET" action="">
        <label for="search_title">Title</label><br>
        <input type="text" id="search_title" name="search_title" required><br><br>
        <input type="submit" name="search" value="Search">
    </form>

    <h2>Search Osint (ID)</h2>
    <form method="GET" action="">
        <label for="search_id">ID:</label><br>
        <input type="text" id="search_id" name="search_id" required><br><br>
        <input type="submit" value="Search">
    </form>

    <h2>OSINTS</h2>
    <ul>
        <?php if ($search_result || $id_search_result): ?>
            <?php $results = $search_result ? $search_result : $id_search_result; ?>
            <?php while ($row = $results->fetch_assoc()): ?>
                <li>
                    <div>
                        <strong>ID: <?= $row['id'] ?></strong> - <a href="manage_edit.php?id=<?= $row['id'] ?>"><?= $row['title'] ?></a> - <?= $row['created_at'] ?>
                    </div>
                    <form method="GET" action="" style="display:inline;" onsubmit="return confirm('Do you Really wanna Delete this Post?');">
                        <input type="hidden" name="delete" value="<?= $row['id'] ?>">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </li>
            <?php endwhile; ?>
        <?php else: ?>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li>
                        <div>
                            <strong>ID: <?= $row['id'] ?></strong> - <a href="manage_edit.php?id=<?= $row['id'] ?>"><?= $row['title'] ?></a> - <?= $row['created_at'] ?>
                        </div>
                        <form method="GET" action="" style="display:inline;" onsubmit="return confirm('Do you Really wanna Delete this Post?');">
                            <input type="hidden" name="delete" value="<?= $row['id'] ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No Posts Found.</li>
            <?php endif; ?>
        <?php endif; ?>
    </ul>
    <a href="manage_choose.php" class="back-btn">Back</a>
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>

</body>
</html>

<?php $conn->close(); ?>
