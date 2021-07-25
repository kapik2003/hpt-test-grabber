<?php

declare(strict_types=1);

namespace App;

class CurlClient {

    /** @var string */
    private $url;

    /** @var bool */
    private $secure;

    /** @var string */
    private $result;

    /** @var integer */
    private $code;

    public function __construct(string $url, bool $secure = false) {
        $this->setUrl($url);
        $this->setSecure($secure);
        $this->setCode(400);
    }

    public function load() {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->getUrl());
            curl_setopt($curl, CURLOPT_TIMEOUT, 300);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_VERBOSE, false);

            if ($this->getSecure()) {
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            }

            $this->setResult(curl_exec($curl));
            $this->setCode(curl_getinfo($curl, CURLINFO_HTTP_CODE));
            curl_close($curl);

            return $this->getResult();
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url) {
        $this->url = $url;
    }

    public function setSecure(bool $secure) {
        $this->secure = $secure;
    }

    /**
     * @param string|null $content
     */
    public function setResult(?string $content) {
        $this->result = $content;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code) {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string {
        return $this->url;
    }

    /**
     * @return bool|null
     */
    public function getSecure(): ?bool {
        return $this->secure;
    }

    /**
     * @return string|null
     */
    public function getResult(): ?string {
        return $this->result;
    }

    /**
     * @return integer|null
     */
    public function getCode(): ?integer {
        return $this->code;
    }
}