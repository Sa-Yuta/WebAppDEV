<?php
class dbHandler {
    const DB_NAME = "whisper_db";
    const HOST = "localhost";
    const UTF = "utf8";
    const USER = "root";
    const PASS = "";

    public static function connect(){
        //DB接続
        $dbn = "mysql:dbname=". self::DB_NAME .";host=". self::HOST .";charset=". self::UTF;
        $user = self::USER;
        $pass = self::PASS;

        try{
            $pdo = new PDO($dbn, $user, $pass);
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
            echo "ERROR!" . $e->getMessage();
            exit;
        }

        return $pdo;
    }

    public static function query($sql,...$params) {
        //SQL問合せ
        $pdo = self::connect();

        try {
            $stmt = $pdo->prepare($sql);
            // パラメータが存在する場合、バインドを行う
            if (!empty($params)) {
                $stmt->execute($params);  // 配列を渡す
            } else {
                $stmt->execute();
            }

            // ここで結果を取得したり処理したりする
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // エラーメッセージを明示的に表示
            echo "Query Error: " . $e->getMessage();
            // エラーが発生した場合、適切な対処を行う（例: ログに記録する、エラーページにリダイレクトする など）
        }

        return $result;
    }
    public static function isExecuteQuery($sql, ...$params) {
        // SQL問合せ
        $pdo = self::connect();
    
        try {
            $stmt = $pdo->prepare($sql);
            // パラメータが存在する場合、バインドを行う
            if (!empty($params)) {
                $stmt->execute($params);  // 配列を渡す
            } else {
                $stmt->execute();
            }
    
            // ここで結果を取得したり処理したりする
            // 今回は成功したことを示すために true を返す
            return true;
    
        } catch (PDOException $e) {
            // エラーメッセージを明示的に表示
            echo "Query Error: " . $e->getMessage();
            // エラーが発生した場合、false を返す
            return false;
            // エラーが発生した場合、適切な対処を行う（例: ログに記録する、エラーページにリダイレクトする など）
        }
    }
    
    public static function insertData($table_name,array $datas) {
        //$datas = [$key => $values]
        try {
            $pdo = self::connect();
            // エラーモードを例外に設定
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // データを挿入するSQL文の作成
            $columns = implode(', ', array_keys($datas));
            $values = ':' . implode(', :', array_keys($datas));
            $sql = "INSERT INTO $table_name ($columns) VALUES ($values)";
            // プリペアドステートメントの作成
            $stmt = $pdo->prepare($sql);
            // 配列から値をバインド
            foreach ($datas as $key => $value) {
                $stmt->bindParam(":$key", $datas[$key]);
            }
            // SQL実行
            $stmt->execute();
            return true;

        } catch (PDOException $e) {
            $_SESSION['ERROR']['DB'] =  "エラー: " . $e->getMessage();
            header("Location:sql_error.php");
        }
    }


}


class Validate{
    public static function len($input, int $low, int $high){
        $length = strlen($input);
        return $length > $low AND $length <= $high;
    }

    public static function pattern($input) {
        return preg_match('/[A-Z]/', $input) AND preg_match('/[a-z]/', $input) AND preg_match('/[0-9]/', $input);
    }

    public static function password($password){
        // passwordの長さが8文字以上16文字以下か？
        $valid1 = self::len($password, 8, 16);
        if (!$valid1){
            return 'パスワードは8～16文字で入力してください。';
        }

        // passwordに大文字、小文字、数字以外が使用されていないか？
        $valid2 = self::pattern($password);
        if (!$valid2){
            return '大文字、小文字、数字はそれぞれ1文字以上含まれる必要があります。';
        }

        // すべてクリアした場合Trueを返す
        return true;
    }

    public static function userId($user_id){
        // ユーザーID(@abcde_12345)の検証
        $valid1 = self::len($user_id, 5, 20);
        if (!$valid1){
            return 'ユーザー名は5文字以上20文字以下で入力してください。';
        }

        $valid2 = self::pattern($user_id);
        if (!$valid2){
            return '使用できる文字は半角英数のみです。';
        }

        return true;
    }

    public static function isEmail($email) {
        // メールアドレスの正規表現
        $emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        // 正規表現にマッチするかどうかを確認
        return preg_match($emailPattern, $email) === 1;
    }

    public static function checkSession($session_name){
        if (!isset($_SESSION[$session_name])) {
            header("Location:error.php");
            exit();
        }
    }

    public static function isEqualValues($value1,$value2){
        if($value1 == $value2){
            return true;
        }else{
            return false;
        }
    }

}

