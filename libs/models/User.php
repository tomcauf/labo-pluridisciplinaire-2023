<?php

namespace models;

class User
{
    private $id;
    private $name;
    private $firstName;
    private $email;
    private $idManager;
    private $isActive;

    /**
     * User constructor.
     * @param $id int id of the user
     * @param $name string name of the user
     * @param $firstName string firstname of the user
     * @param $email string email of the user
     * @param $idManager int Manager of the user (nullable)
     */
    public function __construct($id, $name, $firstName, $email, $idManager, $isActive)
    {
        $this->id = $id;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->idManager = $idManager;
        $this->isActive = $isActive;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getIdManager()
    {
        return $this->idManager;
    }

    //to string avec tout le attributs privés
    public function __toString()
    {
        return "User{" .
            "id=" . $this->id .
            ", name='" . $this->name . '\'' .
            ", firstName='" . $this->firstName . '\'' .
            ", email='" . $this->email . '\'' .
            ", idManager=" . $this->idManager .
            '}';
    }
}