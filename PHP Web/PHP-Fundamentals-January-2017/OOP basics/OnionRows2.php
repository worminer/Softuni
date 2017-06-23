<?php

class Person
{
    private $name;
    private $age;

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


$rows = intval(fgets(STDIN));
$persons = [];
for ($i = 0; $i < $rows; ++$i) {
    $personArr = explode(" ", trim(fgets(STDIN)));
    $pName = $personArr[0];
    $pAge = intval($personArr[1]);
    if ($pAge > 30) {
        $persons[] = new Person($pName, $pAge);
    }

}

usort($persons, function (Person $a, Person $b){
    return strcmp($a->getName(), $b->getName());
});


foreach ($persons as $name => $person ) {
        echo $person.PHP_EOL;
}