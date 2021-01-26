<?php

namespace Inchoo\ProductBookmark\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BookmarkListSearchResultsInterface extends SearchResultsInterface
{

    /**
     * @return BookmarkListInterface[]
     */
    public function getItems();

    /**
     *
     * @param BookmarkListInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
