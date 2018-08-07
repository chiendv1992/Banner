<?php
namespace Manager\Banner\Model\ResourceModel\Banner;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id'; //bo xung khi sd chức năng Massaction
    protected function _construct()
    {
        // Model + Resource Model
        $this->_init('Manager\Banner\Model\Banner', 'Manager\Banner\Model\ResourceModel\Banner');
    }
}