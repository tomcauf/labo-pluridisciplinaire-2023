<?php

namespace models;

class User
{
    private $id;
    private $name;
    private $firstName;
    private $email;
    private $idManager;

    /**
     * User constructor.
     * @param $id int id of the user
     * @param $name string name of the user
     * @param $firstName string firstname of the user
     * @param $email string email of the user
     * @param $idManager int Manager of the user (nullable)
     */
    public function __construct($id, $name, $firstName, $email, $idManager)
    {
        $this->id = $id;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->idManager = $idManager;
    }




}