<?php

namespace Vehicles ;


interface VehicleInterface
{
    public function drive(float $distance): string;

    public function refuel(float $amount);
}

function readLine(): string
{
    return trim(fgets(STDIN));
}

function writeLine($content)
{
    echo $content . PHP_EOL;
}

abstract class Vehicle implements VehicleInterface
{
    protected $fuel;
    protected $fuelConsumption;

    public function __construct(float $fuel, float $fuelConsumption)
    {
        $this->fuel = $fuel;
        $this->setFuelConsumption($fuelConsumption);
    }

    public function drive(float $distance): string
    {
        if ($distance * $this->fuelConsumption > $this->fuel)  {
            throw new \Exception("{$this->getClassName()} needs refueling");
        }

        $this->fuel -= $distance * $this->fuelConsumption;
        return "{$this->getClassName()} travelled {$distance} km";
    }

    protected abstract function setFuelConsumption(float $consumption);

    public function __toString()
    {
        return $this->getClassName() . ": " . number_format($this->fuel, 2, ".", "");
    }

    private function getClassName(): string
    {
        return basename(get_class($this));
    }
}


class Car extends Vehicle
{
    protected function setFuelConsumption(float $consumption)
    {
        $this->fuelConsumption = $consumption + 0.9;
    }

    public function refuel(float $amount)
    {
        $this->fuel += $amount;
    }
}




class Truck extends Vehicle
{
    protected function setFuelConsumption(float $consumption)
    {
        $this->fuelConsumption = $consumption + 1.6;
    }

    public function refuel(float $amount)
    {
        $this->fuel += ($amount * 0.95);
    }
}


$vehicles = [];

$tokens = explode(" ", readLine());
$vehicles["Car"] = new Car(floatval($tokens[1]), floatval($tokens[2]));

$tokens = explode(" ", readLine());
$vehicles["Truck"] = new Truck(floatval($tokens[1]), floatval($tokens[2]));

$linesCount = intval(readLine());
for ($i = 0; $i < $linesCount; $i++) {

    try {
        $command = explode(" ", readLine());
        if ($command[0] === "Drive") {
            writeLine($vehicles[$command[1]]->drive(floatval($command[2])));
            continue;
        }

        if ($command[0] === "Refuel") {
            $vehicles[$command[1]]->refuel(floatval($command[2]));
        }
    } catch (\Exception $e) {
        writeLine($e->getMessage());
    }
}

writeLine(implode(PHP_EOL, $vehicles));
