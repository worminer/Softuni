<?php

namespace CollectionHierarchy ;

class AddCollection extends Collection implements AddInterface
{
    public function Add(string $element): int
    {
        return array_push($this->elements, $element) - 1;
    }
}
interface AddInterface
{
    public function Add(string $element): int;
}

class AddRemoveCollection extends Collection implements AddInterface, RemoveInterface
{
    public function Add(string $element): int
    {
        array_unshift($this->elements, $element);

        return 0;
    }

    public function remove(): string
    {
        return array_pop($this->elements);
    }
}

abstract class Collection
{
    protected $elements = [];
}

class MyList extends Collection implements AddInterface, RemoveInterface, UsedInterface
{
    public function Add(string $element): int
    {
        array_unshift($this->elements, $element);

        return 0;
    }

    public function remove(): string
    {
        return array_shift($this->elements);
    }

    public function used(): int
    {
        return count($this->elements);
    }
}

interface RemoveInterface
{
    public function remove(): string;
}

interface UsedInterface
{
    public function used(): int;
}


$addCollection = new AddCollection();
$addRemoveCollection = new AddRemoveCollection();
$myList = new MyList();

/**
 * @var $addCollections AddInterface[]
 */
$addCollections = [$addCollection, $addRemoveCollection, $myList];

/**
 * @var $removeCollections RemoveInterface[]
 */
$removeCollections = [$addRemoveCollection, $myList];

$input = explode(" ", readLine());
foreach ($addCollections as $collection) {
    $output = [];
    foreach ($input as $item) {
        $output[] = $collection->Add($item);
    }

    writeLine(implode(" ", $output));
}

$numOfRemovals = intval(readLine());
foreach ($removeCollections as $collection) {
    $output = [];
    for ($i = 0; $i < $numOfRemovals; $i++) {
        $output[] = $collection->remove();
    }

    writeLine(implode(" ", $output));
}

function readLine(): string
{
    return trim(fgets(STDIN));
}

/**
 * @param $content mixed
 * @return void
 */
function writeLine($content)
{
    echo $content . PHP_EOL;
}