<?php

declare(strict_types=1);

interface IOutput {

    /**
     * @param string $productId
     * @param string|null $name
     * @param float|null $price
     * @param int|null $rating
     */
    public function addResult(string $productId, ?string $name, ?float $price, ?int $rating): void;

    /**
     * @return string
     */
    public function getJson(): string;
}