<?php
@session_start();
require'../Class.php';

Validate::checkSession('USER');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST['accept'] == "1"){
        if(dbHandler::insertData('User',$_SESSION['USER']) == true){
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
    <title></title>
</head>
<body>
    <table>
        <tr>
            <th>ユーザーID</th>
            <td><?php echo $_SESSION['USER']['user_id']?></td>
        </tr>
        <tr>
            <th>ユーザー名</th>
            <td>@<?php echo $_SESSION['USER']['user_name']?></td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td><?php echo $_SESSION['USER']['email']?></td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td>(セキュリティの観点より表示していません)</td>
        </tr>
        <tr>
            <th>生年月日</th>
            <td><?php echo $_SESSION['USER']['birthday']?></td>
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