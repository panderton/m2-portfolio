<?php

namespace <removed>\ProductUsp\Api;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use <removed>\ProductUsp\Api\Data\ProductUSPRelationInterface;
use <removed>\ProductUsp\Model\ProductUSPRelation as ProductUSPRelationModel;
use <removed>\ProductUsp\Model\ResourceModel\ProductUSP\Collection as USPCollection;
use <removed>\ProductUsp\Model\ResourceModel\ProductUSPRelation\Collection as ProductUSPRelationCollection;

/**
 * Interface ProductUSPRelationRepositoryInterface
 *
 * @package WalterWoshid\CustomUSP
 * @api
 */
interface ProductUSPRelationRepositoryInterface
{
    /**
     * Creates a new empty model
     *
     * @return ProductUSPRelationModel
     */
    public function newModel(): ProductUSPRelationModel;

    /**
     * Creates a new empty collection
     *
     * @return ProductUSPRelationCollection
     */
    public function newCollection(): ProductUSPRelationCollection;

    /**
     * Create new relation
     *
     * @param $uspId
     * @param $productId
     * @return ProductUSPRelationModel
     * @throws CouldNotSaveException
     */
    public function create($uspId, $productId): ProductUSPRelationModel;

    /**
     * Save relation
     *
     * @param ProductUSPRelationInterface $relation
     * @return ProductUSPRelationInterface
     * @throws CouldNotSaveException
     */
    public function save(ProductUSPRelationInterface $relation): ProductUSPRelationInterface;

    /**
     * Retrieve relations by product ID
     *
     * @param $productId
     * @return ProductUSPRelationCollection
     */
    public function getByProductId($productId): ProductUSPRelationCollection;

    /**
     * Retrieve relations by USP ID
     *
     * @param $uspId
     * @return ProductUSPRelationCollection
     */
    public function getByUspId($uspId): ProductUSPRelationCollection;

    /**
     * Delete relation
     *
     * @param ProductUSPRelationInterface $relation
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ProductUSPRelationInterface $relation): bool;

    /**
     * Delete relations by product id
     *
     * @param $productId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteByProductId($productId): bool;

    /**
     * Delete relations by id
     *
     * @param $uspId
     * @param $productId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById($uspId, $productId): bool;

    /**
     * Delete relations by USP ids with optional product id
     *
     * @param $uspIds
     * @param $productId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteByUspIds($uspIds, $productId = null): bool;

    /**
     * Get related USPs by product id
     *
     * @param $productId
     * @return USPCollection
     */
    public function getRelatedUspsByProductId($productId): USPCollection;

    /**
     * Get related USP ids by product id
     *
     * @param $productId
     * @return int[]
     */
    public function getRelatedUspIdsByProductId($productId): array;
}