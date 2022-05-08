<?php

namespace <removed>\ProductUsp\Model\ProductUSP\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class IsActive implements OptionSourceInterface
{
    /**
     * @var \<removed>\ProductUsp\Model\ProductUSP
     */
    protected $cmsProductUSP;

    /**
     * Constructor
     *
     * @param \<removed>\ProductUsp\Model\ProductUSP $cmsProductUSP
     */
    public function __construct(\<removed>\ProductUsp\Model\ProductUSP $cmsProductUSP)
    {
        $this->cmsProductUSP = $cmsProductUSP;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->cmsProductUSP->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}