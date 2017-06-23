<?php

/**
 * Class Car
 */
namespace racing;
class Car {
    private $model;
    private $fuelAmount;
    private $fuelCostPerKm;
    private $distanceTraveled = 0.00;
    /**
     * Car constructor.
     * @param string $model
     * @param float $fuelAmount
     * @param float $fuelCostPerKm
     */
    public function __construct(string $model, float $fuelAmount, float $fuelCostPerKm)
    {
        $this->model = $model;
        $this->fuelAmount = $fuelAmount;
        $this->fuelCostPerKm =  $fuelCostPerKm;
    }


    public function drive(float $distance){

        $fuelNeeded = $this->fuelCostPerKm * $distance;
        if (round($fuelNeeded,14) > round($this->fuelAmount)) {
            throw new \Exception("Insufficient fuel for the drive\n" );
        }

        $this->fuelAmount -= $fuelNeeded;
        $this->fuelAmount = abs($this->fuelAmount);
        $this->distanceTraveled += $distance;
    }

    public function __toString()
    {
        return $this->model . " " . number_format($this->fuelAmount, 2) . " " . $this->distanceTraveled;
    }
}

$numOfCars = intval(fgets(STDIN));
$carsArr = [];

while ($numOfCars--){
    $carInfoArr = explode(" ", trim(fgets(STDIN)));
    $carsArr[$carInfoArr[0]] = new Car($carInfoArr[0], floatval($carInfoArr[1]), floatval($carInfoArr[2]));
}


while (true){
    try{

        $command = explode(" ", trim(fgets(STDIN)));
        if ($command[0] == "End") {
            break;
        } else if ($command[0] == "Drive") {
            $currentCar = $carsArr[$command[1]];
            $currentCar->drive($command[2]);
        }

    }catch (Exception $e){
        echo $e->getMessage();
    }
}

foreach ($carsArr as $car) {
    echo $car."\n";
}