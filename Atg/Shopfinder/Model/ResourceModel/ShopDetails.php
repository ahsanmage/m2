<?php
namespace Atg\Shopfinder\Model\ResourceModel;

class ShopDetails extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('shop_details', 'shopdetail_id');
    }
}