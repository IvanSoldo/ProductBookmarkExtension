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
     * @return array|int|mixed|null
     */
    public function getId()
    {
        return $this->getData(self::BOOKMARK_ID);
    }

    /**
     * @return array|int|mixed|null
     */
    public function getBookmarkListId()
    {
        return $this->getData(self::BOOKMARK_LIST_ID);
    }

    /**
     * @return array|int|mixed|null
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * @return array|int|mixed|null
     */
    public function getWebsiteId()
    {
        return $this->getData(self::WEBSITE_ID);
    }

    /**
     * @param int|mixed $id
     * @return Bookmark|mixed
     */
    public function setId($id)
    {
        return $this->setData(self::BOOKMARK_ID, $id);
    }

    /**
     * @param int $bookmarkListId
     * @return Bookmark|mixed
     */
    public function setBookmarkListId(int $bookmarkListId)
    {
        return $this->setData(self::BOOKMARK_LIST_ID, $bookmarkListId);
    }

    /**
     * @param int $productId
     * @return Bookmark|mixed
     */
    public function setProductId(int $productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @param int $websiteId
     * @return Bookmark|mixed
     */
    public function setWebsiteId(int $websiteId)
    {
        return $this->setData(self::WEBSITE_ID, $websiteId);
    }
}
