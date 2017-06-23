<?php
// for task 3 and 4
$numbers = [];
while (true) {
  $line = trim(fgets(STDIN));
  if (empty($line))
    break;
  if (is_numeric($line))
    array_push($numbers, intval($line));
}
echo 'Max: '. max($numbers);