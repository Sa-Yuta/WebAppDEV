<?php 
@session_start();
require 'Class.php';

if (!isset($_SESSION['USER_INFO'])) {
    $_SESSION['USER_INFO'] = [];
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
            $_SESSION['USER_INFO'] = [
                'NAME' => $name,
                'EMAIL' => $email,
                'BIRTH' => $birthday,
                'PASS' => $pass
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
    <form  method="post">
        名前<br>
        <input type="text" name="name"><br>
        メールアドレス<br>
        <input type="email" name="email"><br>
        生年月日<br>
        <dev>
            <select name="year" id="year" onchange="updateDays()">
                <?php
                    // 年の選択肢を生成（例として、1900年から現在の年まで）
                    $currentYear = date("Y");
                    for ($i = 1900; $i <= $currentYear; $i++) {
                        // デフォルト値がある場合は selected 属性を追加
                        $selected = ($i == 1990) ? 'selected' : '';
                        echo "<option value=\"$i\" $selected>$i</option>";
                    }
                ?>
            </select>
            /
            <select name="month" id="month" onchange="updateDays()">
                <?php
                    // 月の選択肢を生成
                    for ($i = 1; $i <= 12; $i++) {
                        // デフォルト値がある場合は selected 属性を追加
                        $selected = ($i == 6) ? 'selected' : '';
                        echo "<option value=\"$i\" $selected>$i</option>";
                    }
                ?>
            </select>
            /
            <select name="day" id="day">
                <?php
                    // 日の選択肢を生成
                    for ($i = 1; $i <= 31; $i++) {
                        // デフォルト値がある場合は selected 属性を追加
                        $selected = ($i == 15) ? 'selected' : '';
                        echo "<option value=\"$i\" $selected>$i</option>";
                    }
                ?>
            </select>
        </dev><br>
        パスワード<br>
        <input type="password" name="password"><br>

        <input type="submit" value="登録">
    </form>
</body>
</html>



