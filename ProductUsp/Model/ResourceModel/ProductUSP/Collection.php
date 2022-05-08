<?php

namespace <removed>\ProductUsp\Model\ResourceModel\ProductUSP;

use <removed>\ProductUsp\Api\Data\ProductUSPInterface;
use \Magento\Cms\Model\ResourceModel\AbstractCollection;

/**
 * CMS ProductUSP Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'usp_id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'cms_product_usp_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'product_usp_collection';

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $entityMetadata = $this->metadataPool->getMetadata(ProductUSPInterface::class);

        $this->performAfterLoad('cms_product_usp_store', $entityMetadata->getLinkField());

        return parent::_afterLoad();
    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\<removed>\ProductUsp\Model\ProductUSP::class, \<removed>\ProductUsp\Model\ResourceModel\ProductUSP::class);
        $this->_map['fields']['store'] = 'store_table.store_id';
        $this->_map['fields']['usp_id'] = 'main_table.usp_id';
    }

    /**
     * Returns pairs usp_id - title
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('usp_id', 'title');
    }

    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->performAddStoreFilter($store, $withAdmin);

        return $this;
    }

    /**
     * Join store relation table if there is store filter
     *
     * @return void
     */
    protected function _renderFiltersBefore()
    {
        $entityMetadata = $this->metadataPool->getMetadata(ProductUSPInterface::class);
        $this->joinStoreRelationTable('cms_product_usp_store', $entityMetadata->getLinkField());
    }
}