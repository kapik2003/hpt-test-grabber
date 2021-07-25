<?php

declare(strict_types=1);

interface IWriter {
    /**
     * @param string $document
     */
    public function setDocument(string $document): void;

    /**
     * @param string $productId
     * @return string|null
     */
    public function getName(string $productId): ?string;

    /**
     * @param string $productId
     * @return float
     */
    public function getPrice(string $productId): float;

    /**
     * @param string $productId
     * @return int|null
     */
    public function getRating(string $productId): ?int;
}