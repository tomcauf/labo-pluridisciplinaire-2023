<?php

require_once '../libs/repository/DbTrainingRequests.inc.php';
//require_once '../inc/formAddClient.inc.php';

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HOME</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    connecté

</header>
<main>
    <?php
    //getALLTrainings();
//    printForm();

    printfForm();

    ?>
    <!--        <table>-->
    <!--            <tr>-->
    <!--                <th>name</th>-->
    <!--                <th>location</th>-->
    <!--                <th>duration</th>-->
    <!--                <th>deadline</th>-->
    <!--                <th>confirmation</th>-->
    <!--                <th>active</th>-->
    <!--                <th>certificate_deadline</th>-->
    <!--            </tr>-->
    <!--            -->
    <!--        </table>-->

</main>
</body>
</html>