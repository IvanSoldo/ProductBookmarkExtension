<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Model\ResourceModel\Bookmark;

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
            \Inchoo\ProductBookmark\Model\Bookmark::class,
            \Inchoo\ProductBookmark\Model\ResourceModel\Bookmark::class
        );
    }
}
