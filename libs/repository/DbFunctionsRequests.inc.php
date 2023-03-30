<?php
require_once "DbConnect.inc.php";
class DbFunctionsRequests
{
    static function addFunction($name)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("INSERT INTO Function(name) values(:name)");
            $query->bindValue(":name", $name);
            $query->execute();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function removeFunction($idFunction)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("DELETE FROM Function WHERE id_function = :idFunction");
            $query->bindValue(":idFunction", $idFunction);
            $query->execute();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    //TODO join pour + qu'ID
    static function getFunctionLinksUser($idFunction)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT id_user FROM Have WHERE id_function = :idFunction");
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

    static function addLinksToFunctionUser($idFunction, ...$idUsers)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);

            foreach($idUsers as $idUser) {
                $query = $link->prepare("INSERT INTO Have(id_user, id_function) VALUES (:idUser, :idFunction);");
                $query->bindValue(":idUser", $idUser);
                $query->bindValue(":idFunction", $idFunction);
                $query->execute();
            }
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function getFunctionLinksTraining($idFunction)
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

    static function addLinksToFunctionTraining($idFunction, ...$idTrainings)
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
}