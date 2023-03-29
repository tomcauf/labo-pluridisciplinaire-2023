<?php
require_once "BdConnect.inc.php";
require_once "libs/models/Training.php";

use models\Training;

class BdTrainingRequests
{

    static function createTrainingCourse()
    {
        $link = null;
        try {
           $link = BdConnect::connect2db($errorMessage);
           if ($link == null) {
               return $errorMessage;
           }
           $sql = "INSERT INTO training (name, description, duration, price, trainer) VALUES (:name, :description, :duration, :price, :trainer)";



        }catch (PDOException $e){
            echo $e->getMessage();
        } finally {
            BdConnect::disconnect($link);
        }
    }
}