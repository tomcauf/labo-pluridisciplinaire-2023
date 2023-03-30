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

    private $roles;

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
        //todo check the type of the parameters and throw an exception if it's not the good type
        $this->id = $id;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->idManager = $idManager;
        $this->isActive = $isActive;
        $this->roles = array();
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
     * add a role to the user
     * @param $role Role role to add
     */
    public function addRole($role){
        $this->roles->add($role);
    }
    public function removeRole($role){
        $this->roles->remove($role);
    }


    /**
     * for the debug and the log
     * @return string representation of the object
     */
    public function __toString()
    {
        return "{" .
            "id:" . $this->id .
            ", name:'" . $this->name . '\'' .
            ", firstName:'" . $this->firstName . '\'' .
            ", email:'" . $this->email . '\'' .
            ", idManager:" . $this->idManager .
            ", isActive:" . $this->isActive .
            '}';
    }
}