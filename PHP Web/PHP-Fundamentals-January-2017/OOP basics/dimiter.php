<?php
namespace dimiter;
class Car
{

    private $model;
    private $fuel;
    private $fuelConsumption;
    private $distanceTraveled = 0.00;
    public function __construct(string $model, float $fuel, float $fuelConsumption)
    {
        $this->model = $model;
        $this->fuel = $fuel;
        $this->fuelConsumption = $fuelConsumption;
    }

    public function calcDistance(float $newDistance){
        $fuelNeeded = $newDistance * $this->fuelConsumption;

        if ($fuelNeeded < $this->fuel){
            $this->distanceTraveled += $newDistance;
            $this->fuel = abs($this->fuel);
            $this->fuel -= $fuelNeeded;
        }else{
            echo "Insufficient fuel for the drive\n";
        }
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getFuel(): float
    {
        return $this->fuel;
    }
    public function getDistanceTraveled(): int
    {
        return $this->distanceTraveled;
    }

    public function __toString()
    {
        $fuel = number_format((float)$this->getFuel(), 2, '.', '');
        $distance = round($this->getDistanceTraveled(),2);
        return "{$this->getModel()} {$fuel} {$distance}\n";
    }

}
$cars = [];
$num = intval(trim(fgets(STDIN)));
for ($i = 0;$i < $num;$i++){
    $input = explode(" ", trim(fgets(STDIN)));
    $car = new Car($input[0],floatval($input[1]),floatval($input[2]));
    $cars[$input[0]] = $car;
}
while (true){
    $input = explode(" ", trim(fgets(STDIN)));
    if ($input[0] == "End"){
        break;
    };
    $cars[$input[1]]->calcDistance(floatval($input[2]));
}
foreach ($cars as $car) {
    echo $car->__toString();
}


