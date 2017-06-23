<?php
//zibxle-SutFA
//cleaoh-VxwID
//cleaoh-hVxwID
$inputString = $_GET['string'];
$key = $_GET['key'];
$inputStringToCharArr = str_split($inputString);
$outputCharArray = [];
function returnChar($char, $offset) {}
foreach ($inputStringToCharArr as $char) {
    $charASCII = ord($char);
    if ($charASCII >= 65 && $charASCII <= 90 ) {
        $newChar =  ord($char) + $key;
        while ($newChar > 90){
            $newChar = $newChar - 26;
        }
        $outputCharArray[] = chr($newChar);
    } else if ($charASCII <= 122 && $charASCII >= 97) {
        $newChar =  ord($char) + $key;
        while ($newChar > 122){
            $newChar = $newChar - 26;
        }
        $outputCharArray[] = chr($newChar);
    } else {
        $outputCharArray[] = $char;
    }
}
echo implode('',$outputCharArray);