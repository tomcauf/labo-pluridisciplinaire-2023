<?php
require_once "DbConnect.inc.php";

class DbParticipateRequests
{
    static function addNewParticipation($idUser, $idTraining, $status)
    {
        if ($status != "ON HOLD" || $status != "IN PROGRESS")
            return "The status isn't correct for such an action";

        try {

            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->prepare("INSERT INTO Participate(id_user, id_training, status)
                                            VALUES (:idUser, :idTraining, :status)");
            $query->bindValue(":idUser", $idUser);
            $query->bindValue(":idTraining", $idTraining);
            $query->bindValue(":status", $status);
            $query->execute();
        } catch(PDOException $e) {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function getParticipation()
    {

    }

    static function getAllParticipation()
    {

        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->query("SELECT * FROM Participate");
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return (isset($results)) ? $results : "Something went wrong with the request";
        }
    }
}
