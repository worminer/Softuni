<?php

namespace FoodShortage ;

interface BirthDayInterface
{
    public function getBirthDay(): string;
}




interface BuyerInterface
{
    public function BuyFood();

    public function getFood(): int;

    public function setFood(int $foodQuantity);
}




class Citizen implements IdentifiableInterface, NameInterface, BirthDayInterface, BuyerInterface
{
    private $name;
    private $age;
    private $id;
    private $birthDate;
    private $food = 0;

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

    public function BuyFood()
    {
        $this->setFood($this->getFood() + 10);
    }

    public function getFood(): int
    {
        return $this->food;
    }

    public function setFood(int $value)
    {
        $this->food = $value;
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




class Rebel implements NameInterface, BuyerInterface
{
    private $name;
    private $age;
    private $group;
    private $food = 0;

    public function __construct(string $name, int $age, string $group)
    {
        $this->name = $name;
        $this->age = $age;
        $this->group = $group;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function BuyFood()
    {
        $this->setFood($this->getFood() + 5);
    }

    public function getFood(): int
    {
        return $this->food;
    }

    public function setFood(int $value)
    {
        $this->food = $value;
    }
}



$people = [];

$numOfPeople = intval(readLine());
while ($numOfPeople) {
    $numOfPeople--;
    $tokens = explode(" ", readLine());
    if (count($tokens) === 4) {
        $people[$tokens[0]] = new Citizen($tokens[0], intval($tokens[1]), $tokens[2], $tokens[3]);
        continue;
    }

    if (count($tokens) === 3) {
        $people[$tokens[0]] = new Rebel($tokens[0], intval($tokens[1]), $tokens[2]);
    }
}

while (true) {
    $name = readLine();
    if ($name == "End") {
        break;
    }

    if (!array_key_exists($name, $people)) {
        continue;
    }

    $person = $people[$name];
    $person->BuyFood();
}

$totalFood = 0;
foreach ($people as $person) {
    $totalFood += $person->getFood();
}

writeLine($totalFood);

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

