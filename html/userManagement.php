<?php
require_once("../libs/repository/DbUserRequests.inc.php");

$users = DbUserRequests::getAllUser();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../scripts/sideBar.js" defer></script>
    <title>User Management</title>
</head>

<body>
    <?php include 'inc/header.inc.php'; ?>
    <main class="main">
        <?php include 'inc/menu.inc.php'; ?>
        <div class="user-management">
            <h1 class="title text">User Management</h1>
            <div class="box box-management">
                <div class="box-title box-underline">
                    <h2 class="title text">List of Users</h2>
                    <img src="../assets/images/open_fullscreen.svg" alt="FullScreen">
                </div>
                <div>
                    <?php
                    foreach($users as $user) {
                        $name = $user['name'] . " " . $user['firstname'];
                        $functions = DbUserRequests::getUserLinksFunction($user['id_user']);
                        $functionString = "";
                        $imageLink = ($user['active']) ? "../assets/images/radio_button_green.svg" : "../assets/images/radio_button_red.svg";
                        foreach($functions as $function) {
                            $functionString .= $function['name']."";
                        }
                        echo "<div class='box-underline- box-element'
                                    <p>$name</p>
                                    <p>$functionString</p>
                                    <img src='$imageLink' alt='connection state'>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>