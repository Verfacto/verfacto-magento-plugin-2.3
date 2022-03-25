<?php

declare(strict_types=1);

namespace Verfacto\Magento\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Verfacto\Magento\Api\Data\VerfactoInterface;
use Verfacto\Magento\Model\ResourceModel\Verfacto\CollectionFactory as ViewCollectionFactory;

class Link implements ArgumentInterface
{
    /**
     * @var ViewCollectionFactory
     */
    private $viewCollectionFactory;

    /**
     * Constructor
     *
     * @param ViewCollectionFactory $viewCollectionFactory
     */
    public function __construct(
        ViewCollectionFactory $viewCollectionFactory
    ) {
        $this->viewCollectionFactory  = $viewCollectionFactory;
    }

    /**
     * For a script, returns its tracking id
     *
     * @return string|null
     */
    public function getTrackingId(): ?string
    {
        return $this->viewCollectionFactory->create()
            ->addFieldToFilter(VerfactoInterface::IS_ENABLED, 1)
            ->getFirstItem()
            ->getData(VerfactoInterface::TRACKING_ID);
    }

    /**
     * For a script, returns its account
     *
     * @return array|null
     */
    public function getActiveAccount(): ?array
    {
        return $this->viewCollectionFactory->create()
            ->addFieldToFilter(VerfactoInterface::IS_ENABLED, 1)
            ->getFirstItem()
            ->getData();
    }
}
