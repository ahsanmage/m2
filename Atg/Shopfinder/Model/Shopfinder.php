<?php

/**
 * Copyright 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Atg\Shopfinder\Model;

use Atg\Shopfinder\Api\ShopfinderInterface;

/**
 * Defines the implementaiton class of the calculator service contract.
 */
class Shopfinder implements ShopfinderInterface
{
    /**
     * Return the sum of the two numbers.
     *
     * @api
     * @param int $num1 Left hand operand.
     * @param int $num2 Right hand operand.
     * @return int The sum of the two values.
     */
    public function add($num1, $num2) {
        return $num1 + $num2 + 5;
    }
    
    /**
     * Return the list of all stores.
     *
     * @api
     * @return array List of stores.
     */
    public function stores() {
        /** @var \Magento\Framework\App\ObjectManager $obj */
        $obj = \Magento\Framework\App\ObjectManager::getInstance();

        /** @var \Magento\Store\Model\StoreManagerInterface|\Magento\Store\Model\StoreManager $storeManager */
        $storeManager = $obj->get('Magento\Store\Model\StoreManagerInterface');
        $stores = $storeManager->getStores($withDefault = false);

        //Get scope config
        /** @var \Magento\Framework\App\Config\ScopeConfigInterface|\Magento\Framework\App\Config $scopeConfig */
        $scopeConfig = $obj->get('Magento\Framework\App\Config\ScopeConfigInterface');

        //Locale code
        $locale = [];

        //Try to get list of locale for all stores;
        foreach($stores as $store) {
            $locale[] = $scopeConfig->getValue('general/locale/code', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store->getStoreId());
        }

            return $locale;
    }
}