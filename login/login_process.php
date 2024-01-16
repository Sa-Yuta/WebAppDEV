<?php
@session_start();
require '../Class.php';

Validate::checkSession('LOGIN_INFO');

$user_id = $_SESSION['LOGIN_INFO']['USER_ID'];
$pass = $_SESSION['LOGIN_INFO']['PASS'];

$login_result = Login::login($user_id, $pass);

if ($login_result) {
    // ログイン成功時の処理
    if (isset($_SESSION['USER'])) {
        $_SESSION['USER'] = [];
    }

    $_SESSION['USER'] = [
        'USER_ID' => $user_id,
        'LOGIN_DATE' => date('Y-m-d')
    ];

    header("Location:../timeline.php");
} else {
    // ログイン失敗時の処理
    echo 'failed';
    if (isset($_SESSION['USER'])) {
        $_SESSION['USER'] = [];
    }
}
?>
