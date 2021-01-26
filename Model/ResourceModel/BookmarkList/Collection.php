<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * Resource collection initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Inchoo\ProductBookmark\Model\BookmarkList::class,
            \Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList::class
        );
    }
}
