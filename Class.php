<?php
class dbHandler {
    const DB_NAME = "whisper_db";
    const HOST = "localhost";
    const UTF = "utf8";
    const USER = "root";
    const PASS = "";

    public static function connect(){
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

    public static function query($sql, ...$params){
        $pdo = self::connect();

        try {
            $stmt = $pdo->prepare($sql);

            // パラメータが存在する場合、バインドを行う
            if (!empty($params)) {
                $stmt->execute($params);
            } else {
                $stmt->execute();
            }

            // ここで結果を取得したり処理したりする
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Query Error: " . $e->getMessage();
        }

        return $result;
    }

    public static function insertData($table_name, $datas) {
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
            header("Location:error.php");
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

    public static function checkSession($session_name){
        if (!isset($_SESSION[$session_name])) {
            header("Location:error.php");
            exit();
        }
    }
}

class Util{
    function generateSecureRandomNumber($length) {
        //$length...出力される桁数
        // バイト数を計算
        $byteLength = ceil($length * 0.75);
        // バイナリデータを生成
        $randomBytes = random_bytes($byteLength);
        // ランダムな数字に変換
        $randomNumber = hexdec(bin2hex($randomBytes));
        // 桁数を調整
        $randomNumber %= pow(10, $length);
    
        return str_pad($randomNumber, $length, '0', STR_PAD_LEFT);
    }
}