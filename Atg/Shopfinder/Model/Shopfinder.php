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
        //$stores = array(1,2,3,4);
        
$Mage = \Magento\Framework\App\ObjectManager::getInstance();
        $stores = $Mage->getStores();
        


        return $stores;
    }
}