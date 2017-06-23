<?php
$rocks = explode(',',$_GET["rocks"]);
$elements = [];
$rocksCount = count($rocks);
foreach ($rocks as $rock) {
    $rockElementsArr = str_split($rock);
    $rockElementsArr = array_unique($rockElementsArr);
    foreach ($rockElementsArr as $element) {
        if (!array_key_exists($element,$elements)) {
            $elements[$element] = 0;
        }
        $elements[$element]++;
    }
}
$preciousCountry = 0;
foreach ($elements as $elementCount) {
    if ($elementCount == $rocksCount) {
        $preciousCountry++;
    }
}
echo $preciousCountry;