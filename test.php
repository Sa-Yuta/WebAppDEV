<?php
require'Class.php';

$params = [
    'user_id' => 'test_user02',
    'user_name' => 'name',
    'email' => 'mail',
    'pass' => 'password',
    'birthday' => 'birthday',
    'registday' => date('Y-m-d'),
    'self_intro' => null,
    'header_pic' => null,
    'icon_pic' => null
];
function generateSecureRandomNumber($length = 6) {
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

// 6桁のセキュアなランダムな数字を生成
$secureRandomNumber = generateSecureRandomNumber();

echo $secureRandomNumber;


?>