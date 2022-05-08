<?php

namespace <removed>\ProductUsp\Api;

/**
 * Command to load the product_usp data by specified identifier
 * @api
 */
interface GetProductUSPByIdentifierInterface
{
    /**
     * Load product_usp data by given product_usp identifier.
     *
     * @param string $identifier
     * @param int $storeId
     * @return \<removed>\ProductUsp\Api\Data\ProductUSPInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @since 103.0.0
     */
    public function execute(string $identifier, int $storeId) : \<removed>\ProductUsp\Api\Data\ProductUSPInterface;
}