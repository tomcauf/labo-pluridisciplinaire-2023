<?php
require_once "DbConnect.inc.php";

class DbOperateRequests
{
    //TODO faire des joins pour avoir les noms directements ? Et donc les mettre dans les plus grosses class ?
    static function getFunctionLinks($idFunction)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT id_training FROM Operate WHERE id_function = :idFunction");
            $query->bindValue(":idFunction", $idFunction);
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

    static function addLinksToFunction($idFunction, ...$idTrainings)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);

            foreach($idTrainings as $idTraining) {
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
}