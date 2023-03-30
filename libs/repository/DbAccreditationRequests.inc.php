<?php
require_once "DbConnect.inc.php";

//TODO
class DbAccreditationRequests
{
    static function addNewAccreditation($name)
    {
        if(!isset($name) || $name == ""){
            return "Le nom d'une accréditation ne peut être vide.";
        }
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("INSERT INTO Accreditation(name)
                                            VALUES(:name)");
            $query->bindValue(":name", $name);
        } catch(PDOException $exception){
            return $exception->getMessage();
        } finally {
            DbConnect::disconnect($errorMessage);
        }
    }

    static function removeAccreditation($idAccreditation)
    {
        if(!isset($idAccreditation)){
            return "L'id d'accréditation ne peut être null.";
        }
        try{
            $link = DbConnect::connect2db($errorMessage);
            //TODO: Terminer
            $query = $link->prepare("DELETE");

        } catch(PDOException $exception){

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