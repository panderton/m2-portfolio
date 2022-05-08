<?php
namespace <removed>\ProductUsp\Model;

use <removed>\ProductUsp\Api\GetProductUSPByIdentifierInterface;
use <removed>\ProductUsp\Api\Data\ProductUSPInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GetProductUSPByIdentifier
 */
class GetProductUSPByIdentifier implements GetProductUSPByIdentifierInterface
{
    /**
     * @var \<removed>\ProductUsp\Model\ProductUSPFactory
     */
    private $productUSPFactory;

    /**
     * @var ResourceModel\Product USP
     */
    private $productUSPResource;

    /**
     * @param ProductUSPFactory $productUSPFactory
     * @param ResourceModel\ProductUSP $productUSPResource
     */
    public function __construct(
        \<removed>\ProductUsp\Model\ProductUSPFactory $productUSPFactory,
        \<removed>\ProductUsp\Model\ResourceModel\ProductUSP $productUSPResource
    ) {
        $this->productUSPFactory = $productUSPFactory;
        $this->productUSPResource = $productUSPResource;
    }

    /**
     * @inheritdoc
     */
    public function execute(string $identifier, int $storeId) : ProductUSPInterface
    {
        $productUSP = $this->productUSPFactory->create();
        $productUSP->setStoreId($storeId);
        $this->productUSPResource->load($productUSP, $identifier, ProductUSPInterface::IDENTIFIER);

        if (!$productUSP->getId()) {
            throw new NoSuchEntityException(__('The CMS productUSP with the "%1" ID doesn\'t exist.', $identifier));
        }

        return $productUSP;
    }
}