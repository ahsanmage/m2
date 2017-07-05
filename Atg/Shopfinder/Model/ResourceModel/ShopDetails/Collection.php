<?php
namespace Atg\Shopfinder\Model\ResourceModel\ShopDetails;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'shopdetail_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Atg\Shopfinder\Model\ShopDetails', 'Atg\Shopfinder\Model\ResourceModel\ShopDetails');
        $this->_map['fields']['shopdetail_id'] = 'main_table.shopdetail_id';
    }

    /**
     * Prepare page's statuses.
     * Available event cms_page_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}