<?php

declare(strict_types=1);

namespace Verfacto\Magento\Api\Data;

/**
 * Interface VerfactoSearchResultInterface
 * @package Verfacto\Magento\Api\Data
 */
interface VerfactoSearchResultInterface
{
    /**
     * Get list with entities
     *
     * @return VerfactoInterface[]
     */
    public function getItems();

    /**
     * Set list with entities
     *
     * @param VerfactoInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
