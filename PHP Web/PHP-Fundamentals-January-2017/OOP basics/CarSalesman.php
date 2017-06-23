<?php
namespace carsale;
/**
 * Class Car
 * @package carsale
 */
class Car {
    /**
     * @var string
     */
    private $model;
    /**
     * @var Engine
     */
    private $engine;
    /**
     * @var int
     */
    private $weight;
    /**
     * @var string
     */
    private $color;


    /**
     * Car constructor.
     * @param string $model
     * @param Engine $engine
     * @param int $weight
     * @param string $color
     */
    public function __construct(string $model, Engine $engine, int $weight, string $color)
    {
        $this->model = $model;
        $this->engine = $engine;
        $this->weight = $weight;
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return int
     */
    public function getWeight(): string 
    {
        if ($this->weight == -1) {
            return "n/a";
        }
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }



    public function __toString():string
    {
        $carDisplayInfo = "{$this->getModel()}:
  {$this->engine->getModel()}:
    Power: {$this->engine->getPower()}
    Displacement: {$this->engine->getDisplacement()}
    Efficiency: {$this->engine->getEfficiency()}
  Weight: {$this->getWeight()}
  Color: {$this->getColor()}
";

        return $carDisplayInfo;
    }

}

/**
 * Class Engine
 * @package carsale
 */
class Engine {
    /**
     * @var string
     */
    private $model;
    /**
     * @var int
     */
    private $power;
    /**
     * @var int
     */
    private $displacement;

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return int
     */
    public function getPower(): int
    {
        return $this->power;
    }

    /**
     * @return string
     */
    public function getDisplacement(): string
    {
        if ($this->displacement == -1) {
            return "n/a";
        }
        return $this->displacement;
    }

    /**
     * @return string
     */
    public function getEfficiency(): string
    {
        return $this->efficiency;
    }
    /**
     * @var string
     */
    private $efficiency;


    /**
     * Engine constructor.
     * @param string $model
     * @param int $power
     * @param int $displacement
     * @param string $efficiency
     */
    public function __construct(string $model, int $power, int $displacement = -1, string $efficiency = "n/a")
    {
        $this->model = $model;
        $this->power = $power;
        $this->displacement = $displacement;
        $this->efficiency = $efficiency;
    }

}

$enginesArr = [];
$carsArr    = [];

$enginesNum = trim(fgets(STDIN));
while ($enginesNum--){
    $engineStats = explode(" ", trim(fgets(STDIN)));

    if (isset($engineStats[2]) && isset($engineStats[3])) {
        $displacement   = $engineStats[2];
        $efficiency     = $engineStats[3];
    } else if (isset($engineStats[2]) && !isset($engineStats[3])) {
        if (is_numeric($engineStats[2])) {
            $displacement   = $engineStats[2];
            $efficiency     = "n/a";
        } else {
            $displacement   = -1;
            $efficiency     = $engineStats[2];
        }
    } else {
        $displacement   = -1;
        $efficiency     = "n/a";
    }
    
    $enginesArr[$engineStats[0]] = new Engine($engineStats[0], intval($engineStats[1]), $displacement, $efficiency );
}

$carsNum = trim(fgets(STDIN));

while ($carsNum--){
    $carsStats = explode(" ", trim(fgets(STDIN)));

    if (isset($carsStats[2]) && isset($carsStats[3])) {
        $weight  = $carsStats[2];
        $color     = $carsStats[3];
    } else if (isset($carsStats[2]) && !isset($carsStats[3])) {
        if (is_numeric($carsStats[2])) {
            $weight   = $carsStats[2];
            $color     = "n/a";
        } else {
            $weight   = -1;
            $color     = $carsStats[2];
        }
    } else {
        $weight   = -1;
        $color     = "n/a";
    }

    $carsArr[] = new Car($carsStats[0] , $enginesArr[$carsStats[1]], $weight , $color);
}

foreach ($carsArr as $car) {
    echo $car;
}