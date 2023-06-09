<?php
include 'inc/session.inc.php';
require_once("../libs/repository/DbUserRequests.inc.php");
require_once("../libs/repository/DbFunctionsRequests.inc.php");
require_once ("../libs/repository/DbUserRequests.inc.php");


if(isset($_POST["submit-create-user"])){
    if(isset($_POST["firstname"]) && isset($_POST["name"]) && isset($_POST["email"])){
        $firstname = $_POST["firstname"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $idManager = isset($_POST["manager"]) ? $_POST["manager"] : null;
        $idAdded = DbUserRequests::storeNewUser($firstname, $name, $email, $idManager);

        /*
        foreach ($_POST["select"] as $function){
            DbUserRequests::addLinksToUserFunction($idAdded, $function);
        }
        */
    }
}
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
    <script src="../scripts/fullscreen.js" defer></script>
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
                        <img src="../assets/images/open_fullscreen.svg" class="box-management-btn" alt="FullScreen">
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
                        foreach ($users as $user) {
                            $name = $user['name'] . " " . $user['firstname'];
                            $functions = DbUserRequests::getUserLinksFunction($user['id_user']);
                            $functionString = "";
                            $imageLink = ($user['active']) ? "../assets/images/radio_button_green.svg" : "../assets/images/radio_button_red.svg";
                            foreach ($functions as $function) {
                                $functionString .= $function['name'] . "";
                            }
                            echo "<div class='box-underline box-element box-flex'>
                                        <p>$name</p>
                                        <p>$functionString</p>
                                        <span><img src='$imageLink' alt='connection state'></span></div>";
                        }
                        ?>
                    </div>
                </div>
                <div class="box box-add-user">
                    <div class="box-title box-underline">
                        <h2 class="title text">Add a user</h2>
                        <img src="../assets/images/open_fullscreen.svg" class="box-add-user-btn" alt="FullScreen">
                    </div>
                    <form method="post" action="" class="form-user">
                        <input type="text" name="firstname" class="firstname-user text" placeholder="Firstname" required>
                        <input type="text" name="name" class="name-user text" placeholder="Name" required>
                        <input type="text" name="email" class="email-user text" placeholder="Email" required>
                        <select name="manager" id="manager" class="select-user text">
                            <?php
                            $manager = DbUserRequests::getAllUser();
                            foreach ($manager as $m) {
                                //Si c'est moi, ne rien faire
                                if(!($m['id_user'] == $_SESSION['user'])){
                                    echo "<option value='" . $m['id_user'] . "'>" . $m['firstname'] . " " . $m['name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <select name="select[]" id="select" class="select-user text" multiple>
                            <?php
                            $function = DbFunctionsRequests::getAllFunction();
                            foreach ($function as $f) {
                                echo "<option value='" . $f['id_function'] . "'>" . $f['name'] . "</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" name="submit-create-user" class="submit-create-user">Create</button>
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
    new MultiSelectTag('select', {
        rounded: true,
        shadow: true
    })
</script>

</html>