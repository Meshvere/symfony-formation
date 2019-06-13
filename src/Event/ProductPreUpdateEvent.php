<?php


namespace App\Event;

class ProductPreUpdateEvent extends ProductEvent
{
    public const NAME = 'product.pre_update';
}