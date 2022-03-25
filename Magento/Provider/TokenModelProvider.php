<?php

declare(strict_types=1);

namespace Verfacto\Magento\Provider;

use Exception;
use Magento\Integration\Api\AuthorizationServiceInterface;
use Magento\Integration\Api\IntegrationServiceInterface;
use Magento\Integration\Api\OauthServiceInterface;
use Magento\Integration\Model\Oauth\Token;
use Magento\Integration\Model\Oauth\ConsumerFactory;
use Magento\Integration\Model\Oauth\Consumer;

class TokenModelProvider
{
    /**
     * @var OauthServiceInterface
     */
    private $oauthService;

    /**
     * @var IntegrationServiceInterface
     */
    private $integrationService;

    /**
     * @var AuthorizationServiceInterface
     */
    private $authorizationService;

    /**
     * @var ConsumerFactory
     */
    private $consumerFactory;

    /**
     * TokenModelProvider constructor.
     *
     * @param OauthServiceInterface $oauthService
     * @param AuthorizationServiceInterface $authorizationService
     * @param IntegrationServiceInterface $integrationService
     * @param ConsumerFactory $consumerFactory
     */
    public function __construct(
        OauthServiceInterface $oauthService,
        AuthorizationServiceInterface $authorizationService,
        IntegrationServiceInterface $integrationService,
        ConsumerFactory $consumerFactory
    ) {
        $this->oauthService = $oauthService;
        $this->authorizationService = $authorizationService;
        $this->integrationService = $integrationService;
        $this->consumerFactory = $consumerFactory;
    }

    /**
     * @param array $integrationData
     * @return Token
     * @throws Exception
     */
    public function provideAccessToken(array $integrationData): Token
    {
        $existIntegration = $this->integrationService->findByName($integrationData['name']);
        if (is_array($existIntegration->getData()) && !empty($existIntegration->getData())) {
            $this->integrationService->delete($existIntegration->getId());
        }
        $integration = $this->integrationService->create($integrationData);
        $consumerId = $integration->getConsumerId();
        $this->authorizationService->grantAllPermissions($integration->getId());
        $this->oauthService->createAccessToken($consumerId);
        $tokenModel = $this->oauthService->getAccessToken($consumerId);
        if (empty($tokenModel->getData())) {
            throw new Exception('Access Token is not getting');
        }

        return $tokenModel;
    }


    /**
     * @param $consumerId
     * @return Consumer
     * @throws Exception
     */
    public function provideConsumerToken($consumerId): Consumer
    {
        $consumer = $this->consumerFactory->create()->load($consumerId);
        if (!$consumer->getId()) {
            throw new Exception('Consumer Token is not getting');
        }

        return $consumer;
    }
}
