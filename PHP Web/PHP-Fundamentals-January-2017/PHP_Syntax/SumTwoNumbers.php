<?php
// variant 1 .. echo the static parts and the dynamic
$firstNumber = 2;
$secondNumber = 5;



echo '$firstNumber + $secondNumber = '. $firstNumber .' + '. $secondNumber .' = ' . ($firstNumber + $secondNumber) ;

?>
<br>
<?php
// variant 2 .. php injection in html(ish)
$firstNumber = 1.567808;
$secondNumber = 0.356;
?>

$firstNumber + $secondNumber = <?php echo $firstNumber; ?> + <?php echo $secondNumber; ?> = <?php echo round($firstNumber + $secondNumber, 2); ?>
