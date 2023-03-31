<?php
require_once "../libs/repository/DbTrainingRequests.inc.php";
require_once "../libs/repository/DbUserRequests.inc.php";
require_once "../libs/repository/DbFunctionsRequests.inc.php";
require_once "../libs/repository/DbAccreditationRequests.inc.php";

$idUser = 3;

//var_dump(DbUserRequests::storeNewUserWithPassword("test", "te", "test", 1,  "test" ));

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
    <title>Dashboard</title>
</head>

<body>
<?php include 'inc/header.inc.php'; ?>
<main class="main">
    <?php include 'inc/menu.inc.php'; ?>
    <div class="dashboard">
        <h1 class="title text">Dashboard</h1>
        <div class="boxs">
            <div class="box box-training">
                <div class="box-title box-underline">
                    <h2 class="title text">List of Training</h2>
                    <img src="../assets/images/open_fullscreen.svg" class="box-training-btn" id="fullscreen" alt="FullScreen">
                </div>
                <div>
                    <div class="box-underline box-title box-flex">
                        <p>Name</p>
                        <p>Location</p>
                        <p>Date</p>
                    </div>
                    <?php

                    $allFunctions = DbUserRequests::getUserLinksFunction($idUser);
                    $allTraining = array();
                    $allSubsribedTraining = DbUserRequests::getAllParticipeTraining($idUser);
                    $allSubsribedTraining = array_map(function ($training) {
                        return $training['id'];
                    }, $allSubsribedTraining);
                    foreach ($allFunctions as $function) {
                        $allTraining = array_merge($allTraining, DbFunctionsRequests::getFunctionLinksTraining($function['id_function']));
                    }

                    $allTraining = array_filter($allTraining, function ($training) use ($allSubsribedTraining) {
                        foreach ($allSubsribedTraining as $subscribedTraining) {
                            if ($training['id_training'] == $subscribedTraining)
                                return false;
                        }
                        return $training['active'] == 1;
                    });
                    if (empty($allTraining))
                        echo '<div class="box-underline box-element box-flex"><p>There is no training</p></div>';
                    else
                        foreach ($allTraining as $training) {
                            echo '<div class="box-underline box-element box-flex" onclick="goTo(' . $training['id_training'] . ')">';
                            echo "<p>" . $training['name'] . "</p>";
                            echo "<p>" . $training['location'] . "</p>";
                            echo "<p>" . $training['deadline'] . "</p>";
                            echo "</div>";
                        }

                    ?>
                </div>
            </div>
            <div class="box box-accreditation">
                <div class="box-title">
                    <h2 class="title text">Accreditation</h2>
                    <img src="../assets/images/open_fullscreen.svg" class="box-accreditation-btn" alt="FullScreen">
                </div>
                <div>
                    <div class="box-underline box-title box-flex">
                        <p>Name</p>
                    </div>
                    <?php
                    $allAccreditation = DbAccreditationRequests::getAcreditationOfUser($idUser);

                    if (empty($allAccreditation))
                        echo "<div class='box-underline box-element box-flex'>
                                <p>There is no accreditation</p>
                                </div>";
                    else
                        foreach ($allAccreditation as $accreditation) {
                            echo '<div class="box-underline box-element box-flex" onclick="goTo(' . $accreditation['id_accreditation'] . ')">';
                            echo "<p>" . $accreditation['name'] . "</p>";
                            echo "</div>";
                        }


                    ?>
                </div>
            </div>
            <div class="box box-ongoing-training">
                <div class="box-title">
                    <h2 class="title text">On going Training</h2>
                    <img src="../assets/images/open_fullscreen.svg" class="box-ongoing-training-btn" alt="FullScreen">
                </div>
                <div>
                    <div class="box-underline box-title box-flex">
                        <p>Name</p>
                        <p>Location</p>
                        <p>Date</p>
                        <p>Status</p>
                    </div>
                    <?php
                    $allTraining = DbUserRequests::getAllParticipantTrainingDoing($idUser);
                    if (empty($allTraining))
                        echo "<div class='box-underline box-element box-flex'>
                                <p>There is no ongoing training</p>
                                </div>";
                    else {
                        foreach ($allTraining as $training) {
                            echo '<div class="box-underline box-element box-flex" onclick="goTo(' . $training['id'] . ')">';
                            echo "<p>" . $training['name'] . "</p>";
                            echo "<p>" . $training['location'] . "</p>";
                            echo "<p>" . $training['deadline'] . "</p>";
                            echo "<p>" . $training['status'] . "</p>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="box box-completed-training">
                <div class="box-title">
                    <h2 class="title text">Finish Training</h2>
                    <img src="../assets/images/open_fullscreen.svg" class="box-completed-training-btn" alt="FullScreen">
                </div>
                <div>
                    <div class="box-underline box-title box-flex">
                        <p>Name</p>
                        <p>Location</p>
                        <p>Date</p>
                    </div>
                    <?php
                    $allTraining = DbUserRequests::getAllParticipantTrainingValide($idUser);
                    if (empty($allTraining))
                        echo "<div class='box-underline box-element box-flex'>
                                <p>There is no finish training</p>
                                </div>";
                    else {
                        foreach ($allTraining as $training) {
                            echo '<div class="box-underline box-element box-flex" onclick="goTo(' . $training['id'] . ')">';
                            echo "<p>" . $training['name'] . "</p>";
                            echo "<p>" . $training['location'] . "</p>";
                            echo "<p>" . $training['deadline'] . "</p>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    function goTo(id) {
        window.location.href = "info.php?id=" + id + "&type=training";
    }
</script>
</body>

</html>