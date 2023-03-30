<?php
include_once 'libs/repository/DbUserRequests.inc.php';
session_start();


if(isset($_SESSION['user'])){
    header('Location: html/dashboard.php');
}

session_destroy();
/**
 * @param $email string the email to verify
 * @param $password string the password to verify
 * @return bool true if the form is valid, false otherwise
 */
function verifyFormArg($email, $password)
{
    if (empty($email) || empty($password)) {
        return false;
    }
    return true;
}
$errorMessage = "";
if(isset($_POST['email']) && isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (verifyFormArg($email, $password)) {
        $result = DbUserRequests::getUserDataAndVerifyPsw($email, $password);
        if(is_string($result)){
            $errorMessage = $result;
        }else if(!$result) {
            $errorMessage = "the email or the password is incorrect";
        }else {
            session_start();
            $_SESSION['user'] = $result;
            header('Location: html/home.php');
        }
    } else {
        $errorMessage = "Please fill all the fields";
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="./scripts/script.js" defer></script>
    <title>Trasis - Sign In</title>
</head>
<body>
<header class="top-nav header">
    <img class="logo" src="assets/images/logoTrasis.svg" alt="Logo Trasis">
</header>
<main>
    <h1 class="title-sign text">Hello</h1>
    <h2 class="subtitle-sign text">Sign in to your account</h2>
    <div class="error">
    <?php
    if(isset($_POST['email']) && isset($_POST['password'])) {
        echo '<p class="error-message text">'.$errorMessage.'</p>';
    }
    ?>
    </div>
    <form action="index.php" class="form-sign" method="post">
        <input type="text" class="email-icon email-sign text" id="mail" name="email" placeholder="Email" <?php
        if(isset($_POST['email']) && isset($_POST['password'])) {
            echo 'value="'.$email.'"';
        }
        ?>>
        <input type="password" class="password-icon password-sign text" id="password" name="password"
               placeholder="Password">
        <div class="submit-sign">
            <span class="submit-sign-message text">Sign in</span>
            <button class="submit-sign-button">
                <img class="button-image" src="assets/images/arrow_forward.svg" alt="Submit image">
            </button>
        </div>
    </form>
</main>
<footer>
    <p>Labo Pluridisciplinaire - Trasis | All rights reserved</p>
</footer>
</body>
</html>