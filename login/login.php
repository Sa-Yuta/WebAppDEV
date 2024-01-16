<?php
@session_start();
require '../Class.php';

if(isset($_SESSION['LOGIN_INFO'])){
    $_SESSION['LOGIN_INFO'] = [];
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $flag = 0;
    if(!empty($_POST['id']) AND $_POST['id'] != ''){
        $_SESSION['LOGIN_INFO']['USER_ID'] = $_POST['id'];
    }else{
        echo "input id!<br>";
        $flag += 1;
    }

    if(!empty($_POST['pass']) AND $_POST['pass'] != ' '){
        $_SESSION['LOGIN_INFO']['PASS'] = $_POST['pass'];
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
    <title>ログイン</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f8fa;
            color: #1c1e21;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            color: #1da1f2;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #1da1f2;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0d8dd8;
        }

        .error {
            color: #e0245e;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form method="post">
        <h2>ログイン</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $flag = 0;
            if (empty($_POST['id']) || $_POST['id'] == '') {
                echo "<p class='error'>ユーザーIDを入力してください。</p>";
                $flag += 1;
            }

            if (empty($_POST['pass']) || $_POST['pass'] == ' ') {
                echo "<p class='error'>パスワードを入力してください。</p>";
                $flag += 1;
            }

            if ($flag == 0) {
                header("Location:login_process.php");
            }
        }
        ?>
        <label for="id">ユーザーID</label>
        <input type="text" name="id">

        <label for="pass">パスワード</label>
        <input type="password" name="pass">

        <input type="submit" value="ログイン">
    </form>
</body>
</html>
