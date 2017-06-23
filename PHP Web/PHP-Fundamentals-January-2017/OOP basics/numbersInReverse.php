<?php
namespace reverse;
class Number {
    private $number;

    /**
     * Number constructor.
     * @param string $number
     */
    public function __construct(string $number)
    {
        $this->number = $number;
    }

    public function getReversedNumber ():string
    {
       return strrev($this->number);
    }
}

$number = trim(fgets(STDIN));
$numberObj = new Number($number);
echo $numberObj->getReversedNumber();