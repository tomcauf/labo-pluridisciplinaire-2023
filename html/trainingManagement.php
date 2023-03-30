<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../scripts/sideBar.js" defer></script>
    <title>Training Management</title>
</head>

<body>
    <?php include 'inc/header.inc.php'; ?>
    <main class="main">
        <?php include 'inc/menu.inc.php'; ?>
        <div class="user-management">
            <h1 class="title text">Training Management</h1>
            <div class="boxs">
                <div class="box box-management">
                    <div class="box-title box-underline">
                        <h2 class="title text">List of Training</h2>
                        <img src="../assets/images/open_fullscreen.svg" alt="FullScreen">
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
                <div class="box box-management">
                    <div class="box-title box-underline">
                        <h2 class="title text">Add a Training</h2>
                        <img src="../assets/images/open_fullscreen.svg" alt="FullScreen">
                    </div>
                    <!-- $name, $description, $location, $duration, $deadline, $certificate_deadline, $listOfFunction, $listOfTrainers, $listOfRequis -->
                    <form method="post" class="form-training">
                        <input type="text" name="name" class="text" placeholder="Name" required>
                        <input type="text" name="summary" class="text" placeholder="Summary" required>
                        <input type="text" name="location" class="text" placeholder="Location" required>
                        <input type="number" name="summary" class="" placeholder="Duration (month)" required>
                        <input type="text" name="deadline" class="" placeholder="Deadline (DD/MM/YYYY)" required>
                        <input type="text" name="certificate_deadline" class="text" placeholder="">
                        
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