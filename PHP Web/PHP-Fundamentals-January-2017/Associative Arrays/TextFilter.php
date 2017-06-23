<?php
$text = trim(fgets(STDIN));
$bannedWords = explode(", ", trim(fgets(STDIN)));

foreach ($bannedWords as $word) {
  $text = str_replace($word, str_repeat("*", strlen($word)), $text);
}
echo $text;