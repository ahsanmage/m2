<?php
 
namespace Atg\Shopfinder\Api\Data;
 
use Magento\Framework\Api\SearchResultsInterface;
 
interface ShopfinderSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Atg\Shopfinder\Api\Data\ShopfinderInterface[]
     */
    public function getItems();
 
    /**
     * @param \Atg\Shopfinder\Api\Data\ShopfinderInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}