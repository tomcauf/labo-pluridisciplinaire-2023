<?php
session_start();
$path = $_SERVER['PHP_SELF'];
$file = basename($path);
if(isset($_SESSION['user'])){
    if($file == 'index.php'){
        header('Location: html/dashboard.php');
    }
} else{
    if($file !== 'index.php'){
        header('Location: ../index.php');
    }
}
?>
