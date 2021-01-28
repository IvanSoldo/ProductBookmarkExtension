<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Api\Data;

interface BookmarkInterface
{
    const BOOKMARK_ID = 'bookmark_id';
    const BOOKMARK_LIST_ID = 'bookmark_list_id';
    const PRODUCT_ID = 'product_id';
    const WEBSITE_ID = 'website_id';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getBookmarkListId();

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @return int
     */
    public function getWebsiteId();

    /**
     * @param int $id
     * @return BookmarkInterface
     */
    public function setId(int $id);

    /**
     * @param int $bookmarkListId
     * @return BookmarkInterface
     */
    public function setBookmarkListId(int $bookmarkListId);

    /**
     * @param int $productId
     * @return BookmarkInterface
     */
    public function setProductId(int $productId);

    /**
     * @param int $websiteId
     * @return BookmarkInterface
     */
    public function setWebsiteId(int $websiteId);
}
