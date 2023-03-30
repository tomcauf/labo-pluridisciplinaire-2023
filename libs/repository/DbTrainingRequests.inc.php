<?php
require_once "DbConnect.inc.php";
require_once "libs/models/Training.php";

use models\Training;

class DbTrainingRequests
{

    static function addTrainingCourse($training)
    {
        try {
           $link = DbConnect::connect2db($errorMessage);
           if ($link == null) {
               return $errorMessage;
           }

           $query = $link->prepare("INSERT INTO Training (name, location, duration, deadline, confirmation, active, certificate_deadline) VALUES ()");



        }catch (PDOException $e){
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function archiveTrainingCourse($idTraining)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null)
                return $errorMessage;

            $query = $link->prepare("UPDATE Training SET active = 0 WHERE id_training = :idTraining");
            $query->bindValue(":idTraining", $idTraining);
            $query->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function unarchiveTrainingCourse($idTraining)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null)
                return $errorMessage;

            $query = $link->prepare("UPDATE Training SET active = 1 WHERE id_training = :idTraining");
            $query->bindValue(":idTraining", $idTraining);
            $query->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }
}