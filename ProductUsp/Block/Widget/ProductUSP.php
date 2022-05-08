<?php


declare(strict_types=1);

namespace <removed>\ProductUsp\Block\Widget;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use <removed>\ProductUsp\Model\ProductUSP as CmsProductUSP;
use Magento\Widget\Block\BlockInterface;

/**
 * Cms Static Block Widget
 *
 * @author Magento Core Team <core@magentocommerce.com>
 */
class ProductUSP extends \Magento\Framework\View\Element\Template implements BlockInterface, IdentityInterface
{
    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
     * Storage for used widgets
     *
     * @var array
     */
    protected static $_widgetUsageMap = [];

    /**
     * ProductUSP factory
     *
     * @var \<removed>\ProductUsp\Model\ProductUSPFactory
     */
    protected $_productUSPFactory;

    /**
     * @var CmsProductUSP
     */
    private $productUSP;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \<removed>\ProductUsp\Model\ProductUSPFactory $productUSPFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \<removed>\ProductUsp\Model\ProductUSPFactory $productUSPFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_filterProvider = $filterProvider;
        $this->_productUSPFactory = $productUSPFactory;
    }

    /**
     * Prepare productUSP text and determine whether productUSP output enabled or not.
     *
     * Prevent productUSPs recursion if needed.
     *
     * @return $this
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $productUSPId = $this->getData('usp_id');
        $productUSPHash = get_class($this) . $productUSPId;

        if (isset(self::$_widgetUsageMap[$productUSPHash])) {
            return $this;
        }
        self::$_widgetUsageMap[$productUSPHash] = true;

        $productUSP = $this->getProductUSP();

        if ($productUSP && $productUSP->isActive()) {
            try {
                $storeId = $this->getData('store_id') ?? $this->_storeManager->getStore()->getId();
                $this->setText(
                    $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($productUSP->getContent())
                );
            } catch (NoSuchEntityException $e) {
            }
        }
        unset(self::$_widgetUsageMap[$productUSPHash]);
        return $this;
    }

    /**
     * Get identities of the Cms ProductUSP
     *
     * @return array
     */
    public function getIdentities()
    {
        $productUSP = $this->getProductUSP();

        if ($productUSP) {
            return $productUSP->getIdentities();
        }

        return [];
    }

    /**
     * Get productUSP
     *
     * @return CmsProductUSP|null
     */
    private function getProductUSP(): ?CmsProductUSP
    {
        if ($this->productUSP) {
            return $this->productUSP;
        }

        $productUSPId = $this->getData('usp_id');

        if ($productUSPId) {
            try {
                $storeId = $this->_storeManager->getStore()->getId();
                /** @var \<removed>\ProductUsp\Model\ProductUSP $productUSP */
                $productUSP = $this->_productUSPFactory->create();
                $productUSP->setStoreId($storeId)->load($productUSPId);
                $this->productUSP = $productUSP;

                return $productUSP;
            } catch (NoSuchEntityException $e) {
            }
        }

        return null;
    }
}