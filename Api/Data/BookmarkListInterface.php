<?php

namespace Inchoo\ProductBookmark\Api\Data;

interface BookmarkListInterface
{
    const BOOKMARK_LIST_ID = 'bookmark_list_id';
    const BOOKMARK_LIST_TITLE = 'bookmark_list_title';
    const CUSTOMER_ID = 'customer_id';
    const IS_DELETABLE = 'is_deletable';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getBookmarkListTitle();

    /**
     * @return mixed
     */
    public function getCustomerId();

    /**
     * @return mixed
     */
    public function getIsDeletable();

    /**
     * @param int $id
     * @return mixed
     */
    public function setId(int $id);

    /**
     * @param string $title
     * @return mixed
     */
    public function setBookmarkListTitle(string $title);

    /**
     * @param int $customerId
     * @return mixed
     */
    public function setCustomerId(int $customerId);

    /**
     * @param bool $isDeletable
     * @return mixed
     */
    public function setIsDeletable(bool $isDeletable);
}
