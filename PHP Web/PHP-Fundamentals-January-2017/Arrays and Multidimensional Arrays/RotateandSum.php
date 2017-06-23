<?php
$inputArr = explode(" ", trim(fgets(STDIN)));
$rotations = intval(trim(fgets(STDIN)));
//$inputArr = [1,2,3,4,5];
//$rotations = 3;

$sumArr = array_fill(0, count($inputArr), 0);

function sumArr($arrSum, $arr)
{
  for ($i = 0; $i < count($arrSum); $i++) {
    $arrSum[$i] = intval($arrSum[$i]) + intval($arr[$i]);
  }
  return $arrSum;
}

function rotateArr($arr)
{
  $element = array_pop($arr);
  array_unshift($arr, $element);
  return $arr;
}

for ($i = 1; $i <= $rotations; $i++) {
  $inputArr = rotateArr($inputArr);
  //var_export($inputArr);
  $sumArr = sumArr($sumArr, $inputArr);
}

echo implode(' ', $sumArr);