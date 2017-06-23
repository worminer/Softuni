<?php

namespace BorderControl ;

class Citizen implements IdentifiableInterface
{
    private $name;
    private $age;
    private $id;

    public function __construct(string $name, int $age, string $id)
    {
        $this->name = $name;
        $this->age = $age;
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}


interface IdentifiableInterface
{
    public function getId(): string;
}


class Robot implements IdentifiableInterface
{
    private $id;
    private $model;

    public function __construct(string $model, string $id)
    {
        $this->model = $model;
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}

$entries = [];

while (true) {
    $tokens = explode(" ", readLine());
    if ($tokens[0] == "End") {
        break;
    }

    if (count($tokens) == 3) {
        $entries[] = new Citizen($tokens[0], intval($tokens[1]), $tokens[2]);
    } else {
        $entries[] = new Robot(...$tokens);
    }
}

$bannedId = readLine();
foreach ($entries as $entry) {
    if (preg_match("/" . $bannedId . "$/", $entry->getId())) {
        writeLine($entry->getId());
    }
}

function readLine(): string
{
    return trim(fgets(STDIN));

}

function writeLine($content)
{
    echo $content . PHP_EOL;
}


