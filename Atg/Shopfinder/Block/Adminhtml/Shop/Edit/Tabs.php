<?php
namespace Atg\Shopfinder\Block\Adminhtml\Shop\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('detail_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Shop Detail Information'));
    }
}
