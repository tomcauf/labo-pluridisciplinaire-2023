<?php

namespace models;

/**
 * Class Role
 * it's the function of the user but funnction is a reserved word in php
 * @package models
 */
class Role
{
    private $id;
    private $name;

    /**
     * Role constructor.
     * @param $id int id of the role
     * @param $name string name of the role
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * magic method to get the value of a private property
     * @param $name string name of the property
     * @return null return null if the property doesn't exist
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return null;
        }
    }
}