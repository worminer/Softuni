<?php
namespace printppl;
class Person {
    private $name;
    private $age;
    private $occupation;

    /**
     * Person constructor.
     * @param string $name
     * @param int $age
     * @param string $occupation
     */
    public function __construct(string $name, int $age, string $occupation)
    {
        $this->name = $name;
        $this->age = $age;
        $this->occupation = $occupation;
    }

    public function __toString()
    {
        return "{$this->name} - age: {$this->age}, occupation: {$this->occupation}".PHP_EOL;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }




}
$people = [];

while (true){
    $cmd = explode(" ", trim(fgets(STDIN)));

    if ($cmd[0] == "END") {
        break;
    }
    $people[] = new Person($cmd[0], intval($cmd[1]), $cmd[2]);
}

usort($people, function ($person1, $person2){
   return $person1->getAge() <=> $person2->getAge();
});

foreach ($people as $person) {
    echo $person;
}