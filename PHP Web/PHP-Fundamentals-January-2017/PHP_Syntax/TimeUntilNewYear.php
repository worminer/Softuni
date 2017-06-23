<?php
date_default_timezone_set("UTC");
$currentDate = strtotime('12-08-2014 11:08:47');
$currentYear = date('Y', $currentDate);
$newYear = strtotime("31-12-{$currentYear} 23:59:59");
$diff = $newYear - $currentDate;

echo 'Hours until new year : ' . number_format(floor($diff / 60 / 60), 0, '.', '') . '<br>';

echo 'Minutes until new year : ' . number_format(floor($diff / 60), 0, '.', ' ') . '<br>';

echo 'Seconds until new year : ' . number_format($diff, 0, '.', ' ') . '<br>';

$days = floor($diff / 60 / 60 / 24);
$hours = floor($diff / 60 / 60) % $days;
$minutes = floor($diff / 60) % 60;
$seconds = $diff % 60;

echo "Days:Hours:Minutes:Seconds {$days}:{$hours}:{$minutes}:{$seconds}";