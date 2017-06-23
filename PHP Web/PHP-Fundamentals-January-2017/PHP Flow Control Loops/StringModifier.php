<form action="" method="get">
    <input type="text" name="string" id="string" required>
    <input type="radio" name="option" value="palindrome" title="Check Palindrome" required> Check Palindrome
    <input type="radio" name="option" value="reverse" title="Reverse string"> Reverse string
    <input type="radio" name="option" value="split" title="Split"> Split
    <input type="radio" name="option" value="hash" title="Hash string"> Hash string
    <input type="radio" name="option" value="shuffle" title="Shuffle string"> Shuffle string
    <input type="submit">
</form>
<?php
if (isset($_GET['string'])&& isset($_GET['option']) && !empty(trim($_GET['string'])) && !empty(trim($_GET['option']))) {
  $string = trim($_GET['string']);
  $option = trim($_GET['option']);
 if ($option == "palindrome") {
    if (strrev($string) === $string){
      echo $string .' is palindrome!';
    } else {
      echo $string .' is not a palindrome!';
    }
  } else if ($option == "reverse") {

    echo strrev($string);

  } else if ($option == "split") {

    echo implode(' ', str_split($string));

  } else if ($option == "hash") {

    echo @crypt($string); // @ so it will not cry about salt

  } else if ($option == "shuffle") {

    $charArr = str_split($string);
    shuffle($charArr);
    echo implode('', $charArr);

  } else {

    echo "There is no such option";

  }
}