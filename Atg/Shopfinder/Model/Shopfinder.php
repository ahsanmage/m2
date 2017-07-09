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
        $stores = array(1,2,3,4);
        return $stores;
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

    /**
     * Load Test data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Webkul\Hello\Model\ResourceModel\Test\Collection
     */
    public function index(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
 
        $collection = $this->testCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrdersData = $criteria->getSortOrders();
        if ($sortOrdersData) {
            foreach ($sortOrdersData as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
 
        $collection->setPageSize($criteria->getPageSize());
         
        $testItem = [];
        /** @var Test $testModel */
        foreach ($collection as $testModel) {
            $testData = $this->dataTestFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $testData,
                $testModel->getData(),
                'Webkul\Hello\Api\Data\TestInterface'
            );
            $preorderItem[] = $this->dataObjectProcessor->buildOutputDataArray(
                $testData,
                'Webkul\Hello\Api\Data\TestInterface'
            );
        }
        $searchResults->setItems($testItem);
        return $searchResults;
    }
}