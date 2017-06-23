<?php

function isVolume($x, $y, $z){
    $x1 = 10;
    $x2 = 50;
    $y1 = 20;
    $y2 = 80;
    $z1 = 15;
    $z2 = 50;

    if ($x >= $x1 && $x <= $x2) {
        if ($y >= $y1 && $y <= $y2) {
            if ($z >= $z1 && $z <= $z2) {
                return true;
            }
        }
    }
    return false;
}

$inputArr = explode(", ", trim(fgets(STDIN)));
$inputLen = count($inputArr);
//var_export($inputArr);
for ($i = 0; $i < $inputLen; $i += 3) {
    $x = $inputArr[$i];
    $y = $inputArr[$i + 1];
    $z = $inputArr[$i + 2];

    if (isVolume($x,$y,$z)) {
        echo "inside". PHP_EOL;
    } else {
        echo "outside". PHP_EOL;

    }
}
