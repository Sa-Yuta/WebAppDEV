<?php
@session_start();
require'../Class.php';

Validate::checkSession('REGIST');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST['accept'] == "1"){
        if(dbHandler::insertData('User',$_SESSION['REGIST']) == true){
            header("Location:thanks_to_regist.php");
        };
    }elseif($_POST['accept'] == "0"){
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録確認</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f8fa;
            color: #1c1e21;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #1da1f2;
        }

        th {
            background-color: #1da1f2;
            color: #fff;
        }

        td {
            background-color: #fff;
        }

        form {
            margin: 20px;
        }

        input[type="hidden"], input[type="submit"] {
            background-color: #1da1f2;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="hidden"]:hover, input[type="submit"]:hover {
            background-color: #0d8bf0;
        }

        p {
            color: #888;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>ユーザーID</th>
            <td>@<?php echo $_SESSION['REGIST']['user_id']?></td>
        </tr>
        <tr>
            <th>ユーザー名</th>
            <td><?php echo $_SESSION['REGIST']['user_name']?></td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td><?php echo $_SESSION['REGIST']['email']?></td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td>(セキュリティの観点より表示していません)</td>
        </tr>
        <tr>
            <th>生年月日</th>
            <td><?php echo $_SESSION['REGIST']['birthday']?></td>
        </tr>
    </table>
    以上で登録してよろしいでしょうか？<br>
    <form method="post">
        <input type="hidden" name="accept" value="1">
        <input type="submit" value="登録">
    </form>
    <form method="post">
        <input type="hidden" name="accept" value="0">
        <input type="submit" value="やめる">
    </form>
</body>
</html>
