<?php

namespace rowdata;
class Car
{

    /**
     * @var
     */
    private $model;
    /**
     * @var Engine
     */
    private $engine;
    /**
     * @var Cargo
     */
    private $cargo;
    /**
     * @var array|Tire
     */
    private $tires = [];

    /**
     * Car constructor.
     * @param string $carData
     */
    public function __construct(string $carData)
    {
        $carData = explode(" ", trim($carData));
        $this->model = $carData [0];
        $this->engine = new Engine(intval($carData[1]),intval($carData[2]));
        $this->cargo = new Cargo(intval($carData[3]),$carData[4]);
        $this->tires[] = new Tire(floatval($carData[5]),floatval($carData[6]));
        $this->tires[] = new Tire(floatval($carData[7]),floatval($carData[8]));
        $this->tires[] = new Tire(floatval($carData[9]),floatval($carData[10]));
        $this->tires[] = new Tire(floatval($carData[11]),floatval($carData[12]));
    }

    public function isFlammableCargo():bool {
        return $this->cargo->getType() == "flamable";
    }

    public function isFragileCargo():bool {
        return $this->cargo->getType() == "fragile";
    }

    public function isTirePressureLow():bool {

        foreach ($this->tires as $tire){
            if ($tire->getPressure() < 1) {
                return true;
            }
        }
        return false;
    }

    public function isEnginePowerful():bool {
        // is engine more then 250
        return $this->engine->getPower() > 250;

    }

    public function __toString():string
    {
        return $this->model;
    }

}

class Engine
{
    private $speed;
    private $power;

    /**
     * Engine constructor.
     * @param int $speed
     * @param int $power
     */
    public function __construct(int $speed, int $power)
    {
        $this->speed = $speed;
        $this->power = $power;
    }

    /**
     * @return int
     */
    public function getPower(): int
    {
        return $this->power;
    }
}

class Tire
{
    private $pressure;
    private $age;

    /**
     * Tire constructor.
     * @param $pressure
     * @param int $age
     */
    public function __construct(float $pressure, int $age)
    {
        $this->pressure = $pressure;
        $this->age = $age;
    }

    /**
     * @return float
     */
    public function getPressure(): float
    {
        return round($this->pressure,14);
    }
}

class Cargo
{
    private $weight;
    private $type;

    /**
     * Cargo constructor.
     * @param int $weight
     * @param $type
     */
    public function __construct(int $weight, string $type)
    {
        $this->weight = $weight;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }


}

$numOfCars = intval(fgets(STDIN));
$cars = [];
for ($i = 0; $i < $numOfCars; ++$i) {
    $carData = trim(fgets(STDIN));
    $cars[] = new Car($carData);
}

$command = trim(fgets(STDIN));

if ($command == "fragile") {

    foreach ($cars as $car){
        if ($car->isFragileCargo() && $car->isTirePressureLow()) {

           echo $car."\n";
        }
    }
}else if ($command == "flamable") {

    // flamable is flammable
    foreach ($cars as $car){
        if ($car->isFlammableCargo() && $car->isEnginePowerful()) {
            echo $car."\n";
        }
    }
}
