<?php
require_once "DbConnect.inc.php";

//TODO
class DbAccreditationRequests
{

    static function getAcreditationOfUser($id)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }
            if (!isset($id) || !is_numeric($id)) {
                return "L'id est invalide.";
            }

            $query = $link->prepare("Select a.name as name, a.id_accreditation as id from Accreditation a 
                                    join GiveAccess g on g.id_accreditation = a.id_accreditation
                                    join Participate p on p.id_training = g.id_training
                                    WHERE p.id_user = :id and p.status = 'VALIDATED'");
            $query->bindValue(":id", $id);

            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $exception) {
            return $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function addNewAccreditation($name)
    {
        if (!isset($name) || $name == "") {
            return "Le nom d'une accréditation ne peut être vide.";
        }
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("INSERT INTO Accreditation(name)
                                            VALUES(:name)");
            $query->bindValue(":name", $name);
        } catch (PDOException $exception) {
            return $exception->getMessage();
        } finally {
            DbConnect::disconnect($errorMessage);
        }
    }

    static function removeAccreditation($idAccreditation)
    {
        if (!isset($idAccreditation)) {
            return "L'id d'accréditation ne peut être null.";
        }
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("DELETE FROM Accreditation WHERE id_accreditation = :idAccreditation");
            $query->bindValue(":idAccreditation", $idAccreditation);
            $query->execute();
        } catch (PDOException $exception) {
            return $exception->getMessage();
        } finally {
            DbConnect::disconnect($errorMessage);
        }
    }

    static function updateAccreditation($idAccreditation, $name)
    {
        try{
            $link = DbConnect::connect2db($errorMessage);
            if($link == null)
                return $errorMessage;

            $query = $link->prepare("UPDATE Accreditation SET name = :name WHERE id_accreidation = :idAccrediation");
            $query->bindValue(":name", $name);
            $query->bindValue(":idAccreditation", $idAccreditation);
            $query->execute();
        } catch(PDOException $exception) {
            return $exception->getMessage();
        } finally{
            DbConnect::disconnect($link);
        }
    }

    static function getAllAccreditations()
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null)
                return $errorMessage;

            $query = $link->query("SELECT * FROM Acreditation");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            return $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function getAccreditationLinksTraining($idAccreditation)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if($link == null)
                return $errorMessage;
            $query = $link->prepare("SELECT tg.id_training, tg.name, tg.description
                                            FROM Training tg
                                            JOIN GiveAccess ga ON tg.id_training = ga.id_training
                                            WHERE ga.id_accreditation = :idAccreditation");
            $query->bindValue(":idAccreditation", $idAccreditation);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $message) {
            return $message->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function addLinksToAccreditationTraining($idAccreditation, ...$idTrainings)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if($link == null)
                return $errorMessage;

            foreach($idTrainings as $idTraining) {
                $query = $link->prepare("INSERT INTO GiveAccess(id_accreditation, id_training) VALUES (:idAccreditation, :idTraining)");
                $query->bindValue(":idAccreditation", $idAccreditation);
                $query->bindValue(":idTraining", $idTraining);
                $query->execute();
            }
        } catch (PDOException $exception) {
            return $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function removeLinksToAccreditationsTraining($idAccreditation, ...$idTrainings)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if($link == null)
                return $errorMessage;

            foreach($idTrainings as $idTraining) {
                $query = $link->prepare("DELETE FROM GiveAccess WHERE id_accreditation = :idAccrediation AND id_training = :idTraining");
                $query->bindValue(":idAccreditation", $idAccreditation);
                $query->bindValue(":idTraining", $idTraining);
                $query->execute();
            }
        } catch (PDOException $exception) {
            return $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }
}