<?php

namespace <removed>\ProductUsp\Model\ResourceModel\ProductUSP\Relation\Store;

use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use <removed>\ProductUsp\Api\Data\ProductUSPInterface;
use <removed>\ProductUsp\Model\ResourceModel\ProductUSP;
use Magento\Framework\EntityManager\MetadataPool;

/**
 * Class SaveHandler
 */
class SaveHandler implements ExtensionInterface
{
    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @var ProductUSP
     */
    protected $resourceProductUSP;

    /**
     * @param MetadataPool $metadataPool
     * @param ProductUSP $resourceProductUSP
     */
    public function __construct(
        MetadataPool $metadataPool,
        ProductUSP $resourceProductUSP
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourceProductUSP = $resourceProductUSP;
    }

    /**
     * @param object $entity
     * @param array $arguments
     * @return object
     * @throws \Exception
     */
    public function execute($entity, $arguments = [])
    {
        $entityMetadata = $this->metadataPool->getMetadata(ProductUSPInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $connection = $entityMetadata->getEntityConnection();

        $oldStores = $this->resourceProductUSP->lookupStoreIds((int)$entity->getId());
        $newStores = (array)$entity->getStores();

        $table = $this->resourceProductUSP->getTable('cms_product_usp_store');

        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = [
                $linkField . ' = ?' => (int)$entity->getData($linkField),
                'store_id IN (?)' => $delete,
            ];
            $connection->delete($table, $where);
        }

        $insert = array_diff($newStores, $oldStores);
        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = [
                    $linkField => (int)$entity->getData($linkField),
                    'store_id' => (int)$storeId,
                ];
            }
            $connection->insertMultiple($table, $data);
        }

        return $entity;
    }
}