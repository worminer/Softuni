<?php
$inputArr1 = explode(" ", trim(fgets(STDIN)));
$inputArr2 = explode(" ", trim(fgets(STDIN)));

function arrCommonCounter($arr1,$arr2){
  $Arr1Len = count($arr1);
  $Arr2Len = count($arr2);
  $shorterArrLen = min($Arr1Len,$Arr2Len);
  $counter = 0;
  for ($i = 0; $i < $shorterArrLen; $i++) {

    if ($arr1[$i] == $arr2[$i]) {
      $counter++;
    } else {
      break;
    }
  }
  return $counter;
}
$forwardCounter = arrCommonCounter($inputArr1,$inputArr2);
$backwardCounter = arrCommonCounter(array_reverse($inputArr1),array_reverse($inputArr2));


echo max($forwardCounter,$backwardCounter);

/* test data
hi php java csharp sql html css js
hi php java js softuni nakov java learn

hi php java xml csharp sql html css js
nakov java sql html css js

I love programming
Learn Java or C#

*/
