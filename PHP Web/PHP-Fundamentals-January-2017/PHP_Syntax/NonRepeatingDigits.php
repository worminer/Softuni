<?php

function showDigits($n)
{
  //echo $n . " -> ";

  if ($n >= 102) {
    for ($i = 102; $i <= min($n,987); $i++) {
      echo $i . " ";
    }

  } else {
    echo "no";
  }
  echo "<br><br>";
}

//showDigits(1234);
//showDigits(145);
//showDigits(15);
//showDigits(247);
?>
<style>
  table, th, td {
    border: 1px solid black;
  }
</style>
<table style="width:90%;">
  <tr >
    <th style="width:5%;">input</th>
    <th>output</th>
  </tr>
  <tr>
    <td style="width:10%;">1234</td>
    <td><?php showDigits(1234);?></td>
  </tr>
  <tr>
    <td>145</td>
    <td><?php showDigits(145);?></td>
  </tr>
  <tr>
    <td>15</td>
    <td><?php showDigits(15);?></td>
  </tr>
  <tr>
    <td>247</td>
    <td><?php showDigits(247);?></td>
  </tr>
</table>

