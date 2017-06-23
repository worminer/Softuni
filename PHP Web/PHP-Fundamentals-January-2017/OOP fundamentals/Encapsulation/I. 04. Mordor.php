<?php

$mood = new Mood();
$wizard = new Wizard($mood);

$radio = new App($wizard);
$radio->start();

class App
{
    private $wizard;

    public function __construct(Wizard $wizard)
    {
        $this->wizard = $wizard;
    }

    public function start()
    {
        $this->processInput();
        $this->printOutput();
    }

    private function processInput()
    {
        $foods = explode(",", $this->readLine());
        foreach ($foods as $food) {
            $food = FoodFactory::create($food);
            $this->wizard->eat($food);
        }
    }

    private function printOutput()
    {
        $this->writeLine($this->wizard->getMood()->getPoints());
        $this->writeLine($this->wizard->getMood()->getStatus());
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


class Wizard
{
    /**
     * @var FoodBase[] $foodsEaten
     */
    private $foodsEaten = [];
    private $mood;

    /**
     * Wizard constructor.
     * @param $mood
     */
    public function __construct(Mood $mood)
    {
        $this->mood = $mood;
    }

    public function eat(FoodBase $food)
    {
        $this->mood->update($food->getPoints());
        $this->foodsEaten[] = $food;
    }

    public function getMood(): Mood
    {
        return $this->mood;
    }
}


class FoodFactory
{
    private function __construct()
    {
    }

    public static function create(string $name)
    {
        switch (strtolower($name)) {
            case "cram":
                return new Cram();
            case "lembas":
                return new Lembas();
            case "apple":
                return new Apple();
            case "melon":
                return new Melon();
            case "honeycake":
                return new HoneyCake();
            case "mushrooms":
                return new Mushrooms();
            default:
                return new RegularFood();
        }
    }
}

class Mood
{
    private $points = 0;

    public function getPoints(): int
    {
        return $this->points;
    }

    public function getStatus(): string
    {
        if (Validator::validateNumInRange($this->points, PHP_INT_MIN, -4)) {
            return "Angry";
        }

        if (Validator::validateNumInRange($this->points, -5, -1)) {
            return "Sad";
        }

        if (Validator::validateNumInRange($this->points, 0, 15)) {
            return "Happy";
        }

        return "PHP";
    }

    public function update(int $value)
    {
        $this->points += $value;
    }
}

abstract class FoodBase
{
    private $points;

    public function __construct(int $points)
    {
        $this->points = $points;
    }

    public function getPoints(): int
    {
        return $this->points;
    }
}
class Cram extends FoodBase
{
    const POINTS = 2;

    public function __construct()
    {
        parent::__construct(self::POINTS);
    }
}
class Apple extends FoodBase
{
    const POINTS = 1;

    public function __construct()
    {
        parent::__construct(self::POINTS);
    }
}

class Lembas extends FoodBase
{
    const POINTS = 3;

    public function __construct()
    {
        parent::__construct(self::POINTS);
    }
}
class HoneyCake extends FoodBase
{
    const POINTS = 5;

    public function __construct()
    {
        parent::__construct(self::POINTS);
    }
}
class RegularFood extends FoodBase
{
    const POINTS = -1;

    public function __construct()
    {
        parent::__construct(self::POINTS);
    }
}
class Mushrooms extends FoodBase
{
    const POINTS = -10;

    public function __construct()
    {
        parent::__construct(self::POINTS);
    }
}
class Melon extends FoodBase
{
    const POINTS = 1;

    public function __construct()
    {
        parent::__construct(self::POINTS);
    }
}
class Validator
{
    private function __construct()
    {
    }

    public static function validateNumInRange(int $num, int $min, int $max): bool
    {
        return $num >= $min && $num <= $max;
    }
}
