<?php

declare(strict_types=1);

namespace Verfacto\Magento\Processor;

use Magento\Framework\UrlInterface;

class GenerateProcessor
{
    /**
     * @var UrlInterface
     */
    private $urlInterface;

    /**
     * GenerateProcessor constructor.
     *
     * @param UrlInterface $urlInterface
     */
    public function __construct(
        UrlInterface $urlInterface
    ) {
        $this->urlInterface = $urlInterface;
    }

    /**
     * Build name from url.
     *
     * @return string
     */
    public function buildName(): string
    {
        $shopUrl = $this->urlInterface->getBaseUrl();
        $url = explode('//', $shopUrl);
        $name = str_replace('/', '', $url[1]);
        $name = str_replace('www', '', $name);
        $name = str_replace('.', '-', $name);

        return $name;
    }
}
