<?php

declare(strict_types=1);

namespace Verfacto\Magento\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Verfacto\Magento\Api\Data\VerfactoInterface;
use Verfacto\Magento\Api\Data\VerfactoSearchResultInterface;
use Verfacto\Magento\Api\Data\VerfactoSearchResultInterfaceFactory;
use Verfacto\Magento\Api\VerfactoRepositoryInterface;
use Verfacto\Magento\Model\ResourceModel\Verfacto as VerfactoResource;
use Verfacto\Magento\Model\ResourceModel\Verfacto\CollectionFactory;
use Verfacto\Magento\Model\ResourceModel\VerfactoFactory as VerfactoResourceFactory;

/**
 * Class VerfactoRepository
 * @package Verfacto\Magento\Model
 */
class VerfactoRepository implements VerfactoRepositoryInterface
{
    /**
     * @var ManagerInterface
     */
    private $eventManager;

    /**
     * @var VerfactoInterface[]|array
     */
    private $cachedInstances = [];

    /**
     * @var VerfactoFactory
     */
    private $entityFactory;

    /**
     * @var CollectionFactory
     */
    private $entityCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var VerfactoSearchResultInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var VerfactoResourceFactory
     */
    private $entityResourceFactory;

    /**
     * @var VerfactoResource
     */
    private $verfactoResource;

    /**
     * VerfactoRepository constructor.
     *
     * @param ManagerInterface $eventManager
     * @param VerfactoFactory $entityFactory
     * @param CollectionFactory $entityCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param VerfactoSearchResultInterfaceFactory $searchResultsFactory
     * @param VerfactoResourceFactory $entityResourceFactory
     * @param VerfactoResource $verfactoResource
     */
    public function __construct(
        ManagerInterface $eventManager,
        VerfactoFactory $entityFactory,
        CollectionFactory $entityCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        VerfactoSearchResultInterfaceFactory $searchResultsFactory,
        VerfactoResourceFactory $entityResourceFactory,
        VerfactoResource $verfactoResource
    ) {
        $this->eventManager = $eventManager;
        $this->entityFactory = $entityFactory;
        $this->entityCollectionFactory = $entityCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->entityResourceFactory = $entityResourceFactory;
        $this->verfactoResource = $verfactoResource;
    }

    /**
     * @inheritDoc
     */
    public function save(VerfactoInterface $entity): VerfactoInterface
    {
        try {
            $this->entityResourceFactory->create()->save($entity);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): VerfactoInterface
    {
        if (!isset($this->cachedInstances[$id])) {
            $this->cachedInstances[$id] = $this->loadEntity(VerfactoInterface::ID, $id);
        }

        return $this->cachedInstances[$id];
    }

    /**
     * @inheritDoc
     */
    public function delete(VerfactoInterface $entity): bool
    {
        $this->entityResourceFactory->create()->delete($entity);
        if (isset($this->cachedInstances[$entity->getId()])) {
            unset($this->cachedInstances[$entity->getId()]);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): bool
    {
        $entity = $this->getById($id);

        return $this->delete($entity);
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): VerfactoSearchResultInterface
    {
        $collection = $this->entityCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Start resource transaction
     *
     * @inheritDoc
     */
    public function beginTransaction()
    {
        $this->verfactoResource->beginTransaction();
    }

    /**
     * Commit resource transaction
     */
    public function commit()
    {
        $this->verfactoResource->commit();
    }

    /**
     * Roll back resource transaction
     */
    public function rollBack()
    {
        $this->verfactoResource->rollBack();
    }

    /**
     * Load entity by field value
     *
     * @param string $field
     * @param string|int $value
     * @return VerfactoInterface|null
     * @throws NoSuchEntityException
     */
    private function loadEntity(string $field, $value): ?VerfactoInterface
    {
        $entity = $this->entityFactory->create();
        $entityResource = $this->entityResourceFactory->create();
        $entityResource->load($entity, $value, $field);
        if ($id = $entity->getId()) {
            $this->cachedInstances[$id] = $entity;

            return $entity;
        }

        throw NoSuchEntityException::singleField($field, $id);
    }
}
