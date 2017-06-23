<?php
$strainArr = str_split("ATCGTTAGGG");
$strainLen = intval(fgets(STDIN));
$strainOutput = "";
$counter = 0;
$lineCounter = 1;
$strainArrLen = count($strainArr);

for ($i = 0; $i < $strainLen; ++$i) {
    if ($lineCounter == 1 || $lineCounter == 5) {
        $strainOutput .= "**{$strainArr[$counter]}{$strainArr[$counter+1]}**\n";
    } elseif ($lineCounter == 2) {
        $strainOutput .= "*{$strainArr[$counter]}--{$strainArr[$counter+1]}*\n";
    } elseif ($lineCounter == 3) {
        $strainOutput .= "{$strainArr[$counter]}----{$strainArr[$counter+1]}\n";
    } elseif ($lineCounter == 4) {
        $strainOutput .= "*{$strainArr[$counter]}--{$strainArr[$counter+1]}*\n";
    }
    $lineCounter++;
    if ($lineCounter >=5) {
        $lineCounter = 1;
    }
    $counter += 2;
    $counter = $counter % $strainArrLen;
}
echo $strainOutput;