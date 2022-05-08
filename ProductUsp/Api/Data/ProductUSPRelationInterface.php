<?php

namespace <removed>\ProductUsp\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface ProductUSPRelationInterface
 *
 * @package <removed>\ProductUsp\Api\Data
 * @api
 */
interface ProductUSPRelationInterface extends ExtensibleDataInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const RELATION_ID = 'relation_id';
    const PRODUCT_ID  = 'product_id';
    const USP_ID      = 'usp_id';

    /**
     * Get relation ID
     *
     * @return mixed
     */
    public function getId();

    /**
     * Set relation ID
     *
     * @param $value
     * @return $this
     */
    public function setId($value): self;

    /**
     * Get product ID
     *
     * @return int
     */
    public function getProductId(): int;

    /**
     * Set product ID
     *
     * @param $productId
     * @return $this
     */
    public function setProductId($productId): self;

    /**
     * Get usp ID
     *
     * @return int
     */
    public function getUspId(): int;

    /**
     * Set usp ID
     *
     * @param $uspId
     * @return $this
     */
    public function setUspId($uspId): self;
}