<?php
session_start();

if(session_destroy()) {
    $_SESSION = [];
    $_COOKIE = [];
    setcookie("PHPSESSID","",time()-3600,"/");
    header('Location: ../../index.php');
}
?>
