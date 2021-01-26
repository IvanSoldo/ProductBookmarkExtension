<?php

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
     * @return mixed
     */
    public function setId(int $id);

    /**
     * @param int $bookmarkListId
     * @return mixed
     */
    public function setBookmarkListId(int $bookmarkListId);

    /**
     * @param int $productId
     * @return mixed
     */
    public function setProductId(int $productId);

    /**
     * @param int $websiteId
     * @return mixed
     */
    public function setWebsiteId(int $websiteId);
}
