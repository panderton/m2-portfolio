<?php

namespace <removed>\ProductUsp\Block\Adminhtml;

/**
 * Adminhtml cms ProductUSP content ProductUSP
 */
class ProductUSP extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_uspGroup = 'Magento_Cms';
        $this->_controller = 'adminhtml_usp';
        $this->_headerText = __('Static ProductUSP');
        $this->_addButtonLabel = __('Add New ProductUSP');
        parent::_construct();
    }
}