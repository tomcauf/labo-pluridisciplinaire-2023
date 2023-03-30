<?php
include 'inc/session.inc.php';
require_once '../libs/repository/DbUserRequests.inc.php'
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
                        echo '<p>Name : ' . $user['name'] . '</p>';
                        echo '<p>Firstname : ' . $user['firstname'] . '</p>';
                        echo '<p>Email : ' . $user['email'] . '</p>';
                        echo '<p>Functions : ';
                        foreach ($userFunctions as $function) {
                            echo $function['name'] . " ";
                        }
                        echo '</p>';
                    ?>
                    <p>toutes les info</p>
                    <button>Edit</button>
                </div>
            </div>
        </div>
    </main>
</body>

</html>