<?php
require_once 'BdConnect.inc.php';

class BdUserRequest
{

    /**
     * request to get all users on the database
     * @return array of all users
     */
    static function getAllUser()
    {
        $link = BdConnect::connect2db($base, $message);
        $sql = "SELECT * FROM Utilisateur";
        $result = $link->query($sql);
        $users = $result->fetchAll(PDO::FETCH_ASSOC);
        BdConnect::disconnect($link);
        return $users;
    }

    static function createUser()
    {
        $link = BdConnect::connect2db();
        
        BdConnect::disconnect($link);
    }

}
>