<?php
 
namespace Atg\Shopfinder\Model;
 
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Atg\Shopfinder\Api\Data\ShopfinderInterface;
use Atg\Shopfinder\Api\Data\ShopfinderSearchResultInterface;
use Atg\Shopfinder\Api\Data\ShopfinderSearchResultInterfaceFactory;
use Atg\Shopfinder\Api\ShopfinderRepositoryInterface;
use Atg\Shopfinder\Model\ResourceModel\ShopDetails\CollectionFactory as ShopfinderCollectionFactory;
use Atg\Shopfinder\Model\ResourceModel\ShopDetails\Collection;
 
class ShopfinderRepository implements ShopfinderRepositoryInterface
{
    /**
     * @var Shopfinder
     */
    private $ShopfinderFactory;
 
    /**
     * @var ShopfinderCollectionFactory
     */
    private $ShopfinderCollectionFactory;
     
    /**
     * @var ShopfinderSearchResultInterfaceFactory
     */
    private $searchResultFactory;
 
    public function __construct(
        Shopfinder $ShopfinderFactory,
        ShopfinderCollectionFactory $ShopfinderCollectionFactory,
        ShopfinderSearchResultInterfaceFactory $ShopfinderSearchResultInterfaceFactory
    ) {
        $this->ShopfinderFactory = $ShopfinderFactory;
        $this->ShopfinderCollectionFactory = $ShopfinderCollectionFactory;
        $this->searchResultFactory = $ShopfinderSearchResultInterfaceFactory;
    }
 
    // ... getById, save and delete methods listed above ...
 
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->ShopfinderCollectionFactory->create();
 
        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);
 
        $collection->load();
 
        return $this->buildSearchResult($searchCriteria, $collection);
    }
    
    
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }
 
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }
 
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }
 
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultFactory->create();
 
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
 
        return $searchResults;
    }
}