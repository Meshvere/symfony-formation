<?php


namespace App\Csv;


class ProductCsv implements ProductCsvInterface
{
    /** @var string */
    private $content;

    /**
     * ProductCsv constructor.
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }
    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}