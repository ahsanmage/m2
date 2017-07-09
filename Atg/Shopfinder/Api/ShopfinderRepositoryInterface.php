<?php

namespace Atg\Shopfinder\Api;
 
use Magento\Framework\Api\SearchCriteriaInterface;
 
interface ShopfinderRepositoryInterface
{ 
    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Atg\Shopfinder\Api\Data\ShopfinderSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}