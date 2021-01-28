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
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $bookmarkId): BookmarkInterface;

    /**
     * @param BookmarkInterface $bookmark
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(BookmarkInterface $bookmark): bool;

    /**
     * @param BookmarkInterface $bookmark
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(BookmarkInterface $bookmark): bool;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\ProductBookmark\Api\Data\BookmarkSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;
}
