<?php
  $test = "3 14 5 12 15 7 8 9 11 10 1";
  //$inputArr = explode(" ", trim($test));
  $inputArr = explode(" ", trim(fgets(STDIN)));
  $inputArrLen = count($inputArr);

  $sizeArr = [];
  $prevArr = [];

  for ($i = 0; $i < $inputArrLen; $i++) {
    $sizeArr[$i] = 1;
    $prevArr[$i] = -1;
    for ($n = 0; $n < $i; $n++) {
      if ($inputArr[$i] > $inputArr[$n]) {
        if ($sizeArr[$n] + 1 > $sizeArr[$i]) {
          $prevArr[$i] = $n;
          $sizeArr[$i] = $sizeArr[$n] + 1;
        }
      }
    }
  }
  $biggestRow = 0;
  $index = -1;
  $sizeArrLen = count($sizeArr);
  for ($i = 0; $i < $sizeArrLen; $i++) {
    if ($sizeArr[$i] > $biggestRow) {
      $biggestRow = $sizeArr[$i];
      $index = $i;
    }
  }

  $outputArr = [];
  while (true) {
    if ($index == -1) {
      break;
    }
    array_unshift($outputArr, $inputArr[$index]);
    $index = $prevArr[$index];
  }
  echo implode(' ', $outputArr);