<?php
require_once "DbConnect.inc.php";
require_once "libs/models/Training.php";

use models\Training;

class DbTrainingRequests
{

    static function addTrainingCourse($name, $location, $duration, $deadline, $certificate_deadline)
    {
        try {
           $link = DbConnect::connect2db($errorMessage);
           if ($link == null) {
               return $errorMessage;
           }

           $query = $link->prepare("INSERT INTO Training (name, location, duration, deadline, active, certificate_deadline) 
                                VALUES (:name, :location, :duration, :deadline, 1, :certificate_deadline)");
           $query->bindValue(":name", $name);
           $query->bindValue(":location", $location);
           $query->bindValue(":duration", $duration);
           $query->bindValue(":deadline", $deadline);
           $query->bindValue(":certificate_deadline", $certificate_deadline);
           $query->execute();

        }catch (PDOException $e){
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function addRequiredTraining($idTraining, ...$requiredTrainingIds)
    {
        try
        {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }
            foreach($requiredTrainingIds as $requiredTrainingId)
            {
                $query = $link->prepare("INSERT INTO RequiredTraining(id_training, required_ID) VALUES(:idTraining, :requiredId)");
                $query->bindValue(":idTraining", $idTraining);
                $query->bindValue(":requiredId", $requiredTrainingId);
                $query->execute();
            }
        } catch (PDOException $e)
        {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }

    }

    static function getRequiredTraining($idTraining)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->prepare("SELECT required_ID FROM RequiredTraining WHERE id_training = :idTraining");
            $query->bindValue(":idTraining", $idTraining);
            $query->execute();
            $results = $query->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return $results;
        }
    }

    static function updateTrainingCourse($idTraining, $name, $location, $duration, $deadline, $certificate_deadline)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->prepare("UPDATE Training
                                            SET name= :name, location= :location, duration= :duration, deadline= :deadline, certificate_deadline= :certificateDeadline
                                            WHERE id_training= :idTraining");
            $query->bindValue(":name", $name);
            $query->bindValue(":location", $location);
            $query->bindValue(":duration", $duration);
            $query->bindValue(":deadline", $deadline);
            $query->bindValue(":certificateDeadline", $certificate_deadline);
            $query->bindValue(":idTraining", $idTraining);
            $query->execute();

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

    static function getTrainingLinks($idTraining)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT id_function FROM Operate WHERE id_training = :idTraining");
            $query->bindValue(":idTraining", $idTraining);
            $query->execute();
            $results = $query->fetchAll();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return $results;
        }
    }

    static function addLinksToTraining($idTraining, ...$idFunctions)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);

            foreach($idFunctions as $idFunction) {
                $query = $link->prepare("INSERT INTO Operate(id_training, id_function) VALUES (:idTraining, :idFunction);");
                $query->bindValue(":idTraining", $idTraining);
                $query->bindValue(":idFunction", $idFunction);
                $query->execute();
            }
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function getTrainingLinksUser($idTraining)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT id_user FROM Training WHERE id_training = :idTraining");
            $query->bindValue(":idTraining", $idTraining);
            $query->execute();
            $results = $query->fetchAll();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return $results;
        }
    }

    static function addLinksToTrainingUser($idTraining, ...$idUsers)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);

            foreach($idUsers as $idUser) {
                $query = $link->prepare("INSERT INTO Training(id_user, id_training) VALUES (:idUser, :idTraining);");
                $query->bindValue(":idUser", $idUser);
                $query->bindValue(":idTraining", $idTraining);
                $query->execute();
            }
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }
}