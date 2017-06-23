<?php
$input = trim(fgets(STDIN));
// може и с регулар експрешън ама ..

$input = str_replace('<a href="', "[URL=", $input);
$input = str_replace('">', "]", $input);
$input = str_replace('</a>', "[/URL]", $input);

echo $input;
