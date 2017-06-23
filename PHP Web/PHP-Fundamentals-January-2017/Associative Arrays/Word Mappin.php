<?php
if (isset($_GET['input']) && !empty($_GET['input'])) {
  preg_match_all('/\w+/',strtolower(trim($_GET['input'])),$inputArr,PREG_PATTERN_ORDER);
  $inputArr = $inputArr[0];

  $outputArr = [];
  foreach ($inputArr as $key){
    if (!array_key_exists($key,$outputArr)) {
      $outputArr[$key] = 0;
    }
    $outputArr[$key]++;

  }

  echo "<table border='2'>";
  foreach ($outputArr as $key => $value) {
    echo "<tr><td>{$key}</td><td>{$value}</td></tr>";
  }
  echo "</table>";
  die();
}
?>
<form action="" method="get">
  <textarea name="input" id="input" cols="50" rows="2" title="input"></textarea><br/>
  <input type="submit" value="Count words">
</form>