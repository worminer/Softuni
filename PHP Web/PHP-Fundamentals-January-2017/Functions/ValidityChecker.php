<?php
function calcDistance(int $aX, int $aY, int $bX = 0, int $bY = 0): float
{
    $xDistance = $bX - $aX;
    $yDistance = $bY - $aY;
    return sqrt(($xDistance * $xDistance) + ($yDistance * $yDistance));
}

function getDistanceType(float $distance): string
{
    return round($distance) == $distance ? "valid" : "invalid";
}

$cordinatesArr = explode(", ", trim(fgets(STDIN)));

list($x1, $y1, $x2, $y2) = array_map("intval", $cordinatesArr);
$distanceA = getDistanceType(calcDistance($x1, $y1));
$distanceB = getDistanceType(calcDistance($x2, $y2));
$distanceC = getDistanceType(calcDistance($x1, $y1, $x2, $y2));
echo "{".$x1.", ".$y1."} to {0, 0} is ".$distanceA."\n";
echo "{".$x2.", ".$y2."} to {0, 0} is ".$distanceB."\n";
echo "{".$x1.", ".$y1. "} to {".$x2.", ".$y2."} is {$distanceC}";