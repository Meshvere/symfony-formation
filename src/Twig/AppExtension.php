<?php
declare(strict_types=1);
namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
final class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('product_price', [$this, 'convertProductPrice']),
        ];
    }
    public function convertProductPrice(int $price): float
    {
        return $price / 100;
    }
}