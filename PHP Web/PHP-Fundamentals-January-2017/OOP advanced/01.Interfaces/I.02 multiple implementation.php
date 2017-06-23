<?php

namespace multiple ;


interface Birthable
{
    public function getBirthDate(): string;

    public function setBirthDate(string $birthDate);
}






interface Identifiable
{
    public function getId(): string;

    public function setId(string $id);
}





interface PersonInterface
{
    public function getName(): string;

    public function setName(string $name);

    public function getAge(): int;

    public function setAge(int $age);
}

class Citizen implements PersonInterface, Identifiable, Birthable
{
    private $name;
    private $age;
    private $id;
    private $birthDate;

    public function __construct(
        string $name,
        int $age,
        string $id,
        string $birthDate)
    {
        $this->setName($name);
        $this->setAge($age);
        $this->setId($id);
        $this->setBirthDate($birthDate);
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

    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    public function setBirthDate(string $birthDate)
    {
        $this->birthDate = $birthDate;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }
}

$name = trim(fgets(STDIN));
$age = intval(trim(fgets(STDIN)));
$id = trim(fgets(STDIN));
$birthDate = trim(fgets(STDIN));

$citizen = new Citizen($name, $age, $id, $birthDate);

echo $citizen->getName() . PHP_EOL;
echo $citizen->getAge() . PHP_EOL;
echo $citizen->getId() . PHP_EOL;
echo $citizen->getBirthDate();
