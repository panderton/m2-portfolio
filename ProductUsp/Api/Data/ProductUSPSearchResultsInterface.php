<?php

namespace <removed>\ProductUsp\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for cms product usp search results.
 * @api
 */
interface ProductUSPSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get product usps list.
     *
     * @return \<removed>\ProductUsp\Api\Data\ProductUSPInterface[]
     */
    public function getItems();

    /**
     * Set product usps list.
     *
     * @param \<removed>\ProductUsp\Api\Data\ProductUSPInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}