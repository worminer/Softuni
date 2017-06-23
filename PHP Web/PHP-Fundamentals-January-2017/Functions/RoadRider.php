<?php
/*
motorway = 130
interstate = 90
insideCity = 50
residential - 20

do 20km - speedin
do 40km excessive speeding
> 40 - recless driveing

*/

function isOverSpeeding(int $currentSpeed , string $area):string {

    //WHY use 2 functions tho.
    //$areaSpeedLimits = ["motorway" => 130 , "interstate" => 90 , "city" => 50,"residential" => 20];
    //$currentAreaSpeed = $areaSpeedLimits[$area];
    $currentSpeedLimit = getAreaSpeedLimit($area);
    $overSpeed = 0;
    if ($currentSpeed >= $currentSpeedLimit && $currentSpeed != -1) {
        $overSpeed = $currentSpeed - $currentSpeedLimit;

        if ( $overSpeed > 40) {
            return "reckless driving";
        } elseif ( $overSpeed < 20 ) {
            return "speeding";
        } else {
            return "excessive speeding";
         }
    }
    return '';
}

function getAreaSpeedLimit (string $area):int {
    switch ($area){
        case "motorway":
            return 130;
        break;
        case "interstate":
            return 90;
            break;
        case "city":
            return 50;
            break;
        case "residential":
            return 20;
            break;
        default:
            return -1;
            break;
    }
}

$currentSpeed = intval(fgets(STDIN));
$area = trim(fgets(STDIN));

echo isOverSpeeding($currentSpeed,$area);