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
     * @param int $id int id of the user
     * @param $name string name of the user
     * @param $firstName string firstname of the user
     * @param $email string email of the user
     * @param $isActive
     * @param $idManager int Manager of the user (nullable)
     */
    public function __construct($id, $name, $firstName, $email, $isActive, $idManager)
    {
        $this->id = $id;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->idManager = $idManager;
        $this->isActive = $isActive;
    }

    /**
     * magic method to get the value of a private property
     * @param $name string name of the property
     * @return null return null if the property doesn't exist
     */
    public function __get($name)
    {
        if(property_exists($this, $name)){
            return $this->$name;
        }else{
            return null;
        }
    }


    /**
     * @return int id of the user
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string name of the user
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string firstname of the user
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string email of the user
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int Manager of the user (nullable)
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
            ", isActive=" . $this->isActive .
            '}';
    }
}