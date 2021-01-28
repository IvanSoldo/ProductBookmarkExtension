<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Model;

use Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkInterfaceFactory;
use Inchoo\ProductBookmark\Api\Data\BookmarkSearchResultsInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkSearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class BookmarkRepository implements BookmarkRepositoryInterface
{

    /**
     * @var BookmarkInterfaceFactory
     */
    protected $bookmarkModelFactory;

    /**
     * @var \Inchoo\ProductBookmark\Model\ResourceModel\Bookmark
     */
    protected $bookmarkResource;

    /**
     * @var \Inchoo\ProductBookmark\Model\ResourceModel\Bookmark\CollectionFactory
     */
    protected $bookmarkCollectionFactory;

    /**
     * @var BookmarkSearchResultsInterfaceFactory
     */
    protected $searchResultFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * BookmarkRepository constructor.
     * @param BookmarkInterfaceFactory $bookmarkModelFactory
     * @param ResourceModel\Bookmark $bookmarkResource
     * @param ResourceModel\Bookmark\CollectionFactory $bookmarkCollectionFactory
     * @param BookmarkSearchResultsInterfaceFactory $searchResultFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        BookmarkInterfaceFactory $bookmarkModelFactory,
        ResourceModel\Bookmark $bookmarkResource,
        ResourceModel\Bookmark\CollectionFactory $bookmarkCollectionFactory,
        BookmarkSearchResultsInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->bookmarkModelFactory = $bookmarkModelFactory;
        $this->bookmarkResource = $bookmarkResource;
        $this->bookmarkCollectionFactory = $bookmarkCollectionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $bookmarkId
     * @return BookmarkInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $bookmarkId): BookmarkInterface
    {
        $bookmark = $this->bookmarkModelFactory->create();
        $this->bookmarkResource->load($bookmark, $bookmarkId);
        if (!$bookmark->getId()) {
            throw new NoSuchEntityException(__('Bookmark does not exist.', $bookmark));
        }
        return $bookmark;
    }

    /**
     * @param BookmarkInterface $bookmark
     * @return BookmarkInterface
     * @throws CouldNotSaveException
     */
    public function save(BookmarkInterface $bookmark): BookmarkInterface
    {
        try {
            $this->bookmarkResource->save($bookmark);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $bookmark;
    }

    /**
     * @param BookmarkInterface $bookmark
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(BookmarkInterface $bookmark): bool
    {
        try {
            $this->bookmarkResource->delete($bookmark);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return BookmarkSearchResultsInterface|mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->bookmarkCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
