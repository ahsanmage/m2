<?php
namespace Atg\Shopfinder\Api;
 
interface ShopfinderSearchResultInterface
{
    /**
     * @return \Atg\Shopfinder\Api\Data\HamburgerInterface[]
     */
    public function getItems();
 
    /**
     * @param \Atg\Shopfinder\Api\Data\HamburgerInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}