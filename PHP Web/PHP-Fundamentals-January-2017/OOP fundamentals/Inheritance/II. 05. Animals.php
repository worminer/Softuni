<?php

namespace Animals ;

class App
{
    const END = "Beast!";
    const DELIMITER = " ";

    /**
     * @var $animals Animal[]
     */
    private $animals = [];

    public function start()
    {
        $this->processInput();
        $this->printOutput();
    }

    private function processInput()
    {
        while (true) {
            $input = explode(self::DELIMITER, $this->readLine());
            if ($input[0] === self::END) {
                break;
            }

            try {
                $animalData = explode(self::DELIMITER, $this->readLine());
                switch ($input[0]) {
                    case "Cat":
                        $this->animals[] = new Cat($animalData[0], intval($animalData[1]), $animalData[2]);
                        break;
                    case "Dog":
                        $this->animals[] = new Dog($animalData[0], intval($animalData[1]), $animalData[2]);
                        break;
                    case "Frog":
                        $this->animals[] = new Frog($animalData[0], intval($animalData[1]), $animalData[2]);
                        break;
                    case "Kitten":
                        if (strtolower($animalData[2]) == "male") {
                            throw new \Exception("Invalid input!");
                        }

                        $this->animals[] = new Kitten($animalData[0], intval($animalData[1]), $animalData[2]);
                        break;
                    case "Tomcat":
                        if (strtolower($animalData[2]) == "female") {
                            throw new \Exception("Invalid input!");
                        }

                        $this->animals[] = new Tomcat($animalData[0], intval($animalData[1]), $animalData[2]);
                        break;
                    default:
                        throw new \Exception("Invalid input!");
                }

            } catch (\Exception $ex) {
                $this->writeLine($ex->getMessage());
                exit;
            }
        }
    }

    private function printOutput()
    {
        foreach ($this->animals as $animal) {
            $this->writeLine($animal);
        }
    }

    private function readLine(): string
    {
        return trim(fgets(STDIN));
    }

    /**
     * @param $content mixed
     * @return void
     */
    private function writeLine($content)
    {
        echo $content . PHP_EOL;
    }
}







abstract class Animal implements SoundProducible
{
    const INVALID_INPUT_MSG = "Invalid input!";

    private $name;
    private $age;
    private $gender;

    public function __construct(string $name, int $age, string $gender)
    {
        $this->setName($name);
        $this->setAge($age);
        $this->setGender($gender);
    }

    public function setName(string $name)
    {
        if (empty(trim($name))) {
            throw new \Exception(self::INVALID_INPUT_MSG);
        }

        $this->name = $name;
    }

    public function setAge(int $age)
    {
        if ($age <= 0) {
            throw new \Exception(self::INVALID_INPUT_MSG);
        }

        $this->age = $age;
    }

    public function setGender(string $gender)
    {
        if (empty(trim($gender))) {
            throw new \Exception(self::INVALID_INPUT_MSG);
        }

        $this->gender = $gender;
    }

    public function __toString()
    {
        $output = (new \ReflectionClass($this))->getShortName()
            . " {$this->name} {$this->age} {$this->gender}" . PHP_EOL
            . $this->produceSound();

        return $output;
    }
}







class Cat extends Animal
{
    const SOUND = "MiauMiau";

    public function produceSound()
    {
        return self::SOUND;
    }
}







interface SoundProducible
{
    public function produceSound();
}







class Dog extends Animal
{
    const SOUND = "BauBau";

    public function produceSound()
    {
        return self::SOUND;
    }
}







class Frog extends Animal
{
    const SOUND = "Frogggg";

    public function produceSound()
    {
        return self::SOUND;
    }
}







class Kitten extends Cat
{
    const SOUND = "Miau";
    const GENDER = "Female";

    public function __construct(string $name, int $age)
    {
        parent::__construct($name, $age, self::GENDER);
    }

    public function produceSound()
    {
        return self::SOUND;
    }
}







class Tomcat extends Cat
{
    const SOUND = "Give me one million b***h";
    const GENDER = "Male";

    public function __construct(string $name, int $age)
    {
        parent::__construct($name, $age, self::GENDER);
    }

    public function produceSound()
    {
        return self::SOUND;
    }
}






$radio = new App();
$radio->start();

