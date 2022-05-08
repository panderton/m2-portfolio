<?php
namespace <removed>\ProductUsp\Model;

use <removed>\ProductUsp\Api\ProductUSPRepositoryInterface;
use <removed>\ProductUsp\Api\Data;
use <removed>\ProductUsp\Model\ResourceModel\ProductUSP as ResourceProductUSP;
use <removed>\ProductUsp\Model\ResourceModel\ProductUSP\CollectionFactory as ProductUSPCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ProductUSPRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ProductUSPRepository implements ProductUSPRepositoryInterface
{
    /**
     * @var ResourceProductUSP
     */
    protected $resource;

    /**
     * @var ProductUSPFactory
     */
    protected $productUSPFactory;

    /**
     * @var ProductUSPCollectionFactory
     */
    protected $productUSPCollectionFactory;

    /**
     * @var Data\ProductUSPSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \<removed>\ProductUsp\Api\Data\ProductUSPInterfaceFactory
     */
    protected $dataProductUSPFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourceProductUSP $resource
     * @param ProductUSPFactory $productUSPFactory
     * @param Data\ProductUSPInterfaceFactory $dataProductUSPFactory
     * @param ProductUSPCollectionFactory $productUSPCollectionFactory
     * @param Data\ProductUSPSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceProductUSP $resource,
        ProductUSPFactory $productUSPFactory,
        \<removed>\ProductUsp\Api\Data\ProductUSPInterfaceFactory $dataProductUSPFactory,
        ProductUSPCollectionFactory $productUSPCollectionFactory,
        Data\ProductUSPSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->productUSPFactory = $productUSPFactory;
        $this->productUSPCollectionFactory = $productUSPCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataProductUSPFactory = $dataProductUSPFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
    }

    /**
     * Save ProductUSP data
     *
     * @param \<removed>\ProductUsp\Api\Data\ProductUSPInterface $productUSP
     * @return ProductUSP
     * @throws CouldNotSaveException
     */
    public function save(Data\ProductUSPInterface $productUSP)
    {
        if (empty($productUSP->getStoreId())) {
            $productUSP->setStoreId($this->storeManager->getStore()->getId());
        }

        try {
            $this->resource->save($productUSP);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $productUSP;
    }

    /**
     * Load ProductUSP data by given ProductUSP Identity
     *
     * @param string $productUSPId
     * @return ProductUSP
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($productUSPId)
    {
        $productUSP = $this->productUSPFactory->create();
        $this->resource->load($productUSP, $productUSPId);
        if (!$productUSP->getId()) {
            throw new NoSuchEntityException(__('The CMS productUSP with the "%1" ID doesn\'t exist.', $productUSPId));
        }
        return $productUSP;
    }

    /**
     * It creates a collection of ProductUSP objects, processes the search criteria, and returns the results
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \<removed>\ProductUsp\Api\Data\ProductUSPSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \<removed>\ProductUsp\Model\ResourceModel\ProductUSP\Collection $collection */
        $collection = $this->productUSPCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var Data\ProductUSPSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete ProductUSP
     *
     * @param \<removed>\ProductUsp\Api\Data\ProductUSPInterface $productUSP
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\ProductUSPInterface $productUSP)
    {
        try {
            $this->resource->delete($productUSP);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete ProductUSP by given ProductUSP Identity
     *
     * @param string $productUSPId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($productUSPId)
    {
        return $this->delete($this->getById($productUSPId));
    }

    /**
     * Retrieve collection processor
     *
     * @deprecated 102.0.0
     * @return CollectionProcessorInterface
     */
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                '<removed>\ProductUsp\Model\Api\SearchCriteria\ProductUSPCollectionProcessor'
            );
        }
        return $this->collectionProcessor;
    }
}