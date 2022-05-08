<?php

namespace <removed>\ProductUsp\Api;

/**
 * CMS Product USP CRUD interface.
 * @api
 */
interface ProductUSPRepositoryInterface
{
    /**
     * Save product usp.
     *
     * @param \<removed>\ProductUsp\Api\Data\ProductUSPInterface $productUSP
     * @return \<removed>\ProductUsp\Api\Data\ProductUSPInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\ProductUSPInterface $productUSP);

    /**
     * Retrieve productUSP.
     *
     * @param int $productUSPId
     * @return \<removed>\ProductUsp\Api\Data\ProductUSPInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($productUSPId);

    /**
     * Retrieve productUSPs matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \<removed>\ProductUsp\Api\Data\ProductUSPSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete productUSP.
     *
     * @param \<removed>\ProductUsp\Api\Data\ProductUSPInterface $productUSP
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\ProductUSPInterface $productUSP);

    /**
     * Delete productUSP by ID.
     *
     * @param int $productUSPId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($productUSPId);
}