<?php

namespace models;

class Training
{
    private $name;
    private $trainers;
    private $functions;
    private $participants;
    private $duration;
    private $validityDuration;
    private $requiredTraining;
    private $deadline;
    private $certificateDeadline;
    private $location;

    //TODO faire une autre classe pour alléger les attributs ? "Infos", "time" and "members" infos ?

    public function __construct($name, $trainers, $functions, $participants, $duration, $validityDuration, $requiredTraining, $deadline, $certificateDeadline, $location)
    {
        $this->name = $name;
        $this->trainers = ($trainers == null) ? array() : $trainers;
        $this->functions = ($functions == null) ? "Everyone" : $functions;
        $this->participants = ($participants == null) ? array() : $participants;
        $this->duration = $duration;
        $this->validityDuration = $validityDuration;
        $this->requiredTraining = $requiredTraining;
        $this->deadline = $deadline;
        $this->certificateDeadline = $certificateDeadline;
        $this->location = $location;
    }

    /**
     *  magic method to get the value of a private property
     *
     * @param $name string name of the property
     * @return null return null if the property doesn't exist
     */
    public function __get($name)
    {
        if (property_exists($this, $name))
            return $this->$name;
        else
            return null;

    }

    /**
     * for the debug and the log
     *
     * @return string representation of the object
     */
    public function __toString()
    {
        return "{" .
            "name:'" . $this->name . '\'' .
            ", trainers:" . $this->trainers .
            ", functions:'" . $this->functions . '\'' .
            ", time:" . $this->time .
            ", validityDuration:" . $this->validityDuration .
            "}";
    }


}