<?php
declare(strict_types = 1);
$inputString = trim(fgets(STDIN));
echo isPalindrome($inputString) ? "true" : "false";

function isPalindrome(string $string): bool
{
    return $string === strrev($string);
}