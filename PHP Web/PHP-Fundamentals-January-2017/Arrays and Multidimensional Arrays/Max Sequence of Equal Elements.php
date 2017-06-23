<?php
$inputArr = explode(" ", trim(fgets(STDIN)));
$test = "2 1 1 2 3 3 2 2 2 1";
//$inputArr = explode(" ", trim($test));
//var_export($inputArr);

$inputArrCount = count($inputArr);
$counter = 0;
$element = '';
//echo $inputArrCount." < count \n";
for ($i = 0; $i < $inputArrCount; $i++) {
  $currentElement = $inputArr[$i];
  $localCounter = 1;
  for ($n = $i + 1 ; $n < $inputArrCount; $n++) {
    if ($inputArr[$n] == $currentElement)  {
      $localCounter++;
    } else {
      break;
    }
    $i = $n;
  }
  //echo $currentElement . "-" . $localCounter ."\n";

  if ($localCounter > $counter) {
      $counter = $localCounter;
      $element = $currentElement;

  }
}
//echo $element . " e " . $counter;
echo implode(" ",array_fill(0,$counter,$element));
