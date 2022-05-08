<?php

namespace <removed>\ProductUsp\Model;

use Magento\Framework\Model\AbstractModel;
use <removed>\ProductUsp\Api\Data\ProductUSPRelationInterface;
use <removed>\ProductUsp\Model\ResourceModel\ProductUSPRelation as Resource;

/**
 * Class ProductUSPRelation
 *
 * @package <removed>\ProductUsp\Model
 * @api
 */
class ProductUSPRelation extends AbstractModel implements ProductUSPRelationInterface
{
    /**
     * Custom USP product relation cache tag
     */
    const CACHE_TAG = 'custom_usp_prod_usp_rel';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'custom_usp_product_usp_relation';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Resource::class);
    }

    /**
     * @return array|mixed|null
     */
    public function getId()
    {
        return $this->getData(self::RELATION_ID);
    }

    /**
     * @param $value
     * @return ProductUSPRelationInterface
     */
    public function setId($value): ProductUSPRelationInterface
    {
        return $this->setData(self::RELATION_ID, $value);
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * @param $productId
     * @return ProductUSPRelationInterface
     */
    public function setProductId($productId): ProductUSPRelationInterface
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @return int
     */
    public function getUspId(): int
    {
        return $this->getData(self::USP_ID);
    }

    /**
     * @param $uspId
     * @return ProductUSPRelationInterface
     */
    public function setUspId($uspId): ProductUSPRelationInterface
    {
        return $this->setData(self::USP_ID, $uspId);
    }
}