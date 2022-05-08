<?php

namespace <removed>\ProductUsp\Model\ResourceModel\ProductUSP\Relation\Store;

use <removed>\ProductUsp\Model\ResourceModel\ProductUSP;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

/**
 * Class ReadHandler
 */
class ReadHandler implements ExtensionInterface
{
    /**
     * @var ProductUSP
     */
    protected $resourceProductUSP;

    /**
     * @param ProductUSP $resourceProductUSP
     */
    public function __construct(
        ProductUSP $resourceProductUSP
    ) {
        $this->resourceProductUSP = $resourceProductUSP;
    }

    /**
     * @param object $entity
     * @param array $arguments
     * @return object
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute($entity, $arguments = [])
    {
        if ($entity->getId()) {
            $stores = $this->resourceProductUSP->lookupStoreIds((int)$entity->getId());
            $entity->setData('store_id', $stores);
            $entity->setData('stores', $stores);
        }
        return $entity;
    }
}