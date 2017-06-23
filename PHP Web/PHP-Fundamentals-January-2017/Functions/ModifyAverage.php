<?php
$number = trim(fgets(STDIN));
$numbersArr = str_split($number);

function findAverage(array $numbersArr):float {
    $average = 0;
    foreach ($numbersArr as $digit){
        $average += $digit;
    }
    $average = $average / count($numbersArr);
    return $average;
}

while (findAverage($numbersArr) < 5 )
{
    array_push($numbersArr,9);
}

echo implode("",$numbersArr);