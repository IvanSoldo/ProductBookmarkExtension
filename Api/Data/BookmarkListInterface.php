<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Api\Data;

interface BookmarkListInterface
{
    const BOOKMARK_LIST_ID = 'bookmark_list_id';
    const BOOKMARK_LIST_TITLE = 'bookmark_list_title';
    const CUSTOMER_ID = 'customer_id';
    const IS_DELETABLE = 'is_deletable';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getBookmarkListTitle();

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @return bool
     */
    public function getIsDeletable();

    /**
     * @param int $id
     * @return BookmarkListInterface
     */
    public function setId(int $id);

    /**
     * @param string $title
     * @return BookmarkListInterface
     */
    public function setBookmarkListTitle(string $title);

    /**
     * @param int $customerId
     * @return BookmarkListInterface
     */
    public function setCustomerId(int $customerId);

    /**
     * @param bool $isDeletable
     * @return BookmarkListInterface
     */
    public function setIsDeletable(bool $isDeletable);
}
