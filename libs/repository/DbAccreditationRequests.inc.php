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
            //TODO: Terminer
            $query = $link->prepare("DELETE");

        } catch (PDOException $exception) {

        } finally {
            DbConnect::disconnect($errorMessage);
        }
    }

    static function updateAccreditation($idAccreditation)
    {

    }

    static function getAllAccreditations()
    {

    }

    static function getAccreditationLinksTraining($idAccreditation)
    {

    }

    static function addLinksToAccreditationTraining($idAccreditation, ...$idTrainings)
    {

    }

    static function removeLinksToAccreditationsTraining($idAccreditation, ...$idTrainings)
    {

    }
}