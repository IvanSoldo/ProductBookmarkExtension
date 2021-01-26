<?php

namespace Inchoo\ProductBookmark\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BookmarkSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return BookmarkInterface[]
     */
    public function getItems();

    /**
     *
     * @param BookmarkInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