class Login{
    public static function login(string $user_id,string $pass){
        $sql = 'SELECT pass FROM User WHERE user_id = ?;';
        $results = dbHandler::query($sql,$user_id);
        foreach($results as $key => $value){
            $check_pass = $value['pass'];
        }

        return password_verify($pass, $check_pass);
    }
}

class Timeline{
    public static function imgSrc($post_id,$user_id){
        $sql = 'SELECT * FROM Likes WHERE post_id = ? AND user_id  = ?;';
        $results = dbHandler::query($sql,$post_id,$user_id);

        if(empty($results)){
            return 'icons/star8.png';
        }else{
            return 'icons/star6.png';
        }
    }

    public static function likeNum($post_id){
        $sql = "SELECT COUNT(*) AS likeNum FROM Likes WHERE post_id = ?;";
        $likes = Util::arrayDimChange2(dbHandler::query($sql,$post_id));

        return $likes['likeNum'];
    }

    public static function showPostInfo($post_id){
        $sql = "SELECT User.user_id AS user_id,
                       User.user_name AS user_name,
                       User_info.icon_pic AS icon,
                       Whispers.content AS content,
                       Whispers.picture AS picture
                FROM User 
                JOIN User_info ON User.user_id = User_info.user_id
                JOIN Whispers ON User.user_id = Whispers.user_id
                WHERE Whispers.id = ?;";
        $result = Util::arrayDimChange2(dbHandler::query($sql,$post_id));

        return $result;
    }

    public static function deleteData($table_name, $post_id,$user_id){
        $sql = "DELETE FROM $table_name WHERE post_id = ? AND user_id = ?;";
        $resalt = dbHandler::isExecuteQuery($sql,$post_id,$user_id);
        // if(!$resalt){
        //     // header("Location:sql_error.php");
        // }
        return $resalt;
    }

}

class Post{
    public static function postImage($post_dir_name,$form_name){

        $uploadDirectory = $post_dir_name;  // アップロード先のディレクトリ

        // アップロードされた画像の情報を取得
        $fileName = $_FILES[$form_name]["name"];
        $fileTmpName = $_FILES[$form_name]["tmp_name"];
        $fileSize = $_FILES[$form_name]["size"];
        $fileType = $_FILES[$form_name]["type"];
        $fileError = $_FILES[$form_name]["error"];

        // 画像の拡張子を取得
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // 許可された拡張子
        $allowedExtensions = ["jpg", "jpeg", "png", "gif"];

        // 拡張子が許可されているか確認
        if (in_array($fileExtension, $allowedExtensions)) {
            // 画像のサイズを確認（任意の制限を設定することも可能）
            if ($fileSize <= 5 * 1024 * 1024) {  // 5 MBまで
                // 一意のファイル名を生成
                $uniqueFileName = uniqid('image_') . '.' . $fileExtension;

                // 画像を指定のディレクトリに移動
                $uploadPath = $uploadDirectory . $uniqueFileName;
                move_uploaded_file($fileTmpName, $uploadPath);

                // 画像のリサイズ（500x500に調整）
                list($width, $height) = getimagesize($uploadPath);
                $newWidth = 500;
                $newHeight = 500;
                $imageResized = imagecreatetruecolor($newWidth, $newHeight);

                if ($fileExtension == "jpg" || $fileExtension == "jpeg") {
                    $image = imagecreatefromjpeg($uploadPath);
                } elseif ($fileExtension == "png") {
                    $image = imagecreatefrompng($uploadPath);
                } elseif ($fileExtension == "gif") {
                    $image = imagecreatefromgif($uploadPath);
                }

                imagecopyresampled($imageResized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                // リサイズ後の画像を保存（元の画像は削除）
                imagejpeg($imageResized, $uploadPath, 100);
                imagedestroy($imageResized);

                return $uniqueFileName;
            } else {
                echo "アップロードされた画像のサイズが制限を超えています。";
                exit;
            }
        } else {
            echo "許可されていない拡張子です。";
            exit;
        }
    }
}

class Util{
    function generateSecureRandomNumber($length) {
        //$length...出力される桁数
        $byteLength = ceil($length * 0.75);
        $randomBytes = random_bytes($byteLength);
        $randomNumber = hexdec(bin2hex($randomBytes));
        $randomNumber %= pow(10, $length);

        return str_pad($randomNumber, $length, '0', STR_PAD_LEFT);
    }

    public static function arrayDimChange2(array $array){
        $returnArray = [];

        foreach($array as $arrayAlias){
            foreach($arrayAlias as $key => $value){
                $returnArray[$key] = $value;
            }
        }

        return $returnArray;
    }

}

