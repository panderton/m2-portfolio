<?php

namespace <removed>\ProductUsp\Controller\Adminhtml\ProductUSP;

use Magento\Backend\App\Action\Context;
use <removed>\ProductUsp\Api\ProductUSPRepositoryInterface as ProductUSPRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use <removed>\ProductUsp\Api\Data\ProductUSPInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = '<removed>_ProductUsp::cms_product_usp';

    /**
     * @var \<removed>\ProductUsp\Api\ProductUSPRepositoryInterface
     */
    protected $productUSPRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param ProductUSPRepository $productUSPRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        ProductUSPRepository $productUSPRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->productUSPRepository = $productUSPRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $productUSPId) {
                    /** @var \<removed>\ProductUsp\Model\ProductUSP $productUSP */
                    $productUSP = $this->productUSPRepository->getById($productUSPId);
                    try {
                        $productUSP->setData(array_merge($productUSP->getData(), $postItems[$productUSPId]));
                        $this->productUSPRepository->save($productUSP);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithProductUSPId(
                            $productUSP,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add productUSP title to error message
     *
     * @param ProductUSPInterface $productUSP
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithProductUSPId(ProductUSPInterface $productUSP, $errorText)
    {
        return '[ProductUSP ID: ' . $productUSP->getId() . '] ' . $errorText;
    }
}