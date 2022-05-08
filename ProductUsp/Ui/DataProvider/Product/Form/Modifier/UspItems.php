<?php
declare(strict_types=1);

namespace <removed>\ProductUsp\Ui\DataProvider\Product\Form\Modifier;

use <removed>\ProductUsp\Api\Data\ProductUSPInterface;
use <removed>\ProductUsp\Api\Data\ProductUSPRelationInterface;
use <removed>\ProductUsp\Api\ProductUSPRepositoryInterface;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use <removed>\ProductUsp\Api\ProductUSPRelationRepositoryInterface;

/**
 * Product form modifier. Add to form usp data
 */
class UspItems extends AbstractModifier
{
    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @var ProductUSPRelationRepositoryInterface
     */
    private $getUspItemsDataById;

    /**
     * @param LocatorInterface $locator
     * @param ProductUSPInterface $uspInterface
     * @param ProductUSPRelationRepositoryInterface $getUspItemsDataById
     */
    public function __construct(
        LocatorInterface $locator,
        ProductUSPInterface $uspInterface,
        ProductUSPRelationRepositoryInterface $getUspItemsDataById
    ) {
        $this->locator = $locator;
        $this->uspInterface = $uspInterface;
        $this->getUspItemsDataById = $getUspItemsDataById;
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data)
    {
        $uspsItemsData = [];

        $product = $this->locator->getProduct();
        $itemList = $this->getUspItemsDataById->getRelatedUspsByProductId($product->getId())->getItems();

        $upsCache = [];
        foreach ($itemList as $item) {
//            $sourceCode = $item->getIdentifier();
//            if (!isset($upsCache[$sourceCode])) {
//                $upsCache[$sourceCode] = $this->uspInterface->get($sourceCode);
//            }
//
//            $source = $upsCache[$sourceCode];

            $uspsItemsData[] = [
                'usp_id' => $item->getUspId(),
                'title' => $item->getTitle(),
                'identifier' => $item->getIdentifier(),
                'is_active' => $item->getIsActive(),
            ];
        }
        $data[$product->getId()]['usp']['assigned_usps'] = $uspsItemsData;
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta)
    {
        $product = $this->locator->getProduct();

        return $meta;
    }
}