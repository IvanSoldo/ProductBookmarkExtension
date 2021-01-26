<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Model;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkListInterfaceFactory;
use Inchoo\ProductBookmark\Api\Data\BookmarkListSearchResultsInterfaceFactory;
use Inchoo\ProductBookmark\Api\Data\BookmarkSearchResultsInterfaceFactory;
use Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class BookmarkListRepository implements BookmarkListRepositoryInterface
{

    /**
     * @var BookmarkListInterfaceFactory
     */
    protected $bookmarkListModelFactory;

    /**
     * @var \Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList
     */
    protected $bookmarkListResource;

    /**
     * @var CollectionFactory
     */
    protected $bookmarkListCollectionFactory;

    /**
     * @var BookmarkListSearchResultsInterfaceFactory
     */
    protected $searchResultFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * BookmarkListRepository constructor.
     * @param BookmarkListInterfaceFactory $bookmarkListModelFactory
     * @param ResourceModel\BookmarkList $bookmarkListResource
     * @param CollectionFactory $bookmarkListCollectionFactory
     * @param BookmarkSearchResultsInterfaceFactory $searchResultFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        BookmarkListInterfaceFactory $bookmarkListModelFactory,
        ResourceModel\BookmarkList $bookmarkListResource,
        CollectionFactory $bookmarkListCollectionFactory,
        BookmarkSearchResultsInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->bookmarkListModelFactory = $bookmarkListModelFactory;
        $this->bookmarkListResource = $bookmarkListResource;
        $this->bookmarkListCollectionFactory = $bookmarkListCollectionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $bookmarkListId
     * @return BookmarkListInterface|mixed
     * @throws NoSuchEntityException
     */
    public function getById(int $bookmarkListId)
    {
        $bookmarkList = $this->bookmarkListModelFactory->create();
        $this->bookmarkListResource->load($bookmarkList, $bookmarkListId);
        if (!$bookmarkList->getId()) {
            throw new NoSuchEntityException(__('Bookmark List with id "%1" does not exist.', $bookmarkList));
        }
        return $bookmarkList;
    }

    /**
     * @param BookmarkListInterface $bookmarkList
     * @return BookmarkListInterface|mixed
     * @throws CouldNotSaveException
     */
    public function save(BookmarkListInterface $bookmarkList)
    {
        try {
            $this->bookmarkListResource->save($bookmarkList);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $bookmarkList;
    }

    /**
     * @param BookmarkListInterface $bookmarkList
     * @return bool|mixed
     * @throws CouldNotDeleteException
     */
    public function delete(BookmarkListInterface $bookmarkList)
    {
        try {
            $this->bookmarkListResource->delete($bookmarkList);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\ProductBookmark\Api\Data\BookmarkSearchResultsInterface|mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->bookmarkListCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
