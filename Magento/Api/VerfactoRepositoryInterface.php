<?php

declare(strict_types=1);

namespace Verfacto\Magento\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Verfacto\Magento\Api\Data\VerfactoInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Verfacto\Magento\Api\Data\VerfactoSearchResultInterface;

/**
 * Interface VerfactoRepositoryInterface
 * @package Verfacto\Magento\Api
 */
interface VerfactoRepositoryInterface
{
    /**
     * Save entity
     *
     * @param VerfactoInterface $entity
     * @return VerfactoInterface
     * @throws CouldNotSaveException
     */
    public function save(VerfactoInterface $entity);

    /**
     * Get entity by id
     *
     * @param int $id
     * @return VerfactoInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id);

    /**
     * Delete entity
     *
     * @param VerfactoInterface $entity
     * @return bool
     * @throws LocalizedException
     */
    public function delete(VerfactoInterface $entity);

    /**
     * Delete entity by id
     *
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $id);

    /**
     * Retrieve entities by search criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return VerfactoSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Start resource transaction
     */
    public function beginTransaction();

    /**
     * Commit resource transaction
     */
    public function commit();

    /**
     * Roll back resource transaction
     */
    public function rollBack();
}
