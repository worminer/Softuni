<?php

namespace asd;

class Car {

    private $speed;
    private $minutesPerKm;
    private $fuel;
    private $fuelEconomy; //L/100km
    private $fuelPerKm;  // L/1km
    private $distanceTraveled = 0;
    private $timeTraveled = 0;

    /**
     * Car constructor.
     * @param int $speed
     * @param float $fuel
     * @param float $fuelEconomy
     */
    public function __construct(int $speed,float $fuel,float $fuelEconomy)
    {
        $this->speed = $speed;
        $this->fuel = $fuel;
        $this->fuelEconomy = $fuelEconomy;
        $this->minutesPerKm = 60 / $this->speed;
        $this->fuelPerKm = $this->fuelEconomy / 100;
    }


    public function setCarCommand(array $command){
        $cmd = array_shift($command);

        switch ($cmd) {
            case "Travel":
                $this->travel(floatval($command[0]));
                break;
            case "Refuel":
                $this->refuel(floatval($command[0]));
                break;
            case "Distance":
                $this->printDistance();
                break;
            case "Time":
                $this->printTime();
                break;
            case "Fuel":
                $this->printFuel();
                break;
            default:
                break;
        }
        return true;
    }

    private function printDistance()
    {
        $distance = $this->formatFloat($this->getDistance());
        $this->writeLine("Total Distance: {$distance}");
    }
    private function printTime()
    {
        $time = $this->getTimeTraveled();
        $this->writeLine("Total Time: {$time['hours']} hours and {$time['minutes']} minutes");
    }
    private function printFuel()
    {
        $fuel = $this->formatFloat($this->getFuel());
        $this->writeLine("Fuel left: {$fuel} liters");
    }

    private function formatFloat(float $float): string
    {
        return number_format(round($float, 1), 1);
    }
    private function writeLine($content)
    {
        echo $content . PHP_EOL;
    }

    public function getDistance(): float
    {
        return $this->distanceTraveled;
    }

    public function travel(float $distance){

        $requiredFuel = $this->fuelPerKm * $distance;

        if ($requiredFuel <= $this->getFuel()) {
            $this->fuel -= $requiredFuel;
            $this->distanceTraveled += $distance;
            $this->timeTraveled += $distance * $this->minutesPerKm;
        } else {
            $possibleDistance = $this->fuel / $this->fuelPerKm;
            $this->distanceTraveled += $possibleDistance;
            $this->fuel = 0;
            $this->timeTraveled += $possibleDistance* $this->minutesPerKm;
        }
    }



    public function refuel(float $liters){
        $this->fuel += $liters;
    }

    /**
     * @return mixed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @return mixed
     */
    public function getFuel()
    {
        return number_format(round($this->fuel, 1), 1);
    }

    /**
     * @return mixed
     */
    public function getFuelEconomy()
    {
        return $this->fuelEconomy;
    }

    /**
     * @return mixed
     */
    public function getDistanceTraveled()
    {

        return number_format(round($this->distanceTraveled, 1), 1);
    }

    /**
     * @return array
     */
    public function getTimeTraveled(): array
    {
        return [
            "hours" => floor($this->timeTraveled / 60),
            "minutes" => floor($this->timeTraveled % 60)
        ];
    }
}

$carInfo = explode(" ", trim(fgets(STDIN)));
$car = new Car($carInfo[0],floatval($carInfo[1]),floatval($carInfo[2]));

while (true){
    $command = explode(" ", trim(fgets(STDIN)));
    if ($command[0] == "END") {
        break;
    }

    $car->setCarCommand($command);
}
