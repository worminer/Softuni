<?php

namespace iperson ;


class Citizen implements PersonInterface
{
    private $name;
    private $age;

    public function __construct(string $name, int $age)
    {
        $this->setName($name);
        $this->setAge($age);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age)
    {
        $this->age = $age;
    }
}

interface PersonInterface
{
    public function getName(): string;

    public function setName(string $name);

    public function getAge(): int;

    public function setAge(int $age);
}

$name = trim(fgets(STDIN));
$age = intval(trim(fgets(STDIN)));

$citizen = new Citizen($name, $age);
echo $citizen->getName() . PHP_EOL;
echo $citizen->getAge();