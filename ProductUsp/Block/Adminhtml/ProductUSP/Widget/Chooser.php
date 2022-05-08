<?php

namespace <removed>\ProductUsp\Block\Adminhtml\ProductUSP\Widget;

/**
 * CMS productUSP chooser for Wysiwyg CMS widget
 */
class Chooser extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \<removed>\ProductUsp\Model\ProductUSPFactory
     */
    protected $_productUSPFactory;

    /**
     * @var \<removed>\ProductUsp\Model\ResourceModel\ProductUSP\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \<removed>\ProductUsp\Model\ProductUSPFactory $productUSPFactory
     * @param \<removed>\ProductUsp\Model\ResourceModel\ProductUSP\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \<removed>\ProductUsp\Model\ProductUSPFactory $productUSPFactory,
        \<removed>\ProductUsp\Model\ResourceModel\ProductUSP\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_productUSPFactory = $productUSPFactory;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * ProductUSP construction, prepare grid params
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setDefaultSort('usp_identifier');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setDefaultFilter(['chooser_is_active' => '1']);
    }

    /**
     * Prepare chooser element HTML
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element Form Element
     * @return \Magento\Framework\Data\Form\Element\AbstractElement
     */
    public function prepareElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $uniqId = $this->mathRandom->getUniqueHash($element->getId());
        $sourceUrl = $this->getUrl('cms/product_usp_widget/chooser', ['uniq_id' => $uniqId]);

        $chooser = $this->getLayout()->createBlock(
            \Magento\Widget\Block\Adminhtml\Widget\Chooser::class
        )->setElement(
            $element
        )->setConfig(
            $this->getConfig()
        )->setFieldsetId(
            $this->getFieldsetId()
        )->setSourceUrl(
            $sourceUrl
        )->setUniqId(
            $uniqId
        );

        if ($element->getValue()) {
            $productUSP = $this->_productUSPFactory->create()->load($element->getValue());
            if ($productUSP->getId()) {
                $chooser->setLabel($this->escapeHtml($productUSP->getTitle()));
            }
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    /**
     * Grid Row JS Callback
     *
     * @return string
     */
    public function getRowClickCallback()
    {
        $chooserJsObject = $this->getId();
        $js = '
            function (grid, event) {
                var trElement = Event.findElement(event, "tr");
                var productUSPId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
                var productUSPTitle = trElement.down("td").next().innerHTML;
                ' .
            $chooserJsObject .
            '.setElementValue(productUSPId);
                ' .
            $chooserJsObject .
            '.setElementLabel(productUSPTitle);
                ' .
            $chooserJsObject .
            '.close();
            }
        ';
        return $js;
    }

    /**
     * Prepare Cms static productUSPs collection
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareCollection()
    {
        $this->setCollection($this->_collectionFactory->create());
        return parent::_prepareCollection();
    }

    /**
     * Prepare columns for Cms productUSPs grid
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'chooser_id',
            ['header' => __('ID'), 'align' => 'right', 'index' => 'usp_id', 'width' => 50]
        );

        $this->addColumn('chooser_title', ['header' => __('Title'), 'align' => 'left', 'index' => 'title']);

        $this->addColumn(
            'chooser_identifier',
            ['header' => __('Identifier'), 'align' => 'left', 'index' => 'identifier']
        );

        $this->addColumn(
            'chooser_is_active',
            [
                'header' => __('Status'),
                'index' => 'is_active',
                'type' => 'options',
                'options' => [0 => __('Disabled'), 1 => __('Enabled')]
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('cms/product_usp_widget/chooser', ['_current' => true]);
    }
}