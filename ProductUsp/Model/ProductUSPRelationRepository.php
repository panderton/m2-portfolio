<?php

namespace <removed>\ProductUsp\Model;

use Exception;
use Magento\Framework\App\Config\BaseFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use <removed>\ProductUsp\Api\Data\ProductUSPRelationInterface;
use <removed>\ProductUsp\Api\ProductUSPRelationRepositoryInterface;
use <removed>\ProductUsp\Model\ProductUSP as USPModel;
use <removed>\ProductUsp\Model\ProductUSPRelation as ProductUSPRelationModel;
use <removed>\ProductUsp\Model\ProductUSPRelationFactory as ProductUSPRelationModelFactory;
use <removed>\ProductUsp\Model\ResourceModel\ProductUSP\Collection as USPCollection;
use <removed>\ProductUsp\Model\ResourceModel\ProductUSP\CollectionFactory as USPCollectionFactory;
use <removed>\ProductUsp\Model\ResourceModel\ProductUSPRelation as ProductUSPRelationResource;
use <removed>\ProductUsp\Model\ResourceModel\ProductUSPRelation\Collection as ProductUSPRelationCollection;
use <removed>\ProductUsp\Model\ResourceModel\ProductUSPRelation\CollectionFactory as ProductUSPRelationCollectionFactory;

/**
 * Class ProductUSPRelationRepository
 *
 * @package <removed>\ProductUsp\Model
 * @api
 */
class ProductUSPRelationRepository implements ProductUSPRelationRepositoryInterface
{
    /**
     * @var ProductUSPRelationResource
     */
    protected $resource;

    /**
     * @var ProductUSPRelationModelFactory|BaseFactory
     */
    private $productUspRelationModelFactory;

    /**
     * @var ProductUSPRelationCollectionFactory|BaseFactory
     */
    private $productUspRelationCollectionFactory;

    /**
     * @var USPCollectionFactory
     */
    private $uspCollectionFactory;

    /**
     * ProductUSPRelationRepository constructor
     *
     * @param ProductUSPRelationResource $resource
     * @param ProductUSPRelationModelFactory $productUspRelationModelFactory
     * @param ProductUSPRelationCollectionFactory $productUspRelationCollectionFactory
     * @param USPCollectionFactory $uspCollectionFactory
     */
    public function __construct(
        ProductUSPRelationResource $resource,
        ProductUSPRelationModelFactory $productUspRelationModelFactory,
        ProductUSPRelationCollectionFactory $productUspRelationCollectionFactory,
        USPCollectionFactory $uspCollectionFactory
    ) {
        $this->resource = $resource;
        $this->productUspRelationModelFactory = $productUspRelationModelFactory;
        $this->productUspRelationCollectionFactory = $productUspRelationCollectionFactory;
        $this->uspCollectionFactory = $uspCollectionFactory;
    }

    /**
     * @return ProductUSPRelation
     */
    public function newModel(): ProductUSPRelationModel
    {
        return $this->productUspRelationModelFactory->create();
    }

    /**
     * @return ProductUSPRelationCollection
     */
    public function newCollection(): ProductUSPRelationCollection
    {
        return $this->productUspRelationCollectionFactory->create();
    }

    /**
     * @param $uspId
     * @param $productId
     * @return ProductUSPRelation
     * @throws CouldNotSaveException
     */
    public function create($uspId, $productId): ProductUSPRelationModel
    {
        $productUspRelationModel = $this->newModel()
            ->setUspId($uspId)
            ->setProductId($productId);

        $this->save($productUspRelationModel);

        return $productUspRelationModel;
    }

    /**
     * @param ProductUSPRelationInterface $relation
     * @return ProductUSPRelationInterface
     * @throws CouldNotSaveException
     */
    public function save(ProductUSPRelationInterface $relation): ProductUSPRelationInterface
    {
        try {
            $this->resource->save($relation);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $relation;
    }

    /**
     * @param $productId
     * @return ProductUSPRelationCollection
     */
    public function getByProductId($productId): ProductUSPRelationCollection
    {
        return $this->newCollection()
            ->addFieldToFilter(
                ProductUSPRelationInterface::PRODUCT_ID,
                $productId
            );
    }

    /**
     * @param $uspId
     * @return ProductUSPRelationCollection
     */
    public function getByUspId($uspId): ProductUSPRelationCollection
    {
        return $this->newCollection()
            ->addFieldToFilter(
                ProductUSPRelationInterface::USP_ID,
                $uspId
            );
    }

    /**
     * @param ProductUSPRelationInterface $relation
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ProductUSPRelationInterface $relation): bool
    {
        try {
            $this->resource->delete($relation);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * @param $productId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteByProductId($productId): bool
    {
        try {
            $this->newCollection()
                ->addFieldToFilter(ProductUSPRelationInterface::PRODUCT_ID, $productId)
                ->walk('delete');

            return true;
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    /**
     * @param $uspId
     * @param $productId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById($uspId, $productId): bool
    {
        try {
            $this->newCollection()
                ->addFieldToFilter(ProductUSPRelationInterface::USP_ID, $uspId)
                ->addFieldToFilter(ProductUSPRelationInterface::PRODUCT_ID, $productId)
                ->walk('delete');

            return true;
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    /**
     * @param $uspIds
     * @param $productId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteByUspIds($uspIds, $productId = null): bool
    {
        try {
            $collection = $this->newCollection()
                ->addFieldToFilter(ProductUSPRelationInterface::USP_ID, $uspIds);

            if ($productId) {
                $collection->addFieldToFilter(ProductUSPRelationInterface::PRODUCT_ID, $productId);
            }

            $collection->walk('delete');

            return true;
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    /**
     * @param $productId
     * @return USPCollection
     */
    public function getRelatedUspsByProductId($productId): USPCollection
    {
        /** @var USPCollection $collection */
        $collection = $this->uspCollectionFactory->create();
        $tableName = $collection->getTable(ProductUSPRelationResource::TABLE_NAME);
        $collection
            ->addFieldToFilter(
                'cms_product_usp_relation.product_id',
                $productId
            )
            ->getSelect()
            ->joinLeft(
                ['cms_product_usp_relation' => $tableName],
                'main_table.usp_id = cms_product_usp_relation.usp_id'
            );

        return $collection;
    }

    /**
     * @param $productId
     * @return array|int[]
     */
    public function getRelatedUspIdsByProductId($productId): array
    {
        $collection = $this->getRelatedUspsByProductId($productId);

        $uspIds = [];
        foreach ($collection->getItems() as $usp) {
            /** @var USPModel $usp */
            $uspIds[] = $usp->getId();
        }

        return $uspIds;
    }
}