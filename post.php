<?php
@session_start();
require 'Class.php';
Validate::checkSession('USER');

// フォームが送信されたかどうかを確認
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $array = [
        'user_id' => $_SESSION['USER']['USER_ID'],
        'content' => $content
    ];

    // 画像が選択されたか確認
    if (isset($_FILES["picture"]) AND $_FILES['picture']['name'] != "") {
        // postImageメソッドを使用して画像をアップロード
        $image_name = Post::postImage('postimg/','picture');
        $array['picture'] = $image_name;
    }

    if(dbHandler::insertData('Whispers',$array)){
        header("Location:timeline.php");
    }else{
        header("Location:error.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>whisper/post</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f8fa;
            color: #1c1e21;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #1da1f2;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin: 0 5px;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: #fff;
            color: #1da1f2;
        }

        hr {
            border: 0;
            height: 1px;
            background: #ccc;
            margin: 10px 0;
        }

        form {
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #1da1f2;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0d8dd8;
        }
    </style>
</head>
<body>
    <nav>
        <a href="javascript:history.back()">←</a>
        ポスト
    </nav>
    <hr>
    <form method="post" enctype="multipart/form-data">
        <input type="text" id="content" name="content" value="いまどうしてる？"><br>
        <input type="file" id="picture" name="picture"><br>
        <input type="submit" value="ささやく">
    </form>
</body>
</html>
