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
    <title>Logs</title>
</head>

<body>
    <?php include 'inc/header.inc.php'; ?>
    <main class="main">
        <?php include 'inc/menu.inc.php'; ?>
        <div class="user-management">
            <h1 class="title text">Logs</h1>
            <div class="box box-management">
                <div class="box-title box-underline">
                    <h2 class="title text">Logs</h2>
                    <img src="../assets/images/open_fullscreen.svg" alt="FullScreen">
                </div>
                <div>
                    <div class="box-underline box-element">
                        <p>nom prenom</p>
                        <p>action</p>
                        <p>date</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>