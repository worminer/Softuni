<style>
  table, th, td {
    border: 1px solid black;
    border-collapse:collapse;
    padding: 5px 5px;
  }
</style>

<form action="" method="GET">
  <label for="firstNumber">Starting index:</label>
  <input type="text" name="string"  />
  <button type="submit">Show results</button>
</form>
<br>
<?php
  $stringArr = '';
  if (isset($_GET['string'])) {
    $stringArr = explode(",", $_GET['string']);
  }
  if (empty($stringArr)) {
    die();
  }

  echo "<table>";
  foreach ($stringArr as $string)
  {

    $string = trim($string);
    echo "<tr><td>" . $string . "</td>";
    if (empty((int)$string)) {
      echo "<td>I cannot sum that</td>";
    } else {
      $sum = 0;
      for ($i = 0; $i < strlen((int)$string); $i++) {
        $sum += $string[$i];
      }

      echo "<td>" . $sum . "</td>";
    }



    echo "</tr>";
  }
  echo "</table>";
?>

