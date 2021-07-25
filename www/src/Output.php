<?php

declare(strict_types=1);

namespace App;

class Output implements \IOutput {
    /** @var array */
    private $data = [];

    const PRODUCT_NAME = 'name';
    const PRODUCT_PRICE = 'price';
    const PRODUCT_RATING = 'score';

    /**
     * @param string $productId
     * @param string|null $name
     * @param float|null $price
     * @param int|null $rating
     */
    public function addResult(string $productId, ?string $name, ?float $price, ?int $rating): void {
        $this->data[$productId][self::PRODUCT_NAME] = $name;
        $this->data[$productId][self::PRODUCT_PRICE] = $price;
        $this->data[$productId][self::PRODUCT_RATING] = $rating;
    }

    /**
     * @return string
     */
    public function getJson(): string {
        return json_encode($this->data);
    }
}