<?php
require_once "../libs/repository/DbTrainingRequests.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../scripts/sideBar.js" defer></script>
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
                        <img src="../assets/images/open_fullscreen.svg" alt="FullScreen">
                    </div>
                    <div>
                        <?php
                        //TODO changer pour celui de l'utilisateur
                        $allTraining = DbTrainingRequests::getAllTrainings();
                        foreach ($allTraining as $training){
                            echo '<div class="box-underline" onclick="goTo('.$training['id_training'].')">';
                            echo "<p>".$training['name']."</p>";
                            echo "<p>".$training['location']."</p>";
                            echo "<p>".$training['deadline']."</p>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
                <div class="box box-accreditation">
                    <div class="box-title">
                        <h2 class="title text">Accreditation</h2>
                        <img src="../assets/images/open_fullscreen.svg" alt="FullScreen">
                    </div>
                </div>
                <div class="box box-ongoing-training-">
                    <div class="box-title">
                        <h2 class="title text">On going Training</h2>
                        <img src="../assets/images/open_fullscreen.svg" alt="FullScreen">
                    </div>
                </div>
                <div class="box box-completed-training">
                    <div class="box-title">
                        <h2 class="title text">Finish Training</h2> 
                        <img src="../assets/images/open_fullscreen.svg" alt="FullScreen">
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function goTo(id){
            window.location.href = "info.php?id="+id+"&type=training";
        }
    </script>
</body>
</html>