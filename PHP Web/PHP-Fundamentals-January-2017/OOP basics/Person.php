<?php

class Person
{
    public $name;
    public $age;

    function __construct(string $name , int $age)
    {
        $this->name = $name;
        $this->age = $age;
        //echo $this->name . " " . $this->age;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age)
    {
        $this->age = $age;
    }

    public function __toString()
    {
        return $this->name . " - " . $this->age;
    }
}
