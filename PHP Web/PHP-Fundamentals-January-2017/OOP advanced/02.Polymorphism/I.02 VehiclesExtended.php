<?php

namespace VehiclesExtended ;


interface VehicleInterface
{
    public function drive(float $distance): string;

    public function refuel(float $amount);
}


abstract class Vehicle implements VehicleInterface
{
    protected $fuel;
    protected $fuelConsumption;
    protected $tankCapacity;

    public function __construct(float $fuel, float $fuelConsumption, float $tankCapacity)
    {
        $this->setFuel($fuel);
        $this->setFuelConsumption($fuelConsumption);
        $this->tankCapacity = $tankCapacity;
    }

    public function drive(float $distance): string
    {
        if ($distance * $this->fuelConsumption > $this->fuel)  {
            throw new \Exception("{$this->getClassName()} needs refueling");
        }

        $this->fuel -= $distance * $this->fuelConsumption;
        return "{$this->getClassName()} travelled {$distance} km";
    }

    public function __toString()
    {
        return $this->getClassName() . ": " . number_format($this->fuel, 2, ".", "");
    }

    protected function setFuel(float $value) {
        if ($value < 0) {
            throw new \Exception("Fuel must be a positive number");
        }

        $this->fuel = $value;
    }

    protected abstract function setFuelConsumption(float $consumption);

    private function getClassName(): string
    {
        return basename(get_class($this));
    }
}


class Bus extends Vehicle
{
    protected function setFuelConsumption(float $consumption)
    {
        $this->fuelConsumption = $consumption;
    }

    public function refuel(float $amount)
    {
        if ($amount > $this->tankCapacity - $this->fuel) {
            throw new \Exception("Cannot fit fuel in tank");
        }

        $this->fuel += $amount;
    }

    public function drive(float $distance, bool $empty = false): string
    {
        if (!$empty) {
            $this->fuelConsumption += 1.4;
            $res = parent::drive($distance);
            $this->fuelConsumption -= 1.4;

            return $res;
        }

        return parent::drive($distance);
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
        if ($amount > $this->tankCapacity - $this->fuel) {
            throw new \Exception("Cannot fit fuel in tank");
        }

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

function readLine(): string
{
    return trim(fgets(STDIN));
}

function writeLine($content)
{
    echo $content . PHP_EOL;
}

$vehicles = [];

$tokens = explode(" ", readLine());
$vehicles["Car"] = new Car(floatval($tokens[1]), floatval($tokens[2]), floatval($tokens[3]));

$tokens = explode(" ", readLine());
$vehicles["Truck"] = new Truck(floatval($tokens[1]), floatval($tokens[2]), floatval($tokens[3]));

$tokens = explode(" ", readLine());
$vehicles["Bus"] = new Bus(floatval($tokens[1]), floatval($tokens[2]), floatval($tokens[3]));

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
            continue;
        }

        if ($command[0] === "DriveEmpty") {
            $vehicles["Bus"]->drive(floatval($command[2]), true);
        }
    } catch (\Exception $e) {
        writeLine($e->getMessage());
    }
}

writeLine(implode(PHP_EOL, $vehicles));


