<?php
include 'inc/session.inc.php';
require_once '../libs/repository/DbUserRequests.inc.php';

if(isset($_POST['editForm'])){
    $user = DbUserRequests::getUserById($_SESSION['user']);
    DbUserRequests::updateUser($_SESSION['user'], $_POST['firstname'], $_POST['name'], $_POST['email'], $user['manager'], $user['active']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../scripts/sideBar.js" defer></script>
    <title>Account</title>
</head>

<body>
    <?php include 'inc/header.inc.php'; ?>
    <main class="main">
        <?php include 'inc/menu.inc.php'; ?>
        <div class="user-management">
            <div class="box box-management">
                <div class="box-title box-underline">
                    <h2 class="title text">Account Information</h2>
                </div>
                <div class="profil">
                    <?php
                        $userId = $_SESSION['user'];
                        $user = DbUserRequests::getUserById($userId);
                        $userFunctions = DbUserRequests::getUserLinksFunction($userId);
                        if(!isset($_POST['edit'])) {
                            echo '<p class="profil-element"><span>Name</span> : ' . $user['name'] . '</p>';
                            echo '<p class="profil-element"><span>Firstname</span> : ' . $user['firstname'] . '</p>';
                            echo '<p class="profil-element"><span>Email</span> : ' . $user['email'] . '</p>';
                            echo '<p class="profil-element"><span>Function</span> : ';
                            foreach ($userFunctions as $function) {
                                echo $function['name'] . ", ";
                            }
                            echo substr($userFunctions[0]['name'], 0, -2);
                            echo '</p>';
                            echo '<form action="account.php" method="POST" enctype="application/x-www-form-urlencoded">';
                            echo '<button type="submit" id="edit" class="edit-profil" name="edit">Edit</button>';
                            echo '</form>';
                        } else {
                            echo '<form action="account.php" class="form-profil" method="POST" enctype="application/x-www-form-urlencoded">';
                            echo '    <input id="name" class="name-profil" name="name" type="text" value='. $user['name'] .' placeholder="name" required>';
                            echo '    <input id="firstname" class="firstname-profil" name="firstname" type="text" value='. $user['firstname'] .' placeholder="firstname" required>';
                            echo '    <input id="email" class="email-profil" name="email" type="text" value='. $user['email'] .'  placeholder="email" required>';
                            echo '    <input id="password" class="password-profil" name="password" type="password" placeholder="password" required>';
                            echo '    <button type="submit" class="submit-profil" name="editForm">Save changes</button>';
                            echo '</form>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>

</html>