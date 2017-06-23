<?php
// #hacksMuch ?

// Calculating all sundays
function getSundays($year,$month){
  $firstOfTheMonth = "$year-$month-01"; // getting the fist date of this month
  $first_day = date('N',strtotime($firstOfTheMonth));
  $first_day = 7 - $first_day + 1;
  $last_day =  date('t',strtotime($firstOfTheMonth));
  $days = array();
  // we put all the sundays in array using the "jS F, Y" format.. given by the exercise
  for($i=$first_day; $i<=$last_day; $i=$i+7 ){
    $days[] = date('jS F, Y',strtotime("$year-$month-".$i));;
  }
  return  $days;
}

$days = getSundays(2014,"08"); // setting up the date given by the exercise

// displaying the result ..
foreach ($days as $day) {
  echo $day .'<br>';
}