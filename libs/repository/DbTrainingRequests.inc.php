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

        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function getLastId()
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null)
                return $errorMessage;

            $query = $link->query("SELECT id_training FROM Training ORDER BY id_training DESC");
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

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

    static function addLinksToTrainingUser($idTraining, ...$idUsers)
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

    static function addLinksToTrainingAccreditation($idTraining, ...$idAccreditations)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);

            foreach($idAccreditations as $idAccreditation) {
                $query = $link->prepare("INSERT INTO GiveAccess(id_accreditation, id_training) 
                                                VALUES (:idAccreditation, :idTraining);");
                $query->bindValue(":idAccrediation", $idAccreditations);
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
}