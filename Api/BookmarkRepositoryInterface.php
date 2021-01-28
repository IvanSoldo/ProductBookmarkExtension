<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Api;

use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface BookmarkRepositoryInterface
{

    /**
     * @param int $bookmarkId
     * @return BookmarkInterface
     */
    public function getById(int $bookmarkId): BookmarkInterface;

    /**
     * @param BookmarkInterface $bookmark
     * @return BookmarkInterface
     */
    public function save(BookmarkInterface $bookmark): BookmarkInterface;

    /**
     * @param BookmarkInterface $bookmark
     * @return bool
     */
    public function delete(BookmarkInterface $bookmark): bool;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\ProductBookmark\Api\Data\BookmarkSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;
}
