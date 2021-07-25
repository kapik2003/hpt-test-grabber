<?php

declare(strict_types=1);

namespace App;

class Dispatcher {
    /** @var ILoader */
    private $loader;

    /** @var IWriter */
    private $writer;

    /** @var IOutput */
    private $output;

    /** @var string */
    private $filePath;

    /**
     * Dispatcher constructor.
     * @param \ILoader $loader
     * @param \IWriter $writer
     * @param \IOutput $output
     */
    public function __construct(\ILoader $loader, \IWriter $writer, \IOutput  $output) {
        $this->loader = $loader;
        $this->writer = $writer;
        $this->output = $output;
    }

    /**
     * @return string
     */
    public function run(): string {
        $productIds = $this->loadProductFromSourceFile();
        foreach ($productIds as $productId) {
            try {
                $productId = trim($productId);
                $document = $this->loader->getDocument($productId);
                $this->writer->setDocument($document);
                $this->output->addResult(
                    $productId,
                    $this->writer->getName($productId),
                    $this->writer->getPrice($productId),
                    $this->writer->getRating($productId)
                );
            } catch (CustomException $exception) {
                $this->output->addResult($productId, null, null, null);
            }
        }

        return $this->output->getJson();
    }

    /**
     * @return array|null
     */
    public function loadProductFromSourceFile(): ?array {
        $results = [];

        try {
            $file = new \SplFileObject($this->filePath, 'r');
            while (!$file->eof()) {
                $results[] = $file->fgets();
            }
        } catch(RuntimeException $exception) {
            return null;
        }

        return $results;
    }

    /**
     * @param string $path
     */
    public function loadConfigFile(string $path) {
        $this->filePath = $path;
    }
}
