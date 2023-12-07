<?php
@session_start();
require '../Class.php';

var_dump($_SESSION['LOGIN_INFO']);
Validate::checkSession('LOGIN_INFO');

$user_id = $_SESSION['LOGIN_INFO']['USER_ID'];
$pass = $_SESSION['LOGIN_INFO']['PASS'];

$login_result = Login::login($user_id,$pass);
if($login_result){
    header("Location:../timeline.php");
}else{
    echo 'failed';
}
?>