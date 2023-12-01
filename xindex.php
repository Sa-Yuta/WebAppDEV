<?php
@session_start();

if (isset($_SESSION["USER"])) {
    require "timeline.php";
}else{
    require "welcome.php";
}
?>