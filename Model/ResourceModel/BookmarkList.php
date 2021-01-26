<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class BookmarkList extends AbstractDb
{

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('inchoo_bookmark_list', 'bookmark_list_id');
    }
}
