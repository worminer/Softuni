<?php
class DecimalNumber
{
    private $num;
    public function __construct(float $num)
    {
        $this->num = $num;
    }
    public function reverseNum(){
        $num = strval($this->num);
        return strrev($num);
    }
}
$input = floatval(trim(fgets(STDIN)));
$num = new DecimalNumber($input);
echo $num->reverseNum();