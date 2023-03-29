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
}