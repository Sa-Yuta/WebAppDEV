<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f8fa;
            color: #1c1e21;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        input.button {
            background-color: #1da1f2;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input.button:hover {
            background-color: #fff;
            color: #1da1f2;
            border: 1px solid #1da1f2;
        }
    </style>
</head>
<body>
    ログアウトしますか？<br>
    <form method="post" action="logout_prc.php">
        <input type="submit" value="ログアウト" class="button">
    </form>
</body>
</html>
