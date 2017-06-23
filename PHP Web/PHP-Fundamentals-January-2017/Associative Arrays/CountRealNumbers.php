<?php
$inputArr = explode(" ", trim(fgets(STDIN)));
$outputArr = [];

foreach ($inputArr as $key) {
  if (!array_key_exists($key, $outputArr)) {
    $outputArr[$key] = 0;
  }
  $outputArr[$key]++;
}
ksort($outputArr);
foreach ($outputArr as $key => $value) {
  echo $key . " -> " . $value ." times\n";
}
