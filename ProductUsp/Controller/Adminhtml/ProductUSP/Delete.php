<?php

namespace <removed>\ProductUsp\Controller\Adminhtml\ProductUSP;

use Magento\Framework\App\Action\HttpPostActionInterface;

class Delete extends \<removed>\ProductUsp\Controller\Adminhtml\ProductUSP implements HttpPostActionInterface
{
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('usp_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\<removed>\ProductUsp\Model\ProductUSP::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the productUSP.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['usp_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a productUSP to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}