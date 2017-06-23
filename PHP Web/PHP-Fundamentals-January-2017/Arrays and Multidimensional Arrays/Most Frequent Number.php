<?php
$inputArr = explode(" ", trim(fgets(STDIN)));
$test = "4 1 1 4 2 3 4 4 1 2 4 9 3";
//$inputArr = explode(" ", trim($test));
$bufferArr = [];

foreach ($inputArr as $key){

  if (!array_key_exists($key, $bufferArr)) {
    $bufferArr[$key] = 0;

  }
  $bufferArr[$key]++;
}

$biggest = -1;
$output = null;
foreach ($bufferArr as $number => $digits) {
  if ($digits > $biggest) {
    $biggest = $digits;
    $output = $number;
  }
}
echo $output;