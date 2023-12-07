<?php
@session_start();
require '../Class.php';

if(isset($_SESSION['LOGIN_INFO'])){
    session_destroy();
}
$_SESSION['LOGIN_INFO'] = [];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $flag = 0;
    if(!empty($_POST['id']) AND $_POST['id'] != ''){
        $_SESSION['LOGIN_INFO']['USER_ID'] = $_POST['id'];
    }else{
        echo "input id!<br>";
        $flag += 1;
    }

    if(!empty($_POST['pass']) AND $_POST['pass'] != ' '){
        $_SESSION['LOGIN_INFO']['PASS'] = password_hash($_POST['pass'],PASSWORD_DEFAULT);
    }else{
        echo "input password!<br>";
        $flag += 1;
    }

    if($flag == 0){
        header("Location:login_process.php");
    }
    
}
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
        ユーザーID<br>
        <input type="text" name="id"><br>
        パスワード<br>
        <input type="password" name="pass"><br>
        <input type="submit" value="ログイン">
    </form>
</body>
</html>