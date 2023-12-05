<?php
@session_start();
require 'Class.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <form method="post">
        ユーザーID または メールアドレス<br>
        <input type="text" name="name"><br>
        パスワード<br>
        <input type="password" name="pass"><br>
        <input type="submit" value="ログイン">
    </form>
</body>
</html>