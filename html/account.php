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
            <h1 class="title text">Account</h1>
            <div class="box box-management">
                <div class="box-title box-underline">
                    <h2 class="title text">Account Information</h2>
                </div>
                <div>
                    <?php
                        $userId = $_SESSION['user'];
                        $user = DbUserRequests::getUserById($userId);
                        $userFunctions = DbUserRequests::getUserLinksFunction($userId);

                        if(!isset($_POST['edit'])) {
                            echo '<p>Name : ' . $user['name'] . '</p>';
                            echo '<p>Firstname : ' . $user['firstname'] . '</p>';
                            echo '<p>Email : ' . $user['email'] . '</p>';
                            echo '<p>Functions : ';
                            foreach ($userFunctions as $function) {
                                echo $function['name'] . ";";
                            }
                            echo '</p>';
                        } else {
                            echo '<form action="account.php" method="POST" enctype="application/x-www-form-urlencoded">';
                            echo '    <input id="name" name="name" type="text" value='. $user['name'] .' required>';
                            echo '    <input id="firstname" name="firstname" type="text" value='. $user['firstname'] .' required>';
                            echo '    <input id="email" name="email" type="text" value='. $user['email'] .' required>';
                            echo '    <input id="password" name="password" type="password" required>';
                            echo '    <input id="repPassword" name="repPassword" type="password" required>';
                            echo '    <button type="submit" name="editForm">Save changes</button>';
                            echo '</form>';
                        }
                    ?>
                    <form action="account.php" method="POST" enctype="application/x-www-form-urlencoded">
                        <button type="submit" name="edit">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>