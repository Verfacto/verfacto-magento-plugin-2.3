<?php

declare(strict_types=1);

namespace Verfacto\Magento\ViewModel;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Integration\Api\OauthServiceInterface;
use Verfacto\Magento\Api\Data\MetaDataInterface;
use Verfacto\Magento\Api\VerfactoRepositoryInterface;
use Verfacto\Magento\Processor\GenerateProcessor;

class Verfacto implements ArgumentInterface
{
    /**
     * Url Builder
     *
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var VerfactoRepositoryInterface
     */
    private $verfactoRepository;

    /**
     * @var OauthServiceInterface
     */
    private $oauthService;

    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteria;

    /**
     * @var SearchCriteriaBuilder
     */
    private $criteriaBuilder;

    /**
     * @var GenerateProcessor
     */
    private $generateProcessor;

    /**
     * Verfacto constructor.
     *
     * @param UrlInterface $urlBuilder
     * @param VerfactoRepositoryInterface $verfactoRepository
     * @param OauthServiceInterface $oauthService
     * @param SearchCriteriaInterface $searchCriteria
     * @param SearchCriteriaBuilder $criteriaBuilder
     * @param GenerateProcessor $generateProcessor
     */
    public function __construct(
        UrlInterface $urlBuilder,
        VerfactoRepositoryInterface $verfactoRepository,
        OauthServiceInterface $oauthService,
        SearchCriteriaInterface $searchCriteria,
        SearchCriteriaBuilder $criteriaBuilder,
        GenerateProcessor $generateProcessor
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->verfactoRepository = $verfactoRepository;
        $this->oauthService = $oauthService;
        $this->searchCriteria = $searchCriteria;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->generateProcessor = $generateProcessor;
    }

    /**
     * @return string
     */
    public function getActionUrl(): string
    {
        return $this->urlBuilder->getRouteUrl(MetaDataInterface::ACTION_URL);
    }

    /**
     * @return string
     */
    public function getModuleUrl(): string
    {
        return $this->urlBuilder->getCurrentUrl();
    }

    /**
     * @return bool
     */
    public function checkIntegration(): bool
    {
        $searchCriteria = $this->createSearchCriteria();
        $result = $this->verfactoRepository->getList($searchCriteria);
        $items = $result->getItems();
        if (is_array($items) && !empty($items)) {
            foreach ($items as $item) {
                $token = $item->getToken();
                $tokenSecret = $item->getTokenSecret();
                $consumerId = $item->getConsumerId();
            }
            if (isset($consumerId)) {
                $oauthData = $this->oauthService->getAccessToken($consumerId);
                if (isset($oauthData) &&
                    !empty($oauthData) &&
                    isset($token) &&
                    !empty($token) &&
                    isset($tokenSecret) &&
                    !empty($tokenSecret)) {
                    if ($token == $oauthData->getToken() && $tokenSecret == $oauthData->getSecret()) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Create search criteria for verfacto
     *
     * @return SearchCriteriaInterface
     */
    private function createSearchCriteria(): SearchCriteriaInterface
    {
        $searchCriteria = $this->criteriaBuilder
            ->addFilter('is_enabled', 1, 'eq');

        return $searchCriteria->create();
    }

    /**
     * @return string
     */
    public function getAccountName(): string
    {
        return $this->generateProcessor->buildName($this->urlBuilder->getBaseUrl());
    }
}
