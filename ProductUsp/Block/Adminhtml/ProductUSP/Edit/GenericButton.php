<?php

namespace <removed>\ProductUsp\Block\Adminhtml\ProductUSP\Edit;

use Magento\Backend\Block\Widget\Context;
use <removed>\ProductUsp\Api\ProductUSPRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var ProductUSPRepositoryInterface
     */
    protected $productUSPRepository;

    /**
     * @param Context $context
     * @param ProductUSPRepositoryInterface $productUSPRepository
     */
    public function __construct(
        Context $context,
        ProductUSPRepositoryInterface $productUSPRepository
    ) {
        $this->context = $context;
        $this->productUSPRepository = $productUSPRepository;
    }

    /**
     * Return CMS productUSP ID
     *
     * @return int|null
     */
    public function getProductUSPId()
    {
        try {
            return $this->productUSPRepository->getById(
                $this->context->getRequest()->getParam('usp_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}