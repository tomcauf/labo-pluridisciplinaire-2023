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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
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
            <div class="boxs">
                <div class="box box-management">
                    <div class="box-title box-underline">
                        <h2 class="title text">List of Users</h2>
                        <img src="../assets/images/open_fullscreen.svg" alt="FullScreen">
                    </div>
                    <div>
                        <div class="box-underline box-title">
                            <input type="text" name="search" class="search-user text" placeholder="Search">
                        </div>
                        <div class="box-underline box-title box-flex">
                            <p>Name</p>
                            <p>Function</p>
                            <p>Actif</p>
                        </div>
                        <?php
                            foreach($users as $user) {
                                $name = $user['name'] . " " . $user['firstname'];
                                $functions = DbUserRequests::getUserLinksFunction($user['id_user']);
                                $functionString = "";
                                $imageLink = ($user['active']) ? "/assets/images/radio_button_green.svg" : "../assets/images/radio_button_red.svg";
                                foreach($functions as $function) {
                                    $functionString .= $function['name']."";
                                }
                                echo "<div class='box-underline box-element box-flex'
                                        <p>$name</p>
                                        <p>$functionString</p>
                                        <img src='$imageLink' alt='connection state'></div>";
                            }
                        ?>
                    </div>
                </div>
                <div class="box box-management">
                    <div class="box-title box-underline">
                        <h2 class="title text">Add a user</h2>
                        <img src="../assets/images/open_fullscreen.svg" alt="FullScreen">
                    </div>
                    <form method="post" class="form-user">
                        <input type="text" name="firstname" class="firstname-user text" placeholder="Firstname" required>
                        <input type="text" name="name" class="name-user text" placeholder="Name" required>
                        <input type="text" name="email" class="email-user text" placeholder="Email" required>
                        <select name="manager" id="manager" class="select-user text" multiple>
                            <option value="1">Employe</option>
                        </select>
                        <button class="submit-create-user">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="../scripts/multiSelectTag.js"></script>
<script>
    new MultiSelectTag('manager', {
    rounded: true,
    shadow: true
})
</script>
</html>