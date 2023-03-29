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
     * @param $id int l'identifiant de l'utilisateur
     * @param $name string le nom de l'utilisateur
     * @param $firstName string le prenom de l'utilisateur
     * @param $email string l'email de l'utilisateur
     * @param $idManager int l'identifiant du manager de l'utilisateur (peut être null)
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