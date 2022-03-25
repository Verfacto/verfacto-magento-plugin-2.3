<?php

declare(strict_types=1);

namespace Verfacto\Magento\Processor;

use Exception;
use Magento\Framework\App\Cache\Manager as CacheManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;
use Verfacto\Magento\Api\VerfactoManagerInterface;
use Verfacto\Magento\Provider\TokenModelProvider;
use Verfacto\Magento\Api\VerfactoRepositoryInterface;

class IntegrationProcessor
{
    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var UrlInterface
     */
    private $urlInterface;

    /**
     * @var VerfactoManagerInterface
     */
    private $verfactoManager;

    /**
     * @var RequestsProcessor
     */
    private $requestsProcessor;

    /**
     * @var TokenModelProvider
     */
    private $tokenModelProvider;

    /**
     * @var VerfactoRepositoryInterface
     */
    private $verfactoRepository;

    /**
     * IntegrationProcessor constructor.
     *
     * @param CacheManager $cacheManager
     * @param UrlInterface $urlInterface
     * @param VerfactoManagerInterface $verfactoManager
     * @param RequestsProcessor $requestsProcessor
     * @param TokenModelProvider $tokenModelProvider
     * @param VerfactoRepositoryInterface $verfactoRepository
     */
    public function __construct(
        CacheManager $cacheManager,
        UrlInterface $urlInterface,
        VerfactoManagerInterface $verfactoManager,
        RequestsProcessor $requestsProcessor,
        TokenModelProvider $tokenModelProvider,
        VerfactoRepositoryInterface $verfactoRepository
    ) {
        $this->cacheManager = $cacheManager;
        $this->urlInterface = $urlInterface;
        $this->verfactoManager = $verfactoManager;
        $this->requestsProcessor = $requestsProcessor;
        $this->tokenModelProvider = $tokenModelProvider;
        $this->verfactoRepository = $verfactoRepository;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @throws LocalizedException
     */
    public function process(string $name, string $email, string $password): void
    {
        try {
            $shopUrl = $this->urlInterface->getBaseUrl();
            $integrationData = [
                'name'              => $name,
                'email'             => $email,
                'status'            => '1',
                'setup_type'        => '0',
                'endpoint'      => $shopUrl,
                'identity_link_url' => $shopUrl
            ];
            $this->verfactoRepository->beginTransaction();
            $tokenModel = $this->tokenModelProvider->provideAccessToken($integrationData);
            $consulerTokenModel = $this->tokenModelProvider->provideConsumerToken($tokenModel->getConsumerId());
            $verfactoInfo = $this->requestsProcessor->getTrackingData(
                $name,
                $password,
                $email,
                $consulerTokenModel->getKey(),
                $consulerTokenModel->getSecret(),
                $tokenModel->getToken(),
                $tokenModel->getSecret(),
                rtrim($shopUrl, '/')
            );
            $this->verfactoManager->addTrackingInfo($tokenModel, $verfactoInfo, $name, $password, $email);
            $this->verfactoRepository->commit();
            $availableCacheTypes = $this->cacheManager->getAvailableTypes();
            $this->cacheManager->clean($availableCacheTypes);
        } catch (Exception $exception) {
            $this->verfactoRepository->rollBack();
            throw new LocalizedException($exception);
        }
    }
}
