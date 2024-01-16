<?php
@session_start();
require 'Class.php';

$id = $_REQUEST['id'];
$user_id = $_SESSION['USER']['USER_ID'];
$array = [
    'post_id' => $id,
    'user_id' => $user_id
];

$post = Timeline::showPostInfo($id);
// $src = Timeline::imgSrc($id, $user_id);
$src = 'icons/star8.png';
$like = Timeline::likeNum($id);

$sqlx = "SELECT user_id FROM Whispers WHERE id = ?;";
$tgt_id = dbHandler::query($sqlx,$id);
$xid = $tgt_id[0]['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flag = dbHandler::query("SELECT * FROM Likes WHERE post_id = ? AND user_id = ?;", $id, $user_id);
    if (empty($flag)) {
        dbHandler::insertData('Likes', $array);
        // いいねが追加された場合はカウントを増やす
        $like++;
    } else {
        Timeline::deleteData('Likes', $id, $user_id);
        // いいねが削除された場合はカウントを減らす
        $like--;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f8fa;
            color: #1c1e21;
            margin: 0;
            padding: 0;
        }

        a.icon {
            width: 50px;
            height: 50px;
        }

        nav {
            background-color: #1da1f2;
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

        img {
            max-width: 100%;
            height: auto;
        }

        form {
            margin-top: 10px;
        }

        .star-link {
            text-decoration: none;
            cursor: pointer;
        }

        .star-link img {
            width: 24px;
            height: 24px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="timeline.php">←</a>
        Post
        <hr>
    </nav>
    <a href="user_page.php?@=<?php echo $xid ?>" class="icon">
    <img id="icon" src="user_icon/default_icon.jpeg" alt="icon" width="50px" height="50px">
    </a>
    <?php echo $post['user_name'] ?><br>
    @<?php echo $post['user_id']; ?>
    <hr>
    <?php echo $post['content'] ?><br>
    <?php if (!empty($post['picture'])) {
        echo "<img src='postimg/" . $post['picture'] . "'><br>";
    }
    ?>
    <hr>
    <form method="post">
        <input type="hidden" name="like">
        <a href="#" class="star-link" onclick="switchStarImage(); return false;">
            <img id="starImage" src="<?php echo $src ?>" alt="Star1">
        </a>
        <span id="likeCount"><?php echo $like; ?></span>
    </form>

    <script>
        function switchStarImage() {
            var starImage = document.getElementById('starImage');
            var likeCount = document.getElementById('likeCount');
            var form = document.querySelector('form');

            // 現在の画像のsrcを取得
            var currentSrc = starImage.src;

            // 画像のsrcを切り替え
            if (currentSrc.endsWith('star6.png')) {
                starImage.src = 'icons/star8.png';
                // カウントを増やす
                likeCount.innerText = parseInt(likeCount.innerText) + 1;
            } else {
                starImage.src = 'icons/star8.png';
                // カウントを減らす
                likeCount.innerText = parseInt(likeCount.innerText) - 1;
            }

            // フォームの値を保持
            // ここでは何かしらの方法でフォームを送信することを想定しています
            form.submit();
        }
    </script>
</body>
</html>
