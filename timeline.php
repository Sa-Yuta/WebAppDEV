<?php
@session_start();
require 'Class.php';

$user_id = $_SESSION['USER']['USER_ID'];

$sql = "SELECT * FROM Whispers";
$result = dbHandler::query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twitter Timeline</title>
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

        .tweet {
            margin: 10px;
            padding: 10px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .tweet a {
            color: #1da1f2;
            text-decoration: none;
        }

        .tweet a:hover {
            text-decoration: underline;
        }

        .tweet img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .like-icon {
            width: 24px;
            height: 24px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="mypage.php">@<?php echo $_SESSION['USER']['USER_ID']?></a>
        <a href="timeline.php">Timeline</a>
        <a href="post.php">Post</a>
        <a href="logout.php">Logout</a>
        Timeline
    </nav>
    <hr>

    <?php
    foreach ($result as $contents) {
        if ($contents['flag'] != 1) {
            echo "<div class='tweet'>";
            echo "<a href='post_detail.php?id=" . $contents['id'] . "' style='text-decoration:none;'>";
            echo $contents['user_id'] . '<br>';
            echo $contents['content'] . '<br>';
            if (isset($contents['picture'])) {
                echo "<img src='postimg/" . $contents['picture'] . "'><br>";
            }
            echo "<img id='starImage_" . $contents['id'] . "' 
                src='" . Timeline::imgSrc($contents['id'], $user_id) . "' alt='Star1' class='like-icon'>"
                . Timeline::likeNum($contents['id']);
            // echo "<img id='replyImage_" . $contents['id'] . "' 
            // src='icons/reply.png' alt='replyIcon' width='24' height='24'>"
            // . Timeline::replyNum($contents['id']);
            echo '</a>';
            echo '</div>';
            echo '<hr>';
        }
    }
    ?>
</body>
</html>
