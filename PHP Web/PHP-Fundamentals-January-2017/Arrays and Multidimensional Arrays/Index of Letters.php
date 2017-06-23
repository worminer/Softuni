<?php
$test = "Abcz";
//$inputStr = strtolower(trim($test));
$inputStr = strtolower(trim(fgets(STDIN)));
$inputStrLen = strlen($inputStr);

for ($i = 0; $i < $inputStrLen; ++$i) {
  $currentChar = $inputStr[$i];

  echo  $currentChar . " -> " . (ord($currentChar) - 97) ."\n";
}

