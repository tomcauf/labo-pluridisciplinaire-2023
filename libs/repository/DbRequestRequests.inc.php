<?php
require_once "DbConnect.inc.php";

class DbRequestRequests
{
    static function storeNewRequest($validationType, $idValidator, $validationDate)
    {
        if ($validationType != "ACCESSED" || $validationType != "VALIDATED")
            return "The validation type isn't correct for such an action";
        try {

            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->prepare("INSERT INTO Request(validation_type, id_validator, validation_date)
                                            VALUES (:validationType, :idValidator, :validationDate)");
            $query->bindValue(":validationType", $validationType);
            $query->bindValue(":idValidator", $idValidator);
            $query->bindValue("validationDate", $validationDate);
            $query->execute();
        } catch(PDOException $e) {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function getRequest($idRequest)
    {
        try {

            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->prepare("SELECT * FROM Request WHERE id_request = :idRequest");
            $query->bindValue(":idRequest", $idRequest);
            $query->execute();
            $results = $query->fetch();
        } catch(PDOException $e) {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return $results;
        }
    }

    static function getAllRequests()
    {
        try {

            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->query("SELECT * FROM Request");
            $results = $query->fetchAll();
        } catch(PDOException $e) {
            echo $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return $results;
        }
    }
}