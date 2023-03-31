<?php
include 'inc/session.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../scripts/sideBar.js" defer></script>
    <script src="../scripts/fullscreen.js" defer></script>
    <title>Register Management</title>
</head>

<body>
    <?php include 'inc/header.inc.php'; ?>
    <main class="main">
        <?php include 'inc/menu.inc.php'; ?>
        <div class="user-management">
            <h1 class="title text">Register Management</h1>
            <div class="box box-register-management">
                <div class="box-title box-underline">
                    <h2 class="title text">List of Users signing up for training</h2>
                    <img src="../assets/images/open_fullscreen.svg" class="box-register-management-btn" alt="FullScreen">
                </div>
                <div>
                    <div class="box-underline box-title box-flex">
                        <p>Name</p>
                        <p>Function</p>
                        <p>Training Name</p>
                    </div>
                    <div class='box-underline box-element box-flex'>
                        <p>John Doe</p>
                        <p>Developer</p>
                        <p>PHP</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>