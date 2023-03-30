<?php
require_once "DbConnect.inc.php";

class DbParticipateRequests
{
    static function addNewParticipation($idUser, $idTraining, $status)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->prepare("INSERT INTO Participate(id_user, id_training, status)
                                            VALUES (:idUser, :idTraining, 'ON HOLD')");
            $query->bindValue(":idUser", $idUser);
            $query->bindValue(":idTraining", $idTraining);
            $query->execute();
        } catch(PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    //TODO
    static function addNewParticipation($idUser, $idTraining, $idValidator)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->prepare("INSERT INTO Participate(id_user, id_training, status)
                                            VALUES (:idUser, :idTraining, 'IN PROGRESS')");
            $query->bindValue(":idUser", $idUser);
            $query->bindValue(":idTraining", $idTraining);
            $query->execute();
            $id = self::getLastId();
            $error = DbRequestRequests::storeNewRequest($id, "ACCESSED", $idValidator, date());
            if (isset($error)) throw new PDOException($error);
            $query->execute();
        } catch(PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    private static function getLastId()
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->query("SELECT id_participation FROM Participate ORDER BY id_participation DESC");
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    /**
     * @param $idParticipation id of the concerned participation
     * @return mixed|string an array of the data of the participation
     *                      or an error string
     */
    static function getParticipation($idParticipation)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->prepare("SELECT * FROM Participate WHERE id_participation = :idParticipation");
            $query->bindValue(":idParticipation", $idParticipation);
            $query->execute();
            $results = $query->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return (isset($results)) ? $results : "Something went wrong with the request";
        }
    }

    /**
     * @return array|false|string an array with the data of all participations
     *                             or false if there is a problem with the fetchAll
     *                              or an error string
     */
    static function getAllParticipations()
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->query("SELECT * FROM Participate");
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return (isset($results)) ? $results : "Something went wrong with the request";
        }
    }

    //TODO date
    static function confirmParticipation($idParticipation, $idValidator)
    {

        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->prepare("UPDATE Participate SET status = 'IN PROGRESS' 
                                            WHERE id_participation = :idParticipation");
            $query->bindValue(":idParticipation", $idParticipation);
            $error = DbRequestRequests::storeNewRequest($idParticipation, "ACCESSED", $idValidator, date());
            if (isset($error)) throw new PDOException($error);
            $query->execute();
        } catch(PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }
    
    static function validateParticipation($idParticipation, $idValidator)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->prepare("UPDATE Participate SET status = 'VALIDATED' 
                                            WHERE id_participation = :idParticipation");
            $query->bindValue(":idParticipation", $idParticipation);
            $error = DbRequestRequests::storeNewRequest($idParticipation, "VALIDATED", $idValidator, self::createNewDate());
            if (isset($error)) throw new PDOException($error);
            $query->execute();
        } catch(PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    /**
     * @param $idParticipation integer of the concerned participation
     * @param $fileLink string containing the file path of the certification
     * @param $status must be equal to "DONE", status of the training course for the user
     * @return string|void  an error message
     *                      or nothing if everything is good
     */
    static function addFileLink($idParticipation, $fileLink, $status)
    {
        if ($status != "DONE")
            return "No such action possible for this current status";

        try {
            $link = DbConnect::connect2db($errorMessage);
            if ($link == null) {
                return $errorMessage;
            }

            $query = $link->prepare("UPDATE Participate SET file_link = :fileLink, status = 'SENT' 
                                            WHERE id_participation = :idParticipation");
            $query->bindValue(":fileLink", $fileLink);
            $query->bindValue(":idParticipation", $idParticipation);
            $query->execute();
        } catch(PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    /**
     * Function that create a new date with the correct format to inject in the database
     * @param $dateTime TimeStamp of the date by Unix standard (mktime()) or null if now
     * @return string of the date with the format YYYY-mm-dd, the one stored by default by mySQL
     * Example of string : 2000-08-11
     */
    static function createNewDate($dateTime){
        $dateTime = $dateTime != null ? $dateTime : mktime();
        return date("YYYY-mm-dd", $dateTime);
    }
}
