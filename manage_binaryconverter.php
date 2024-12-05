<?php
if (isset($_SERVER['HTTP_REFERER'])) {
    $referrer = parse_url($_SERVER['HTTP_REFERER']);
    if ($referrer['path'] !== '/manage_binaryconverter.php' && $referrer['path'] !== '/manage_choose.php') {
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpsecDB / Binary Decrypter</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom, #000000, #330000);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            color: #fff;
        }

        .container {
            text-align: center;
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: fadeIn 2s ease-out;
        }

        .title {
            font-size: 2.5em;
            margin: 0;
            animation: float 3s infinite;
        }

        .info {
            font-size: 1.2em;
            margin: 20px 0;
            animation: fadeIn 4s ease-out;
        }

        .download-button {
            background: #8B0000; /* Dark Red */
            color: #fff;
            border: none;
            padding: 15px 30px;
            font-size: 1em;
            border-radius: 25px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
            animation: fadeIn 5s ease-out;
            text-decoration: none;
            display: inline-block;
        }

        .download-button:hover {
            background: #B22222; /* Firebrick Red */
            transform: scale(1.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">OpsecDB Message Decrypter</h1>
        <p class="info">Requirements: Java 8 / Password: opsecdbmessagedecrypter8075023475094935</p>
        <a href="files/messagedecrypter.rar" class="download-button" download>Download</a>
    </div>
</body>
</html>
