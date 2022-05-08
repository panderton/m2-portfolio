<?php
declare(strict_types=1);

namespace <removed>\ProductUsp\Observer;

use <removed>\ProductUsp\Api\ProductUSPRelationRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Controller\Adminhtml\Product\Save;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;


class ProcessUspItemsObserver implements ObserverInterface
{
    /**
     * @var ProductUSPRelationRepositoryInterface
     */
    protected $productUSPRelationRepository;

    /**
     *
     */
    public function __construct (
        ProductUSPRelationRepositoryInterface $productUSPRelationRepository
    ) {
        $this->productUSPRelationRepository = $productUSPRelationRepository;
    }

    /**
     *It takes the product ID and the USP ID and creates a new row in the database
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        /** @var Save $controller */
        $controller = $observer->getEvent()->getController();

        /** @var ProductInterface $product1 */
        $product = $observer->getEvent()->getProduct();

        $sources = $controller->getRequest()->getParam('usp', []);

        if (count($sources['assigned_usps']) > 0) {
            foreach ($sources['assigned_usps'] as $usp) {
                try {
                    $this->productUSPRelationRepository->create($usp['usp_id'], $product->getId());
                } catch (\Exception $e) {
                    var_dump($e->getMessage());
                }
            }
        }
    }
}