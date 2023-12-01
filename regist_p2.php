<?php
@session_start();
require'Class.php';

Validate::checkSession('USER_INFO');

function registCheck($input){
    $result = dbHandler::query("SELECT * FROM User_info WHERE user_id = ?;",$input);

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
                $_SESSION['USER_INFO']['NAME'] = $user_id;
    
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
</head>
<body>
<h3>もう少しです！</h3>
    <form  method="post">
        ユーザーID<br>
        <input type="text" name="user_id"><br>
        ユーザーIDは一意である必要があります
        <input type="submit" value="登録">
    </form>
</body>
</html>