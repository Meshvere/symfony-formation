<?php
namespace App\Csv;

use App\Entity\Product;

interface ProductCsvGeneratorInterface {
    /** @param Product[] $product */
    public function generate(array $products): ProductCsvInterface;
}