<?php
@session_start();
require '../Class.php';

$array = ['user_id' => $_SESSION['REGIST']['user_id']];
if(dbHandler::insertData('User_info',$array) == false){
    header("Location:error.php");
}

$_SESSION['USER']['USER_ID'] = $array['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whisperへようこそ!</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f8fa;
            color: #1c1e21;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            background-color: #1da1f2;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-top: 50px;
        }

        p {
            color: #888;
            margin-top: 20px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #1da1f2;
            border-radius: 5px;
        }

        a:hover {
            background-color: #fff;
            color: #1da1f2;
            border: 1px solid #1da1f2;
        }
    </style>
</head>
<body>
    <h1>Whisperへようこそ!</h1>
    <p>さっそくタイムラインをのぞいてみましょう</p>
    <a href="../timeline.php">はじめる！</a>
</body>
</html>
