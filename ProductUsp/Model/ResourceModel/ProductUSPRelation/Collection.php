<?php

namespace <removed>\ProductUsp\Model\ResourceModel\ProductUSPRelation;

use Magento\Cms\Model\ResourceModel\AbstractCollection;
use <removed>\ProductUsp\Model\ProductUSPRelation as ProductUSPRelationModel;
use <removed>\ProductUsp\Model\ResourceModel\ProductUSPRelation as ProductUSPRelationResource;

/**
 * Class Collection
 *
 * @package <removed>\ProductUsp\Model\ResourceModel\ProductUSPRelation
 * @api
 */
class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            ProductUSPRelationModel::class,
            ProductUSPRelationResource::class
        );
    }

    /**
     * @param $store
     * @param $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true): self
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
            $this->setFlag('store_filter_added', true);
        }

        return $this;
    }
}