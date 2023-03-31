<?php
require_once "DbConnect.inc.php";

class DbTrainingRequests
{
    static function getAllTrainings()
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->prepare("SELECT * FROM Training");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function getTrainingActiveFor($id)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->prepare("SELECT * FROM Training WHERE id_training = :id");
            $query->bindValue(":id", $id);
            $query->execute();
            return $query->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    /**
     * @param $name
     * @param $description
     * @param $location
     * @param $duration
     * @param $deadline
     * @param $certificate_deadline
     * @return int|void the id of the last inserted
     */
    static function addTrainingCourse($name, $description, $location, $duration, $deadline, $certificate_deadline)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }


            $query = $link->prepare("INSERT INTO Training (name, description, location, duration, deadline, active, certificate_deadline) 
                                VALUES (:name, :description, :location, :duration, :deadline, 1, :certificate_deadline)");
            $query->bindValue(":name", $name);
            $query->bindValue(":description", $description);
            $query->bindValue(":location", $location);
            $query->bindValue(":duration", $duration);
            $query->bindValue(":deadline", $deadline);
            $query->bindValue(":certificate_deadline", $certificate_deadline);
            $query->execute();
            return intval($link->lastInsertId());
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    /**
     * @param $idTraining
     * @param ...$requiredTrainingIds
     * @return void
     */
    static function addRequiredTraining($idTraining, ...$requiredTrainingIds)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }
            foreach ($requiredTrainingIds as $requiredTrainingId) {
                $query = $link->prepare("INSERT INTO RequiredTraining(id_training, required_ID) VALUES(:idTraining, :requiredId)");
                $query->bindValue(":idTraining", $idTraining);
                $query->bindValue(":requiredId", $requiredTrainingId);
                $query->execute();
            }
        } catch (PDOException $e) {
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
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return (isset($results)) ? $results : "Something went wrong with the request";
        }
    }

    static function updateTrainingCourse($idTraining, $active, $name, $location, $duration, $deadline, $certificate_deadline)
    {

        if (!$active)
            return "Cannot update an archived training course";

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

    static function getTrainingLinksFunctions($idTraining)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT id_function FROM Operate WHERE id_training = :idTraining");
            $query->bindValue(":idTraining", $idTraining);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return (isset($results)) ? $results : "Something went wrong with the request";
        }
    }

    /**
     * @param $idTraining
     * @param ...$idFunctions
     * @return void
     */
    static function addLinksToTrainingFunction($idTraining, ...$idFunctions)
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
            $query = $link->prepare("SELECT id_user FROM Trainer WHERE id_training = :idTraining");
            $query->bindValue(":idTraining", $idTraining);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return (isset($results)) ? $results : "Something went wrong with the request";
        }
    }

    static function addLinksToTrainerUser($idTraining, ...$idUsers)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);

            foreach($idUsers as $idUser) {
                $query = $link->prepare("INSERT INTO Trainer(id_user, id_training) VALUES (:idUser, :idTraining);");
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

    /**
     * @param $idTraining
     * @param ...$idAccreditations
     * @return void
     */
    static function addLinksToTrainingAccreditation($idTraining, ...$idAccreditations)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);

            foreach($idAccreditations as $idAccreditation) {
                $query = $link->prepare("INSERT INTO GiveAccess(id_accreditation, id_training) 
                                                VALUES (:idAccreditation, :idTraining);");
                $query->bindValue(":idAccreditation", $idAccreditation);
                $query->bindValue(":idTraining", $idTraining);
                $query->execute();
            }
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function getTrainingLinksAccreditations($idTraining)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT a.id_training, a.name
                                            FROM Accrediation a
                                            JOIN GiveAccess ga AS ga.id_accreditationa = a.id_accrediation
                                            WHERE ga.id_training = :idTraining");
            $query->bindValue(":idTraining", $idTraining);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    /** Method that makes you able to add easily a new training completely!
     * @param $name string that's the name of the training
     * @param $description string that's the description of the training
     * @param $location string that's the location where the training is happening
     * @param $duration string that's the duration of the training in H:i:s
     * @param $deadline string that's the limit date at which the training becomes unavailable
     * @param $certificate_deadline integer that's the limit date at which the certificate is relevant
     * @param $requiredTrainingIds array of required training ids or "" if not set
     * @param $idFunctions array of the functions that are able to take this training or "" if not set
     * @param $idAccreditations array of the accreditations given by this training or "" if not set
     * @return void
     */
    static function addNewTraining($name, $description, $location, $duration, $deadline, $certificate_deadline, $requiredTrainingIds,$idFunctions, $idTrainers, $idAccreditations){
        $idTraining = self::addTrainingCourse($name, $description, $location, $duration, $deadline, $certificate_deadline);

        if($requiredTrainingIds != "") {
            self::addRequiredTraining($idTraining, $requiredTrainingIds);
        }
        if($idFunctions != "") {
            self::addLinksToTrainingFunction($idTraining, $idFunctions);
        }
        if($idTrainers != "") {
            self::addLinksToTrainerUser($idTraining, $idTrainers);
        }
        if($idAccreditations != "") {
            self::addLinksToTrainingAccreditation($idTraining, $idAccreditations);
        }
    }
}