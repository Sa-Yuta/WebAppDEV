<?php 
@session_start();
require '../Class.php';

if (!isset($_SESSION['REGIST'])) {
    $_SESSION['REGIST'] = [];
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $flag = 0;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $birthday = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
    $pass =  $_POST['password'];

    if($email != '' AND $pass != ''){
        $msg1 = validate::len($name,0,50);
        if($msg1 != 1){
            echo "name error!";
            $flag += 1;
        }
        $msg3 = Validate::password($pass);
        if($msg3 != 1){
            echo $msg3;
            $flag += 1;
        }

        if($flag == 0){
            $_SESSION['REGIST'] = [
                'user_id' => '',
                'user_name' => $name,
                'email' => $email,
                'pass' => password_hash($pass, PASSWORD_DEFAULT),
                'birthday' => $birthday,
                'registday' => date("Y-m-d")
            ];
            header('Location: regist_p2.php');
            exit();
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

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 30%;
            padding: 10px;
            margin: 5px;
            border: 1px solid #1da1f2;
            border-radius: 5px;
            box-sizing: border-box;
        }

        select {
            margin-right: 5px;
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
    </style>
    <script>
        function updateDays() {
            var year = document.getElementById('year').value;
            var month = document.getElementById('month').value;
            var daySelect = document.getElementById('day');

            // 選択された年月に基づいて日の選択肢を更新
            var daysInMonth = new Date(year, month, 0).getDate();
            daySelect.innerHTML = '';

            for (var i = 1; i <= daysInMonth; i++) {
                var option = document.createElement('option');
                option.value = i;
                option.text = i;
                daySelect.add(option);
            }
        }
    </script>
</head>
<body>
    <h3>アカウントを作成</h3>
    <form method="post">
        名前<br>
        <input type="text" name="name"><br>
        メールアドレス<br>
        <input type="email" name="email"><br>
        生年月日<br>
        <select name="year" id="year" onchange="updateDays()">
            <?php
                $currentYear = date("Y");
                for ($i = 1900; $i <= $currentYear; $i++) {
                    $selected = ($i == 1990) ? 'selected' : '';
                    echo "<option value=\"$i\" $selected>$i</option>";
                }
            ?>
        </select>
        年
        <select name="month" id="month" onchange="updateDays()">
            <?php
                for ($i = 1; $i <= 12; $i++) {
                    $selected = ($i == 6) ? 'selected' : '';
                    echo "<option value=\"$i\" $selected>$i</option>";
                }
            ?>
        </select>
        月
        <select name="day" id="day">
            <?php
                for ($i = 1; $i <= 31; $i++) {
                    $selected = ($i == 15) ? 'selected' : '';
                    echo "<option value=\"$i\" $selected>$i</option>";
                }
            ?>
        </select>
        日<br>
        パスワード<br>
        <input type="password" name="password"><br>

        <input type="submit" value="登録">
    </form>
</body>
</html>
