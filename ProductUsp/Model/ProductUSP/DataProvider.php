<?php

namespace <removed>\ProductUsp\Model\ProductUSP;

use <removed>\ProductUsp\Model\ResourceModel\ProductUSP\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    /**
     * @var \<removed>\ProductUsp\Model\ResourceModel\ProductUSP\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $productUSPCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $productUSPCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $productUSPCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * It gets the data from the database and puts it into an array
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \<removed>\ProductUsp\Model\ProductUSP $productUSP */
        foreach ($items as $productUSP) {
            $this->loadedData[$productUSP->getId()] = $productUSP->getData();
        }

        $data = $this->dataPersistor->get('cms_product_usp');
        if (!empty($data)) {
            $productUSP = $this->collection->getNewEmptyItem();
            $productUSP->setData($data);
            $this->loadedData[$productUSP->getId()] = $productUSP->getData();
            $this->dataPersistor->clear('cms_product_usp');
        }

        return $this->loadedData;
    }
}