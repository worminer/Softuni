<?php
  $test = "1 2 4 5 6 7";
  //$inputArr = explode(" ", trim($test));
  $inputArr = explode(" ", trim(fgets(STDIN)));

  $run = true;

  function add(&$array, $index, $element)
  {
    if (intval($index) >= count($array)) {
      array_push($array, $element);
    } else {
      array_splice($array, intval($index), 0, $element);
    }
  }

  function addMany(&$array, $index, $elements)
  {
    array_splice($array, intval($index), 0, $elements);
  }

  function contains($array, $element)
  {
    $res = array_search($element, $array);
    if ($res === false) {
      return -1;
    }
    return $res;
  }

  function remove(&$array, $index)
  {
    array_splice($array, intval($index), 1);
  }

  function shift(&$array, $rotations)
  {
    $rotations = intval($rotations) % count($array);
    for ($i = 0; $i < $rotations; $i++) {
      $element = array_shift($array);
      array_push($array, $element);
    }
  }

  function sumPairs(&$array)
  {
    $newArray = [];
    $arrayCount =  count($array);
    for ($i = 0; $i < $arrayCount; $i += 2) {
      $sum = $array[$i];
      if ($i + 1 < $arrayCount) {
        $sum += $array[$i + 1];
      }
      array_push($newArray, $sum);
    }
    $array = $newArray;
  }

  while ($run) {
    $commandArr = explode(" ", trim(fgets(STDIN)));

    $command = $commandArr[0];
    array_shift($commandArr);

    switch ($command) {
      case 'print':
        $run = false;
        break;
      case 'add':
        add($inputArr, $commandArr[0], $commandArr[1]);
        break;
      case 'addMany':
        addMany($inputArr, array_shift($commandArr), $commandArr);
        break;
      case 'contains':
        echo contains($inputArr, $commandArr[0]) . "\n";
        break;
      case 'remove':
        remove($inputArr, $commandArr[0]);
        break;
      case 'shift':
        shift($inputArr, $commandArr[0]);
        break;
      case 'sumPairs':
        sumPairs($inputArr);
        break;
      default:
        echo 'None existing command!';
        break;
    }

  }

  echo '[' . implode(', ', $inputArr) . ']';
