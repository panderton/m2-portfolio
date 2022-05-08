<?php

namespace <removed>\ProductUsp\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\AbstractBlock;

/**
 * Cms productUSP content productUSP
 */
class ProductUSP extends AbstractBlock implements \Magento\Framework\DataObject\IdentityInterface
{
    /**
     * Prefix for cache key of CMS productUSP
     */
    const CACHE_KEY_PREFIX = 'CMS_PRODUCT_USP_';

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * ProductUSP factory
     *
     * @var \<removed>\ProductUsp\Model\ProductUSPFactory
     */
    protected $_productUSPFactory;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \<removed>\ProductUsp\Model\ProductUSPFactory $productUSPFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \<removed>\ProductUsp\Model\ProductUSPFactory $productUSPFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_filterProvider = $filterProvider;
        $this->_storeManager = $storeManager;
        $this->_productUSPFactory = $productUSPFactory;
    }

    /**
     * Prepare Content HTML
     *
     * @return string
     * @throws NoSuchEntityException
     */
    protected function _toHtml()
    {
        $productUSPId = $this->getProductUSPId();
        $html = '';
        if ($productUSPId) {
            $storeId = $this->_storeManager->getStore()->getId();
            /** @var \<removed>\ProductUsp\Model\ProductUSP $productUSP */
            $productUSP = $this->_productUSPFactory->create();
            $productUSP->setStoreId($storeId)->load($productUSPId);
            if ($productUSP->isActive()) {
                $html = $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($productUSP->getContent());
            }
        }
        return $html;
    }

    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities()
    {
        return [\<removed>\ProductUsp\Model\ProductUSP::CACHE_TAG . '_' . $this->getProductUSPId()];
    }

    /**
     * @inheritdoc
     */
    public function getCacheKeyInfo()
    {
        $cacheKeyInfo = parent::getCacheKeyInfo();
        $cacheKeyInfo[] = $this->_storeManager->getStore()->getId();
        return $cacheKeyInfo;
    }

    /** TODO: Test function **/
    public function getTopThreeUsp($product)
    {
        return ['TEST', $product->getSku()];
    }

}
