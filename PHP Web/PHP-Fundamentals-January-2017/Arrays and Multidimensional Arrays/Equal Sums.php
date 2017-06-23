<?php
$inputArr = explode(" ", trim(fgets(STDIN)));
$inputArrLen = count($inputArr);

if ($inputArrLen == 1) {
  echo "0";

} else {
  $leftSum = 0;
  $flag = false;
  for ($i = 0; $i < $inputArrLen; ++$i) {

    $rightSum = 0;

    if ($i != 0) {
      $leftSum += $inputArr[$i-1];
    }

    for ($n = $i + 1; $n < $inputArrLen; ++$n) {
      $rightSum += $inputArr[$n];
    }


    if ($leftSum == $rightSum ) {
      echo $i;
      $flag = true;
      break;
    }

  }
  if ($flag == false) {
    echo "no";
  }
}


