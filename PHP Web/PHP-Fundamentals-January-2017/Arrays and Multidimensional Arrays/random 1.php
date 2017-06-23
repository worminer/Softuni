<?php

$array = fgets(STDIN);
$array = array_map('trim', explode(' ', $array));

$number = 0;
$currentSequence = 1;
$longestSequence = 1;

for ($i=0; $i < count($array)-1; $i++){
    if ($array[$i] == $array[$i + 1]){
        $currentSequence++;
        if ($currentSequence > $longestSequence){
            $longestSequence = $currentSequence;
            $number = $array[$i];
        }
    }
    else {
        $currentSequence = 1;
    }
}

$result = implode(' ', array_fill(0, $longestSequence, $number));

echo $result;
