<?php
namespace App\Csv;

interface ProductCsvInterface {
    /**
     * @return string
     */
    public function getContent(): string;
}