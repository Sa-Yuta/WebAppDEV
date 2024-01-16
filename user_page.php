<?php
require 'Class.php';

$user_id = $_GET['@'];
$sql = "SELECT * FROM User JOIN User_info ON User.user_id = User_info.user_id WHERE User.user_id = ?;";
$array = Util::arrayDimChange2(dbHandler::query($sql,$user_id));

$sql2 = "SELECT * FROM Whispers WHERE user_id = ?;";
$result = dbHandler::query($sql2,$user_id);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール/<?php echo $array['user_name']?></title>
    <style>
        @charset "UTF-8";

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f8fa;
            color: #1c1e21;
            margin: 0;
            padding: 0;
        }

        img.icon {
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

        .profile-section {
            margin: 10px;
            padding: 10px;
            background-color: #fff;
            border-radius: 10px;
        }

        .profile-section.user_id{
            font-size: 60%;
            color: #888; /* 薄いグレー */
            font-style: italic;
        }

        .profile-section p {
            margin: 0;
            padding: 5px;
        }

        .post-section {
            margin: 10px;
            padding: 10px;
            background-color: #fff;
            border-radius: 10px;
        }

        .post-section a {
            text-decoration: none;
            color: #1da1f2;
        }

        .post-section a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav>
        <a href="javascript:history.back()">←</a>
        User_Page
    </nav>
    <hr>
    <div class="profile-section">
        <img src="user_icon/default_icon.jpeg" alt="Icon image" class="icon">
        <?php echo $array['user_name'];?><br>
        <?php echo '<span class="user-id">@',$array['user_id'] ,'</span>';?>
        <hr>
        <p><?php echo '自己紹介',$array['self_intro'];?></p>
        <hr>
        <p><?php echo $formattedDate = date('Y.m', strtotime($array['registday'])),'からWhisperを利用しています';?></p>
    </div>
    <hr>
    <div class="post-section">
        <?php
        foreach($result as $contents){
            if($contents['flag'] != 1){
                echo "<hr>";
                echo "<a href='post_detail.php?id="
                        .$contents['id']."' style='text-decoration:none;'>";
                echo $contents['user_id'] . '<br>';
                echo $contents['content'] . '<br>';
                if(isset($contents['picture'])){
                    echo "<img src='postimg/" . $contents['picture'] . "'><br>";
                }
                echo "<img id='starImage_" . $contents['id'] . "' 
                        src='icons/star8.png' alt='Star1' width='24' height='24'>"
                        . Timeline::likeNum($contents['id']);
                // echo "<img id='replyImage_" . $contents['id'] . "' 
                // src='icons/reply.png' alt='replyIcon' width='24' height='24'>"
                // . Timeline::replyNum($contents['id']);
                echo '</a>';
                echo '<hr>';
            }
        }
        ?>
    </div>
</body>
</html>
