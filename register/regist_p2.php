<?php
@session_start();
require'../Class.php';

Validate::checkSession('REGIST');

function registCheck($input){
    $result = dbHandler::query("SELECT * FROM USER WHERE user_id = ?;",$input);

    if ($result){
        return 'すでに使用されているユーザー名です。別の名前を入力してください。';
    }else{
        return true;
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $flag = 0;
    $user_id = $_POST['user_id'];

    if($user_id != '' ){
        $msg = Validate::userId($user_id);
        if($msg != 1){
            echo $msg;
        }else{
            $mag = registCheck($user_id);
            if($msg != 1){
                echo $msg;
            }else{
                $_SESSION['REGIST']['user_id'] = $user_id;
    
                header('Location:regist_confirm.php');
                exit();
            }
        }
    }else{
    echo "input infomations!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント作成/Whisper</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f8fa;
            color: #1c1e21;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h3 {
            color: #1da1f2;
        }

        form {
            margin: 20px;
        }

        input[type="text"] {
            width: 60%;
            padding: 10px;
            margin: 5px;
            border: 1px solid #1da1f2;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #1da1f2;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0d8bf0;
        }

        p {
            color: #888;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h3>もう少しです！</h3>
    <form method="post">
        ユーザーID<br>
        <input type="text" name="user_id"><br>
        <p>ユーザーIDは一意である必要があります</p>
        <input type="submit" value="登録">
    </form>
</body>
</html>
