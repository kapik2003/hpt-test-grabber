<?php

declare(strict_types=1);

interface ILoader {
    /**
     * @param string $productId
     * @return string
     */
    public function getDocument(string $productId): string;
}