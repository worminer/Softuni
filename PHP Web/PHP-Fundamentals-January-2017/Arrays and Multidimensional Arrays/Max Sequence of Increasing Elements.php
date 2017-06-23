<?php
$inputArr = explode(" ", trim(fgets(STDIN)));
$test = "4 5 1 2 3 4 5";
///$inputArr = explode(" ", trim($test));
//var_export($inputArr);

$inputArrCount = count($inputArr);
$counter = 0;
$index = 0;
//echo $inputArrCount." < count \n";
for ($i = 0; $i < $inputArrCount; $i++) {
  $currentElement = $inputArr[$i];
  $localCounter = 1;
  for ($n = $i + 1 ; $n < $inputArrCount; $n++) {
    if ($inputArr[$n] > $currentElement)  {
      $currentElement = $inputArr[$n];
      $localCounter++;
    } else {
      break;
    }
  }
  //echo $currentElement . "-" . $localCounter ."\n";

  if ($localCounter > $counter) {
    $counter = $localCounter;
    $index = $i;
  }
}
//echo $element . " e " . $counter;
echo implode(' ', array_slice($inputArr, $index, $counter));

