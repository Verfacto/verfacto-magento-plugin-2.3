<?php

declare(strict_types=1);

namespace Verfacto\Magento\Model;

use Exception;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Integration\Model\Oauth\Token;
use Verfacto\Magento\Api\Data\VerfactoInterfaceFactory;
use Verfacto\Magento\Api\VerfactoManagerInterface;
use Verfacto\Magento\Api\VerfactoRepositoryInterface;
use Verfacto\Magento\Model\ResourceModel\Verfacto\CollectionFactory as ViewCollectionFactory;

/**
 * Class VerfactoManager
 * @package Verfacto\Magento\Model
 */
class VerfactoManager implements VerfactoManagerInterface
{
    /**
     * @var VerfactoInterfaceFactory
     */
    private $verfactoModelFactory;

    /**
     * @var VerfactoRepositoryInterface
     */
    private $verfactoRepository;

    /**
     * @var ViewCollectionFactory
     */
    private $trackingCollectionFactory;

    /**
     * VerfactoManager constructor.
     *
     * @param VerfactoInterfaceFactory $verfactoModelFactory
     * @param VerfactoRepositoryInterface $verfactoRepository
     * @param ViewCollectionFactory $trackingCollectionFactory
     */
    public function __construct(
        VerfactoInterfaceFactory $verfactoModelFactory,
        VerfactoRepositoryInterface $verfactoRepository,
        ViewCollectionFactory $trackingCollectionFactory
    ) {
        $this->verfactoModelFactory = $verfactoModelFactory;
        $this->verfactoRepository = $verfactoRepository;
        $this->trackingCollectionFactory = $trackingCollectionFactory;
    }

    /**
     * @param Token $tokenModel
     * @param array $verfactoInfo
     * @param string $name
     * @param string $password
     * @param string $email
     * @return bool
     * @throws CouldNotSaveException
     */
    public function addTrackingInfo(Token $tokenModel, array $verfactoInfo, string $name, string $password, string $email): bool
    {
        if (is_array($verfactoInfo) &&
            !empty($verfactoInfo) &&
            isset($verfactoInfo["account_id"]) &&
            isset($verfactoInfo["tracking_id"])
        ) {
            /* Check if tracking id exists and enabled */
            $trackingCollection = $this->trackingCollectionFactory->create()
                ->addFieldToFilter('is_enabled', 1);
            foreach ($trackingCollection as $info) {
                $info->setIsEnabled(0);
                $info->save();
            }
            $verfactoRecord = $this->verfactoModelFactory->create();
            $verfactoRecord->setConsumerId((int)$tokenModel->getConsumerId())
                ->setToken($tokenModel->getToken())
                ->setTokenSecret($tokenModel->getSecret())
                ->setEmail($email)
                ->setName($name)
                ->setPassword($password)
                ->setAccountId((int)$verfactoInfo["account_id"])
                ->setIsEnabled(1)
                ->setTrackingId($verfactoInfo["tracking_id"]);

            $this->verfactoRepository->save($verfactoRecord);
        } else {
            throw new Exception($verfactoInfo['message']);
        }

        return true;
    }
}
