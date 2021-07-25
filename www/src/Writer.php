<?php

declare(strict_types=1);

namespace App;

class Writer implements \IWriter {
    /** @var \DOMDocument  */
    private $document = null;

    /**
     * @param string $document
     * @throws CustomException
     */
    public function setDocument(string $document): void {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $document = $dom->loadHTML($document);

        if($document === false) {
            throw new CustomException('Document not loaded');
        }
        $this->document = $dom;
    }

    /**
     * @param string $productId
     * @return string|null
     */
    public function getName(string $productId): ?string {
        try {
            $result = $this->getTitle($productId);
            $dataEncoded = $this->parseAnalyticsData($result);

            if (array_key_exists('name', $dataEncoded)) {
                return $dataEncoded['name'];
            }
        } catch (CustomException $exception) {
            error_log($exception->getMessage());
        }

        return null;
    }

    /**
     * @param string $productId
     * @return \DOMNode
     * @throws CustomException
     */
    public function getTitle(string $productId): \DOMNode {
        $xpath = new \DOMXPath($this->document);
        $filtered = $xpath->query("//div[@class='new-tile']");

        if ($filtered->length === 0) {
            throw new CustomException(sprintf('Product %s not found on result page.', $productId));
        }

        return $filtered->item(0);
    }

    /**
     * @param string $productId
     * @return float
     * @throws CustomException
     */
    public function getPrice(string $productId): float {
        $result = $this->getTitle($productId);
        $dataEncoded = $this->parseAnalyticsData($result);

        if (array_key_exists('price', $dataEncoded)) {
            return (float) $dataEncoded['price'];
        }

        throw new CustomException(sprintf('Price for product %s not found.', $productId));
    }

    /**
     * @param string $productId
     * @return int|null
     */
    public function getRating(string $productId): ?int {
        $xpath = new \DOMXPath($this->document);
        $filtered = $xpath->query("//div[@class='new-tile'][1]//span[@class='rating']");

        if ($filtered->length === 0) {
            return null;
        }

        $title = $filtered->item(0)->attributes->getNamedItem("title")->nodeValue;

        $matches = [];
        preg_match('/(\d+) %/', $title, $matches);

        if (count($matches) === 2) {
            return (int) $matches[1];
        }

        return null;
    }

    /**
     * @param \DOMNode $element
     * @return array
     */
    private function parseAnalyticsData(\DOMNode $element): array {
        $dataEncoded = $element->attributes->getNamedItem('data-ga-impression')->nodeValue;
        return json_decode($dataEncoded, true);
    }
}