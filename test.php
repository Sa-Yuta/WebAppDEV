<?php
require 'Class.php';

$image_name = "";

// フォームが送信されたかどうかを確認
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 画像が選択されたか確認
    if (isset($_FILES["image"]) AND $_FILES['image']['name'] != "") {
        // postImageメソッドを使用して画像をアップロード
        $image_name = Post::postImage('postimg/', 'image');
        echo $image_name;
    } else {
        echo '画像が選択されていません。';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像アップロード</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*">
        <button type="submit">アップロード</button>
    </form>
</body>
</html>
