<?php

namespace Mood3 ;

interface CharacterInterface
{
    public function getUsername(): string;

    public function setUsername(string $username);

    public function getHashedPassword(): string;

    public function getLevel(): int;

    public function setLevel(int $level);

    public function getSpecialPoints();

    public function setSpecialPoints($points);
}


abstract class CharacterBase implements CharacterInterface
{
    protected $hashedPassword;

    private $username;
    private $level;

    public function __construct(string $username, int $level)
    {
        $this->setUsername($username);
        $this->setLevel($level);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level)
    {
        $this->level = $level;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    function __toString()
    {
        return '"' . $this->getUsername() . '" | "' . $this->getHashedPassword() . '" -> ' . basename(get_class($this));
    }
}

class Archangel extends CharacterBase
{
    private $specialPoints;

    public function __construct(string $username, int $level, int $specialPoints)
    {
        parent::__construct($username, $level);

        $this->setSpecialPoints($specialPoints);
        $this->setHashedPassword();
    }

    public function getSpecialPoints()
    {
        return $this->specialPoints * $this->getLevel();
    }

    public function setSpecialPoints($points)
    {
        $this->specialPoints = $points;
    }

    private function setHashedPassword()
    {
        $this->hashedPassword = strrev($this->getUsername())  . strlen($this->getUsername())* 21;
    }

    function __toString()
    {
        // POORLY WRITTEN JUDGE TEST REQUIRED THIS v
        return '"' . $this->getUsername() . '" | "' . $this->getHashedPassword() . '" -> ' . basename(get_class($this)) . PHP_EOL
            .$this->getSpecialPoints() ;
    }
}

class Demon extends CharacterBase
{
    private $specialPoints;

    public function __construct(string $username, int $level, float $specialPoints)
    {
        parent::__construct($username, $level);

        $this->setSpecialPoints($specialPoints);
        $this->setHashedPassword();
    }

    public function getSpecialPoints()
    {
        return $this->specialPoints;
    }

    public function setSpecialPoints($points)
    {
        $this->specialPoints = $points;
    }

    private function setHashedPassword()
    {
        $this->hashedPassword = strlen($this->getUsername()) * 217;
    }

    function __toString()
    {
        return parent::__toString() . PHP_EOL
            . number_format($this->specialPoints * $this->getLevel(), 1, ".", "");
    }
}


$character = null;
$input = explode(" | ", readLine());
if ($input[1] === "Archangel") {
    $character = new Archangel($input[0], intval($input[3]), intval($input[2]));
} else {
    $character = new Demon($input[0], intval($input[3]), floatval($input[2]));
}

echo $character;

function readLine(): string
{
    return trim(fgets(STDIN));
}

function writeLine($content)
{
    echo $content . PHP_EOL;
}

