<?php
$str = "hello";
$int = 15;
$flt = 1.234;
$arr = array(1,2,3);
$obj = (object) array(2.34);


function displayData($data)
{
  if (is_numeric($data)) {
    var_dump($data);
  } else {
    echo gettype($data);
  }
  echo "<br>";
}

displayData($str);
displayData($int);
displayData($flt);
displayData($arr);
displayData($obj);


