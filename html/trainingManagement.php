<?php
include 'inc/session.inc.php';
require_once '../libs/repository/DbTrainingRequests.inc.php';

if(isset($_POST['createTraining'])){
    DbTrainingRequests::addNewTraining($_POST['name'], $_POST['summary'], $_POST['location'], $_POST['duration'], $_POST['deadline'],
        $_POST['certificate_deadline'], $_POST['requis'], $_POST['function'], $_POST['trainers'], $_POST['accreditation']);
}
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
    <title>Training Management</title>
</head>

<body>
    <?php include 'inc/header.inc.php'; ?>
    <main class="main">
        <?php include 'inc/menu.inc.php'; ?>
        <div class="user-management">
            <h1 class="title text">Training Management</h1>
            <div class="boxs">
                <div class="box box-list-training">
                    <div class="box-title box-underline">
                        <h2 class="title text">List of Training</h2>
                        <img src="../assets/images/open_fullscreen.svg" class="box-list-training-btn" alt="FullScreen">
                    </div>
                    <div>
                    <div class="box-underline box-title">
                            <input type="text" name="search" class="search-user text" placeholder="Search">
                        </div>
                        <div class="box-underline box-title box-flex">
                            <p>Name</p>
                            <p>Location</p>
                            <p>Function</p>
                            <p>Actif</p>
                        </div>
                        <div class="box-underline box-element box-flex">
                            <p>Name</p>
                            <p>Location</p>
                            <p>Function</p>
                            <p>Actif</p>
                        </div>
                    </div>
                </div>
                <div class="box box-add-training">
                    <div class="box-title box-underline">
                        <h2 class="title text">Add a Training</h2>
                        <img src="../assets/images/open_fullscreen.svg" class="box-add-training-btn" alt="FullScreen">
                    </div>
                    <form method="post" class="form-training" enctype="application/x-www-form-urlencoded">
                        <input type="text" name="name" class="name-training text" placeholder="Name" required>
                        <input type="text" name="summary" class="summary-training text" placeholder="Summary" required>
                        <input type="text" name="location" class="location-training text" placeholder="Location" required>
                        <input type="number" name="duration" class="duration-training" placeholder="Duration (month)" required>
                        <input type="text" name="deadline" class="deadline-training" placeholder="Deadline (DD/MM/YYYY)" required>
                        <input type="text" name="certificate_deadline" class="certificate-deadline-training text" placeholder="Certificate deadline" required>
                        <select name="requis" id="requis" class="select-requis text" multiple>
                            <option value="1">Requis 1</option>
                            <option value="2">Requis 2</option>
                        </select>
                        <select name="function" id="function" class="select-function text" multiple>
                            <option value="1">Function 1</option>
                            <option value="2">Function 2</option>
                        </select>
                        <select name="trainers" id="trainers" class="select-trainers text" multiple>
                            <option value="1">Trainers 1</option>
                            <option value="2">Trainers 2</option>
                        </select>
                        <select name="accreditation" id="accreditation" class="select-trainers text" multiple>
                            <option value="1">Accreditation 1</option>
                            <option value="2">Accreditation 2</option>
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
    new MultiSelectTag('requis', {
        rounded: true,
        shadow: true
    })
    new MultiSelectTag('function', {
        rounded: true,
        shadow: true
    })
    new MultiSelectTag('trainers', {
        rounded: true,
        shadow: true
    })
    new MultiSelectTag('accreditation', {
        rounded: true,
        shadow: true
    })
</script>
</html>