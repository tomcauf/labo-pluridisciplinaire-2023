<?php

namespace models;

class Training
{
    private $name;
    private $trainers;
    private $functions;
    private $time;
    private $validityDuration;

    public function __construct($name, $trainers, $functions, $time, $validityDuration)
    {
        $this->name = $name;
        $this->trainers = ($trainers == null) ? array() : $trainers;
        $this->functions = ($functions == null) ? "Everyone" : $functions;
        $this->time = $time;
        $this->validityDuration = $validityDuration;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array|mixed
     */
    public function getTrainers()
    {
        return $this->trainers;
    }

    /**
     * @return mixed|string
     */
    public function getFunctions()
    {
        return $this->functions;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return mixed
     */
    public function getValidityDuration()
    {
        return $this->validityDuration;
    }


}