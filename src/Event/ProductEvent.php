<?php


namespace App\Event;


use App\Entity\Product;
use Symfony\Contracts\EventDispatcher\Event;

class ProductEvent extends Event
{

    /** @var Product */
    private $product;

    /**
     * ProductEvent constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
}