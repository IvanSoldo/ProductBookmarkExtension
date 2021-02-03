<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Model;

use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Magento\Framework\Model\AbstractModel;

class Bookmark extends AbstractModel implements BookmarkInterface
{

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Bookmark::class);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::BOOKMARK_ID);
    }

    /**
     * @return int
     */
    public function getBookmarkListId()
    {
        return $this->getData(self::BOOKMARK_LIST_ID);
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * @return int
     */
    public function getWebsiteId()
    {
        return $this->getData(self::WEBSITE_ID);
    }

    /**
     * @param int
     * @return BookmarkInterface
     */
    public function setId($id)
    {
        return $this->setData(self::BOOKMARK_ID, $id);
    }

    /**
     * @param int $bookmarkListId
     * @return BookmarkInterface
     */
    public function setBookmarkListId(int $bookmarkListId): BookmarkInterface
    {
        return $this->setData(self::BOOKMARK_LIST_ID, $bookmarkListId);
    }

    /**
     * @param int $productId
     * @return BookmarkInterface
     */
    public function setProductId(int $productId): BookmarkInterface
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @param int $websiteId
     * @return BookmarkInterface
     */
    public function setWebsiteId(int $websiteId): BookmarkInterface
    {
        return $this->setData(self::WEBSITE_ID, $websiteId);
    }
}
