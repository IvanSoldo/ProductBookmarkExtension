<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BookmarkListSearchResultsInterface extends SearchResultsInterface
{

    /**
     * @return BookmarkListInterface[]
     */
    public function getItems(): array;

    /**
     *
     * @param BookmarkListInterface[] $items
     * @return $this
     */
    public function setItems(array $items): SearchResultsInterface;
}
