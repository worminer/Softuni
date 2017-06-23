<?php
if (isset($_GET['input']) && !empty($_GET['input'])) {
  $input = trim($_GET['input']);
  $inputLen = strlen($input);

  $output = '';
  for ($i = 0; $i < $inputLen; ++$i) {
    if ($input[$i] != " ") {
      $char = ord($input[$i]);

      if (($char % 2) == 0) {
        echo "<font color='red'>{$input[$i]} </font>";
      } else {
        echo "<font color='blue'>{$input[$i]} </font>";
      }
    }
  }
}
