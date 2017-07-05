<?php
namespace Atg\Shopfinder\Block\Adminhtml;

class Shop extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml';
        $this->_blockGroup = 'Atg_Shopfinder';
        $this->_headerText = __('Manage Shop Detail');
        $this->_addButtonLabel = __('Add New Shop Detail');
        parent::_construct();
    }
}