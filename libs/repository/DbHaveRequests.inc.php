<?php
require_once "DbConnect.inc.php";

class DbHaveRequests
{
    static function getUserLinks($idUser)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT id_function FROM Have WHERE id_user = :idUser");
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

    static function getFunctionLinks($idFunction)
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

    //TODO possible de tout execute ?
    static function addLinksToFunction($idFunction, ...$idUsers)
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

    static function addLinksToUser($idUser, ...$idFunctions)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);

            foreach($idFunctions as $idFunction) {
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
}