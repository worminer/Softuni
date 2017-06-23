<?php

namespace CatLady ;

class App
{
    /**
     * @var Cat[] $cats
     */
    private $cats = [];

    public function start()
    {
        $this->processInput();
        $this->printOutput($this->readLine());
    }

    private function processInput()
    {
        while (true) {
            $input = $this->readLine();
            if ($input === "End") {
                break;
            }

            $input = explode(" ", $input);
            switch ($input[0]) {
                case "Siamese":
                    $this->addCat(new Siamese($input[1], intval($input[2])));
                    break;
                case "Cymric":
                    $this->addCat(new Cymric($input[1], intval($input[2])));
                    break;
                case "StreetExtraordinaire":
                    $this->addCat(new StreetExtraordinaire($input[1], intval($input[2])));
                    break;
                default:
                    throw new \Exception("Unknown cat type supplied!");
            }
        }
    }

    private function printOutput($catName)
    {
        $this->writeLine($this->getCatByName($catName));
    }

    private function addCat(Cat $cat)
    {
        $this->cats[$cat->getName()] = $cat;
    }

    private function getCatByName(string $name): Cat
    {
        return $this->cats[$name];
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





abstract class Cat
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return (new \ReflectionClass($this))->getShortName() . " {$this->name}";
    }
}





class Cymric extends Cat
{
    private $furLength;

    public function __construct(string $name, int $furLength)
    {
        parent::__construct($name);

        $this->furLength = $furLength;
    }

    public function __toString()
    {
        return parent::__toString() . " {$this->furLength}";
    }
}





class Siamese extends Cat
{
    private $earSize;

    public function __construct(string $name, int $earSize)
    {
        parent::__construct($name);

        $this->earSize = $earSize;
    }

    public function __toString()
    {
        return parent::__toString() . " {$this->earSize}";
    }
}





class StreetExtraordinaire extends Cat
{
    private $decibelsOfMeows;

    public function __construct(string $name, int $decibelsOfMeows)
    {
        parent::__construct($name);

        $this->decibelsOfMeows = $decibelsOfMeows;
    }

    public function __toString()
    {
        return parent::__toString() . " {$this->decibelsOfMeows}";
    }
}




$radio = new App();
$radio->start();

