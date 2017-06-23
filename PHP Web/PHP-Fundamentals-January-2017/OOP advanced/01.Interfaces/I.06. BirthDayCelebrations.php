<?php

namespace BirthDayCelebrations ;

interface BirthDayInterface
{
    public function getBirthDay(): string;
}




class Citizen implements IdentifiableInterface, NameInterface, BirthDayInterface
{
    private $name;
    private $age;
    private $id;
    private $birthDate;

    public function __construct(string $name, int $age, string $id, string $birthDay)
    {
        $this->name = $name;
        $this->age = $age;
        $this->id = $id;
        $this->birthDate = $birthDay;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBirthDay(): string
    {
        return $this->birthDate;
    }
}





interface IdentifiableInterface
{
    public function getId(): string;
}




interface NameInterface
{
    public function getName(): string;
}




class Pet implements NameInterface, BirthDayInterface
{
    private $name;
    private $birthDate;

    public function __construct(string $name, string $birthDate)
    {
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    public function getBirthDay(): string
    {
        return $this->birthDate;
    }

    public function getName(): string
    {
        return $this->name;
    }
}





class Robot implements IdentifiableInterface
{
    private $id;
    private $model;

    public function __construct(string $model, string $id)
    {
        $this->model = $model;
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}



$entries = [];

while (true) {
    $tokens = explode(" ", readLine());
    if ($tokens[0] === "End") {
        break;
    }

    $type = array_shift($tokens);
    if ($type === "Pet") {
        $entries[] = new Pet(...$tokens);
        continue;
    }

    if ($type === "Citizen") {
        $entries[] = new Citizen($tokens[0], intval($tokens[1]), $tokens[2], $tokens[3]);
    }
}

$dateNeedle = readLine();

foreach ($entries as $entry) {
    if (preg_match("/" . $dateNeedle . "$/", $entry->getBirthDay())) {
        writeLine($entry->getBirthDay());
    }
}

function readLine(): string
{
    return trim(fgets(STDIN));
}

/**
 * @param $content mixed
 * @return void
 */
function writeLine($content)
{
    echo $content . PHP_EOL;
}

