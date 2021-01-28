<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Api;

use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkListSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface BookmarkListRepositoryInterface
{

    /**
     * @param int $bookmarkListId
     * @return BookmarkListInterface
     */
    public function getById(int $bookmarkListId): BookmarkListInterface;

    /**
     * @param BookmarkListInterface $bookmarkList
     * @return BookmarkListInterface
     */
    public function save(BookmarkListInterface $bookmarkList): BookmarkListInterface;

    /**
     * @param BookmarkListInterface $bookmarkList
     * @return bool
     */
    public function delete(BookmarkListInterface $bookmarkList): bool;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return BookmarkListSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;
}
