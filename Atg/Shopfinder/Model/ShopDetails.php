<?php
namespace Atg\Shopfinder\Model;

class ShopDetails extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Atg\Shopfinder\Model\ResourceModel\ShopDetails');
    }
}