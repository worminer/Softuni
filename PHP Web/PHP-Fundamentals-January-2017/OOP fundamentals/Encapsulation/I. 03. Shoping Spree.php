<?php


namespace ShoppingSpree;

class Product
{
    private $name;
    private $price;

    public function __construct(string $name, float $money)
    {
        $this->setName($name);
        $this->setPrice($money);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setName(string $name)
    {
        Validator::validateNonEmptyString($name, "Name");
        $this->name = $name;
    }

    public function setPrice(float $price)
    {
        Validator::validatePositiveNumber($price, "Price");
        $this->price = $price;
    }
}

class Person
{
    private $name;
    private $money;

    /**
     * @var Product[] $products
     */
    private $products = [];

    public function __construct(string $name, float $money)
    {
        $this->setName($name);
        $this->setMoney($money);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        Validator::validateNonEmptyString($name, "Name");
        $this->name = $name;
    }

    public function setMoney(float $money)
    {
        Validator::validatePositiveNumber($money, "Money");
        $this->money = $money;
    }

    public function buyProduct(Product $product): bool
    {
        if ($this->money < $product->getPrice()) {
            return false;
        }

        $this->money -= $product->getPrice();
        $this->products[] = $product;

        return true;
    }

    public function __toString(): string
    {
        $output = "{$this->name} - ";
        if (count($this->products) === 0) {
            return $output . "Nothing bought";
        }

        return $output . implode(",",
            array_map(
                function (Product $product) {
                    return $product->getName();
                },
                $this->products));
    }
}

class Shop
{
    /**
     * @var Person[] $customers
     */
    private $customers = [];

    /**
     * @var Product[] $products
     */
    private $products = [];

    public function sellProduct(Product $product, Person $customer): bool
    {
        return $customer->buyProduct($product);
    }

    public function addCustomer(Person $customer)
    {
        $this->customers[$customer->getName()] = $customer;
    }

    public function addProduct(Product $product)
    {
        $this->products[$product->getName()] = $product;
    }

    public function getCustomer(string $name): Person
    {
        return $this->customers[$name];
    }

    public function getProduct(string $name): Product
    {
        return $this->products[$name];
    }

    /**
     * @return Person[]
     */
    public function getCustomers(): array
    {
        return $this->customers;
    }
}

class Validator
{
    private function __construct()
    {
        // Simulate static class by preventing instantiation
    }

    /**
     * @param float $num
     * @param string $valName
     * @throws \Exception
     */
    public static function validatePositiveNumber(float $num, string $valName)
    {
        if ($num < 0)
            throw new \Exception("{$valName} cannot be negative");
    }

    /**
     * @param string $str
     * @param string $valName
     * @throws \Exception
     */
    public static function validateNonEmptyString(string $str, string $valName)
    {
        if (strlen($str) == 0)
            throw new \Exception("{$valName} cannot be empty");
    }
}


//** APP **/
$shop = new Shop();

$customers = array_filter(explode(";",trim(fgets(STDIN))));
$products = array_filter(explode(";", trim(fgets(STDIN))));

try {
    foreach ($customers as $customerData) {
        if (strstr($customerData, "=") === false) {
            throw new \Exception("Name cannot be empty");
        }

        $customerData = explode("=", $customerData);
        $customer = new Person($customerData[0], floatval($customerData[1]));
        $shop->addCustomer($customer);
    }

    foreach ($products as $productData) {
        if (strstr($productData, "=") === false) {
            throw new \Exception("Name cannot be empty");
        }

        $productData = explode("=", $productData);
        $product = new Product($productData[0], floatval($productData[1]));
        $shop->addProduct($product);
    }

    while (true) {
        $tradeDetails = explode(" ", trim(fgets(STDIN)));

        if ($tradeDetails[0] === "END") {
            break;
        }

        $customer = $shop->getCustomer($tradeDetails[0]);
        $product = $shop->getProduct($tradeDetails[1]);

        if ($shop->sellProduct($product, $customer)) {
            echo "{$customer->getName()} bought {$product->getName()}".PHP_EOL;
        } else {
            echo "{$customer->getName()} can't afford {$product->getName()}".PHP_EOL;
        }
    }
} catch (\Exception $e) {
    echo $e->getMessage().PHP_EOL;
    exit();
}


foreach ($shop->getCustomers() as $customer) {
    echo $customer.PHP_EOL;
}