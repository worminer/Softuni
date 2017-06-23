<form action="" method="get">
  <label for="firstNumber">Starting index:</label>
  <input type="number" name="firstNumber" id="firstNumber" required>
  <label for="lastNumber">End:</label>
  <input type="number" name="lastNumber" id="lastNumber" required>
  <input type="submit" value="Submit">
</form>
<?php
  function isPrime($num)
  {
    for ($i = 2; $i <= sqrt($num); $i++) {
      if ($num % $i == 0) {
        return false;
      }
    }
    return true;
  }

  $firstNumber = null;
  $lastNumber = null;

  if (isset($_GET['firstNumber'])) {
    $firstNumber = (int)$_GET['firstNumber'];
  }
  if (isset($_GET['lastNumber'])) {
    $lastNumber = (int)$_GET['lastNumber'];
  }

  if (empty($firstNumber) || empty($lastNumber) || $firstNumber <= 1 || $lastNumber <= $firstNumber){
    die("");
  }
  $output = '';

  for ($i = $firstNumber; $i <= $lastNumber; $i++) {
    if (isPrime($i)) {
      $output .= "<strong>{$i}</strong>";
    } else {
      $output .= "{$i}";
    }
    if ($i < $lastNumber) {
      $output .= ", ";
    }
}

echo $output;
