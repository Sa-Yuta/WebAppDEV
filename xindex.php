<?php
@session_start();

if (isset($_SESSION['LOGIN'])) {
    require 'timeline.php';
}else{
    require 'welcome.php';
}
?>