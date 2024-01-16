<?php
@session_start();
require 'Class.php';
Validate::checkSession('USER');

$user_id = $_SESSION['USER']['USER_ID'];
$sql = "SELECT * FROM User JOIN User_info ON User.user_id = User_info.user_id; WHERE user_id = ?;";
$array = Util::arrayDimChange2(dbHandler::query($sql,$user_id));


$sql2 = "SELECT * FROM Whispers WHERE user_id = ?;";
$result = dbHandler::query($sql2,$user_id);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール編集/<?php echo $array['user_name'] ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f8fa;
            color: #1c1e21;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        nav {
            background-color: #1da1f2;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
        }

        form {
            margin: 20px;
        }

        img {
            border-radius: 50%;
            max-width: 100px;
            max-height: 100px;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }

        hr {
            border: 0;
            height: 1px;
            background: #ccc;
            margin: 10px 0;
        }

        input[type="submit"] {
            background-color: #1da1f2;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0d8af5;
        }
    </style>
</head>
<body>
    <nav>
        <a href="javascript:history.back()">←</a>
    </nav>
    <form method="post">
        <img src="user_icon/default_icon.jpeg" alt="Icon image"><br>
        <input type="text" id="name" name="name" value="<?php echo $array['user_name']; ?>"><br>
        <?php echo '@', $array['user_id']; ?>
        <hr>
        自己紹介<br>
        <input type="text" id="self_intro" name="self_intro" value="<?php echo $array['self_intro']; ?>"><br>
        <hr>
        <input type="submit" value="変更する">
    </form>
</body>
</html>
