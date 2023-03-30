<?php

require_once '../libs/repository/DbTrainingRequests.inc.php';
require_once '../inc/formAddClient.inc.php';

include_once '../inc/formAddClient.inc.php';


if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
}

function getALLTrainings()
{
    $allTrainnig = DbTrainingRequests::getALLTrainings();

    foreach ($allTrainnig as $training) {
        echo "<tr>
            <td>" . $training['name'] . "</td>
            <td>" . $training['location'] . "</td>
            <td>" . $training['duration'] . "</td>
            <td>" . $training['deadline'] . "</td>
            <td>" . $training['confirmation'] . "</td>
            <td>" . $training['active'] . "</td>
            <td>" . $training['certificate_deadline'] . "</td>
            </tr>";
    }
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
    printForm();
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