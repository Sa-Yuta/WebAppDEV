<?php
@session_start();

if (isset($_SESSION['LOGIN_INFO'])) {
    require 'timeline.php';
}else{
    require 'welcome.php';
}
?>