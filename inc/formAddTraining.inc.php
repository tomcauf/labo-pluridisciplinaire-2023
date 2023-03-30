<?php
require_once '../libs/repository/DbUserRequests.inc.php';
require_once '../libs/repository/DbTrainingRequests.inc.php';


function submitForm()
{

    if (verifyForm()) {
        $name = $_POST['name'];
        $location = $_POST['location'];
        $duration = $_POST['duration'];
        $deadline = $_POST['deadline'];
        $certificate_deadline = $_POST['certificate_deadline'];
        DbTrainingRequests::addTrainingCourse($name, $location, $duration, $deadline, $certificate_deadline);
    } else {
        //make known that the form is not complete
        echo "error";
    }

}
function verifyForm()
{
    if (isset($_POST['name']) && isset($_POST['location']) && isset($_POST['duration']) && isset($_POST['deadline']) && isset($_POST['certificate_deadline'])
        && !empty($_POST['name']) && !empty($_POST['location']) && !empty($_POST['duration']) && !empty($_POST['deadline']) && !empty($_POST['certificate_deadline'])) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['submit'])) {
    submitForm();
}
function printfForm()
{
    echo '<form action="" method="post">
    <input type="text" name="name" placeholder="name">
    <input type="text" name="location" placeholder="location">
    <input type="time" name="duration" placeholder="duration">
    <input type="date" name="deadline" placeholder="deadline">
    <input type="date" name="certificate_deadline" placeholder="certificate_deadline">
    <input type="submit" name="submit" value="submit">
    </form>';
}
