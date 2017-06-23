<?php
$fistName = "Martin";
$lastName = "Dimitrov";
$age = 28;

echo "My name is {$fistName} {$lastName} and I am {$age} years old."; // variant 1
echo "<br>";
echo "My name is $fistName $lastName and I am $age years old."; // variant 2
echo "<br>";
echo "My name is " . $fistName . " " . $lastName . " and I am " . $age . " years old."; //variant 3
echo "<br>";
