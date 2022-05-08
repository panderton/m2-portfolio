<?php

namespace <removed>\ProductUsp\Controller\Adminhtml\ProductUSP;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use <removed>\ProductUsp\Api\ProductUSPRepositoryInterface;
use <removed>\ProductUsp\Model\ProductUSP;
use <removed>\ProductUsp\Model\ProductUSPFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

/**
 * Save CMS productUSP action.
 */
class Save extends \<removed>\ProductUsp\Controller\Adminhtml\ProductUSP implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var ProductUSPFactory
     */
    private $productUSPFactory;

    /**
     * @var ProductUSPRepositoryInterface
     */
    private $productUSPRepository;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param ProductUSPFactory|null $productUSPFactory
     * @param ProductUSPRepositoryInterface|null $productUSPRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        ProductUSPFactory $productUSPFactory = null,
        ProductUSPRepositoryInterface $productUSPRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->productUSPFactory = $productUSPFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(ProductUSPFactory::class);
        $this->productUSPRepository = $productUSPRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(ProductUSPRepositoryInterface::class);
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = ProductUSP::STATUS_ENABLED;
            }
            if (empty($data['usp_id'])) {
                $data['usp_id'] = null;
            }

            /** @var \<removed>\ProductUsp\Model\ProductUSP $model */
            $model = $this->productUSPFactory->create();

            $id = $this->getRequest()->getParam('usp_id');
            if ($id) {
                try {
                    $model = $this->productUSPRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This productUSP no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->productUSPRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the productUSP.'));
                $this->dataPersistor->clear('cms_product_usp');
                return $this->processProductUSPReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the productUSP.'));
            }

            $this->dataPersistor->set('cms_product_usp', $data);
            return $resultRedirect->setPath('*/*/edit', ['usp_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the productUSP return
     *
     * @param \<removed>\ProductUsp\Model\ProductUSP $model
     * @param array $data
     * @param \Magento\Framework\Controller\ResultInterface $resultRedirect
     * @return \Magento\Framework\Controller\ResultInterface
     */
    private function processProductUSPReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect ==='continue') {
            $resultRedirect->setPath('*/*/edit', ['usp_id' => $model->getId()]);
        } else if ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } else if ($redirect === 'duplicate') {
            $duplicateModel = $this->productUSPFactory->create(['data' => $data]);
            $duplicateModel->setId(null);
            $duplicateModel->setIdentifier($data['identifier'] . '-' . uniqid());
            $duplicateModel->setIsActive(ProductUSP::STATUS_DISABLED);
            $this->productUSPRepository->save($duplicateModel);
            $id = $duplicateModel->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated the productUSP.'));
            $this->dataPersistor->set('cms_product_usp', $data);
            $resultRedirect->setPath('*/*/edit', ['usp_id' => $id]);
        }
        return $resultRedirect;
    }
}