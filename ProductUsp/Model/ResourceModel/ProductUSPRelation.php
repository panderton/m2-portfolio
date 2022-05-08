<?php

namespace <removed>\ProductUsp\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use <removed>\ProductUsp\Api\Data\ProductUSPRelationInterface;

/**
 * Class ProductUSPRelation
 *
 * @package <removed>\ProductUsp\Model\ResourceModel
 * @api
 */
class ProductUSPRelation extends AbstractDb
{
    const TABLE_NAME = 'cms_product_usp_relation';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, ProductUSPRelationInterface::RELATION_ID);
    }
}