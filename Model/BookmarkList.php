<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Model;

use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
use Magento\Framework\Model\AbstractModel;

class BookmarkList extends AbstractModel implements BookmarkListInterface
{

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\BookmarkList::class);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::BOOKMARK_LIST_ID);
    }

    /**
     * @return string
     */
    public function getBookmarkListTitle()
    {
        return $this->getData(self::BOOKMARK_LIST_TITLE);
    }

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @return bool
     */
    public function getIsDeletable()
    {
        return $this->getData(self::IS_DELETABLE);
    }

    /**
     * @param int|mixed $id
     * @return BookmarkList|mixed
     */
    public function setId($id)
    {
        return $this->setData(self::BOOKMARK_LIST_ID, $id);
    }

    /**
     * @param string $title
     * @return BookmarkList|mixed
     */
    public function setBookmarkListTitle(string $title)
    {
        return $this->setData(self::BOOKMARK_LIST_TITLE, $title);
    }

    /**
     * @param int $customerId
     * @return BookmarkList|mixed
     */
    public function setCustomerId(int $customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @param bool $isDeletable
     * @return BookmarkList|mixed
     */
    public function setIsDeletable(bool $isDeletable)
    {
        return $this->setData(self::IS_DELETABLE, $isDeletable);
    }
}
