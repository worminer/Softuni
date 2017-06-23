<style>
  table, th, td {
    border: 1px solid black;
  }
</style>
<?php
  $SQsum= 0;

  function SqRootSum($number)
  {
    return sqrt($number);
  }

  echo "<table>";
  for ($i = 0; $i <= 100; $i += 2) {
    $SQresult = round(sqrt($i),2);
    $SQsum += $SQresult;
    echo "
      <tr >
        <th>{$i}</th>
        <th>{$SQresult}</th>
      </tr>
    ";
  }
  echo "
    <tr >
      <th><b>Total:</b></th>
      <th>". $SQsum ."</th>
    </tr>"
  ;

  echo "</table>";