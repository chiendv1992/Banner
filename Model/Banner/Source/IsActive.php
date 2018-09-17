<?php

namespace Manager\Banner\Model\Banner\Source;

use Magento\Framework\Data\OptionSourceInterface;


class IsActive implements OptionSourceInterface
{

    protected $banner;

    public function __construct(\Manager\Banner\Model\Banner $banner)
    {
        $this->banner = $banner;
    }
    public function toOptionArray()
    {
        $availableOptions = $this->banner->getAvailableStatuses();
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
