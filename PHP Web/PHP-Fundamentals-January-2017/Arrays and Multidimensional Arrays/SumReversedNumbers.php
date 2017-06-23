<?php

$inputArr = explode(" ", trim(fgets(STDIN)));
$inputArrLen = count($inputArr);

$sum = 0;
for ($i = 0; $i < $inputArrLen; ++$i) {
  $sum += (int) strrev($inputArr[$i]);
}
echo $sum;

