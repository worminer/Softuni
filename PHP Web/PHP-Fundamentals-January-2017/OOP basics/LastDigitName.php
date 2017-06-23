<?php

class Number {
    private $number;

    /**
     * Number constructor.
     * @param int $number
     */
    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function getLastDigit():int
    {
        return $this->number % 10;
    }

    public function getNumberAsWord(int $digit):string
    {
        switch ($digit){
            case "0":
                return "zero";
                break;
            case "1":
                return "one";
                break;
            case "2":
                return "two";
                break;
            case "3":
                return "three";
                break;
            case "4":
                return "four";
                break;
            case "5":
                return "five";
                break;
            case "6":
                return "six";
                break;
            case "7":
                return "seven";
                break;
            case "8":
                return "eight";
                break;
            case "9":
                return "nine";
                break;
            default:
                break;

        }
    }

    public function lastDigitAsWord():string
    {
        return $this->getNumberAsWord($this->getLastDigit());
    }

    public function __toString()
    {
        return $this->lastDigitAsWord();
    }
}

$number = intval(fgets(STDIN));
$numberObj = new Number($number);
echo $numberObj;