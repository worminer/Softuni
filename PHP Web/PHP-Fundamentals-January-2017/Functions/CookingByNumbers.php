<?php
function chopFloat(float $number):float {
    return $number / 2;
}

function diceFloat(float $number):float {
    return sqrt($number) ;
}

function spiceFloat(float $number):float {
    return $number + 1;
}

function bakeFloat(float $number):float {
    return $number * 3;
}

function filletFloat(float $number):float {
    return $number - ($number * 0.2);
}

function cook (float $number, string $command):float {
    switch ($command)
    {
        case "chop":
            $number = chopFloat($number);
            break;
        case "dice":
            $number = diceFloat($number);
            break;
        case "spice":
            $number = spiceFloat($number);
            break;
        case "bake":
            $number = bakeFloat($number);
            break;
        case "fillet":
            $number = filletFloat($number);
            break;
        default:
            break;
    }
    return $number;
}

$number = floatval(fgets(STDIN));
$commands = explode(", ", trim(fgets(STDIN)));


foreach ($commands as $command)
{
    $number = cook($number , trim($command));
    echo $number."\n";
}