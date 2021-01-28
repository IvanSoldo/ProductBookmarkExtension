<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BookmarkSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return BookmarkInterface[]
     */
    public function getItems(): array;

    /**
     *
     * @param BookmarkInterface[] $items
     * @return $this
     */
    public function setItems(array $items): SearchResultsInterface;
}
