<?php

declare(strict_types=1);

namespace App;

class Loader implements \ILoader {
    const SEARCH_PATTERN = 'https://www.czc.cz/%s/hledat';

    /**
     * @param string $productId
     * @return string
     * @throws CustomException
     */
    public function getDocument(string $productId): string {
        $curl = new CurlClient($this->generateUrlAddress($productId), false);
        $content = $curl->load();

        if($content === false) {
            throw new CustomException(sprintf('Product %s was not loaded', $productId));
        }

        return $content;
    }

    /**
     * @param $productId
     * @return string
     */
    private function generateUrlAddress($productId): string {
        return sprintf(self::SEARCH_PATTERN, $productId);
    }
}