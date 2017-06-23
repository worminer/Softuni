<?php
class Fibonacci
{
    /**
     * @var int[]
     */
    private $fibonacciSequence = [0, 1];
    public function __construct(int $endNumber)
    {
        $this->generateFibonacciSequence($endNumber);
    }

    public function getFibonacciRange(int $startNumber, int $endPos)
    {
        return array_slice($this->fibonacciSequence, $startNumber, $endPos);
    }

    private function generateFibonacciSequence(int $endNumber)
    {
        for ($i = 2; $i < $endNumber; $i++) {
            $a = $this->fibonacciSequence[$i - 2];
            $b = $this->fibonacciSequence[$i - 1];
            $this->fibonacciSequence[] = $a + $b;
        }
    }
}

$startNumber = intval(trim(fgets(STDIN)));
$endNumber = intval(trim(fgets(STDIN)));
$fibonacci = new Fibonacci($endNumber);
echo implode(", ", $fibonacci->getFibonacciRange($startNumber, $endNumber));