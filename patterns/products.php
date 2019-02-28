<?php

interface Product {
    public function getName(): string;
    public function getPrice(): int;
}

class StandardProduct implements Product
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $price;

    /**
     * StandardProduct constructor.
     * @param string $name
     * @param int $price
     */
    public function __construct(string $name, int $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }
}

class Gift implements Product
{
    /**
     * @var Product
     */
    private $product;

    /**
     * Gift constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getName(): string
    {
        return $this->product->getName() . ' GIFT!!!';
    }

    public function getPrice(): int
    {
        return 0;
    }
}

class Combo implements Product
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Product[]
     */
    private $products;

    /**
     * Combo constructor.
     * @param string $name
     * @param Product[] $products
     */
    public function __construct(string $name, array $products)
    {
        $this->name = $name;
        $this->products = $products;
    }

    public function getPrice(): int
    {
        return array_sum(array_map(function (Product $product) {
            return $product->getPrice();
        }, $this->products));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}

interface Discount
{
    public function calculatePrice(float $price): float;
}

class Fixed implements Discount
{
    /**
     * @var float
     */
    private $price;

    /**
     * Fixed constructor.
     * @param float $price
     */
    public function __construct(float $price)
    {
        $this->price = $price;
    }

    public function calculatePrice(float $price): float
    {
        return max($price - $this->price, 0);
    }
}

class Ratio implements Discount
{
    /**
     * @var float
     */
    private $ratio;

    /**
     * Ratio constructor.
     * @param float $ratio
     */
    public function __construct(float $ratio)
    {
        $this->ratio = $ratio;
    }

    public function calculatePrice(float $price): float
    {
        return $price * $this->ratio;
    }
}

class Discounted implements Product
{
    /**
     * @var Product
     */
    private $product;

     /**
     * @var Discount
     */
    private $discount;

    /**
     * Discounted constructor.
     * @param Product $product
     * @param Discount $discount
     */
    public function __construct(Product $product, Discount $discount)
    {
        $this->product = $product;
        $this->discount = $discount;
    }

    public function getName(): string
    {
        return $this->product->getName() . ' DISCOUNTED!';
    }

    public function getPrice(): int
    {
        return $this->discount->calculatePrice($this->product->getPrice());
    }
}

class DiscountFactory
{
    public function create(string $type, float $value)
    {
        switch ($type) {
            case 'R':
                return new Ratio($value);
            case 'F':
                return new Fixed($value);
            default:
                throw new InvalidArgumentException();
        }
    }
}

$laptop = new StandardProduct('Laptop', 2500);
$mouse = new StandardProduct('Myszka', 50);
$pad = new StandardProduct('Podkladka', 10);

$cart = [
    $laptop,
    new Gift($mouse),
    new Discounted(new Combo('Zestaw #1', [$laptop, $mouse, new Gift($pad)]), 0.90),
];

/**
 * @var $product Product
 */
foreach ($cart as $product) {
    echo $product->getName() . ' ' . $product->getPrice() . PHP_EOL;
}

ProductsDiscount::getDiscountsForProduct($pId);