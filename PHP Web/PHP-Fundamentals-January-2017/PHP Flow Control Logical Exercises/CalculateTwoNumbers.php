<?php
$operation = $argv[1];
$num1 = intval(fgets(STDIN));
$num2 = intval(fgets(STDIN));
switch ($operation) {
  case 'sum':
    echo $num1 + $num2;
    break;
  case 'subtract':
    echo $num1 - $num2;
    break;
  default:
    echo 'Wrong operation supplied!';
    break;
}