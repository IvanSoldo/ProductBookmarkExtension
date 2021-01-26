<?php

namespace Inchoo\ProductBookmark\Api;

use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface BookmarkRepositoryInterface
{

    /**
     * @param int $bookmarkId
     * @return mixed
     */
    public function getById(int $bookmarkId);

    /**
     * @param BookmarkInterface $bookmark
     * @return mixed
     */
    public function save(BookmarkInterface $bookmark);

    /**
     * @param BookmarkInterface $bookmark
     * @return mixed
     */
    public function delete(BookmarkInterface $bookmark);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
