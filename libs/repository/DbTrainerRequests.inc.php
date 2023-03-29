<?php
require_once "DbConnect.inc.php";

class DbTrainerRequests
{
    static function getUserLinks($idUser)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT id_training FROM Training WHERE id_user = :idUser");
            $query->bindValue(":idUser", $idUser);
            $query->execute();
            $results = $query->fetchAll();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return $results;
        }
    }

    static function getTrainingLinks($idTraining)
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

    static function addLinksToUser($idUser, ...$idTrainings)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);

            foreach($idTrainings as $idTraining) {
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

    static function addLinksToTraining($idTraining, ...$idUsers)
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