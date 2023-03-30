<?php

require_once '../libs/repository/DbUserRequests.inc.php';

if(!isset($_SESSION ['user'])){
    session_start();
}
if(isset($_POST['submit'])){
    submitForm();
}

function submitForm(){
    $idManager = $_POST['manager'] =="" ?null : $_POST['manager'];
    DbUserRequests::storeNewUser($_POST['name'], $_POST['firstname'], $_POST['email'], $_POST['password'], $idManager);
}

function printForm(){
    $allUser = DbUserRequests::getAllUser();
    echo '<form action="" method="post">
    <input type="text" name="name" placeholder="name">
    <input type="text" name="firstname" placeholder="firstname">
    <input type="email" name="email" placeholder="abcde@gmail.com">
    <input type="password" name="password" placeholder="">
    
    <select name="manager" >
        <option value="">--Please choose an option--</option>';

    $allUser = array_filter($allUser, function ($user) {
        return $user['id_user'] != $_SESSION['user'];
    });
    foreach ($allUser as $user) {
        echo "<option value='" . $user['id_user'] . "'>" . $user['firstname'] . " " . $user['name'] . "</option>";
    }
    echo '</select>
    <input type="submit" name="submit" value="submit">
</form>
';
}

//pour set un manager, on met l'id



