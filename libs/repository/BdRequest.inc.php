<?php
require 'BdConnect.inc.php';
class BdRequest
{
    /**
     * request to get all users on the database
     * @return array of all users
     */
    static function getAllUser()
    {
        $link = BdConnect::connect2db('training', $message);
        $sql = "SELECT * FROM user";
        $result = $link->query($sql);
        $users = $result->fetchAll(PDO::FETCH_ASSOC);
        BdConnect::disconnect($link);
        return $users;
    }



}