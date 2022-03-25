<?php

namespace Verfacto\Magento\Plugin\Module;

use Magento\Framework\Module\Status;
use Verfacto\Magento\Api\VerfactoRepositoryInterface;
use Verfacto\Magento\Model\ResourceModel\Verfacto\CollectionFactory as ViewCollectionFactory;
use Verfacto\Magento\Processor\RequestsProcessor;
use Verfacto\Magento\ViewModel\Link;

class DisableStatus
{
    /**
     * @var RequestsProcessor
     */
    private $requestsProcessor;

    /**
     * @var Link
     */
    private $link;

    /**
     * @var VerfactoRepositoryInterface
     */
    private $verfactoRepository;

    /**
     * @var ViewCollectionFactory
     */
    private $trackingCollectionFactory;

    /**
     * DisableStatus constructor.
     *
     * @param RequestsProcessor $requestsProcessor
     * @param Link $link
     * @param VerfactoRepositoryInterface $verfactoRepository
     * @param ViewCollectionFactory $trackingCollectionFactory
     */
    public function __construct(
        RequestsProcessor $requestsProcessor,
        Link $link,
        VerfactoRepositoryInterface $verfactoRepository,
        ViewCollectionFactory $trackingCollectionFactory
    ) {
        $this->requestsProcessor = $requestsProcessor;
        $this->link = $link;
        $this->verfactoRepository = $verfactoRepository;
        $this->trackingCollectionFactory = $trackingCollectionFactory;
    }

    /**
     * @param Status $subject
     * @param $result
     *
     * @return mixed
     */
    public function afterSetIsEnabled(Status $subject, $result)
    {
        $accountDetails = $this->link->getActiveAccount();
        if (is_array($accountDetails) && !empty($accountDetails)) {
            $tokenData = $this->requestsProcessor->signInAccount($accountDetails['name'], $accountDetails['password'], $accountDetails['email']);
            $this->requestsProcessor->disableModuleVerfacto($accountDetails['account_id'], $tokenData);

            /* Check if tracking id exists and enabled */
            $trackingCollection = $this->trackingCollectionFactory->create()
                ->addFieldToFilter('is_enabled', 1);
            foreach ($trackingCollection as $info) {
                $info->setIsEnabled(0);
                $info->save();
            }
        }
        return $result;
    }
}
