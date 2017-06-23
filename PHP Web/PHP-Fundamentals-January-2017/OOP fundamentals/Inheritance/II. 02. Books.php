<?php

namespace books ;


$author = readLine();
$bookName = readLine();
$price = floatval(readLine());
$bookType = readLine();

try {
    $book = null;
    if ($bookType == "STANDARD") {
        $book = new Book($bookName, $author, $price);
    } else if ($bookType == "GOLD") {
        $book = new GoldenEditionBook($bookName, $author, $price);
    } else {
        throw new \Exception("Type is not valid!");
    }

    echo "OK\n";
    echo $book->getPrice();
} catch (\Exception $e) {
    echo $e->getMessage();
}

function readLine(): string
{
    return trim(fgets(STDIN));
}

class Book
{
    private $title;
    private $author;
    private $price;

    public function __construct(string $title, string $author, float $price)
    {
        $this->setTitle($title);
        $this->setAuthor($author);
        $this->setPrice($price);
    }

    protected function setTitle(string $title)
    {
        if (strlen($title) < 3) {
            throw new \Exception("Title not valid!");
        }

        $this->title = $title;
    }

    protected function setAuthor(string $author)
    {
        $name = explode(" ", $author);
        if (is_numeric($name[1][0])) {
            throw new \Exception("Author not valid!");
        }

        $this->author = $author;
    }

    protected function setPrice(float $price)
    {
        if ($price <= 0) {
            throw new \Exception("Price not valid!");
        }

        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function __toString()
    {
        return "{$this->title} {$this->author} ({$this->price})";
    }
}

class GoldenEditionBook extends Book
{
    public function getPrice()
    {
        return parent::getPrice() * 1.3;
    }
}






