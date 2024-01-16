<?php
@session_start();

// セッション破棄
session_destroy();

// ログアウト後の遷移先（例: index.php）
$redirect_url = 'index.php';

// リダイレクト
header("Location: $redirect_url");
exit();
?>
