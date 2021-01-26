<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Ui\Component\Listing;

use Inchoo\ProductBookmark\Model\ResourceModel\Bookmark\CollectionFactory as BookmarkCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{

    private $bookmarkCollectionFactory;

    private $productCollectionFactory;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $productCollectionFactory
     * @param BookmarkCollectionFactory $bookmarkCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $productCollectionFactory,
        BookmarkCollectionFactory $bookmarkCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->productCollectionFactory = $productCollectionFactory;
        $this->bookmarkCollectionFactory = $bookmarkCollectionFactory;
    }

    /**
     * @return array|void
     */
    public function getData()
    {
        $bookmarks = $this->bookmarkCollectionFactory->create();
        $productIds = [];
        foreach ($bookmarks as $bookmark) {
            $productIds[] = $bookmark->getProductId();
        }

        if (empty($productIds)) {
            return;
        }
        $bookmarkCounter = array_count_values($productIds);

        $items = $this
            ->getCollection()
            ->addFieldToFilter('entity_id', $productIds)
            ->toArray();

        $data = [
            'totalRecords' => $this->count(),
            'items' => array_values($items),
        ];

        $count = count($data['items']);
        for ($i = 0; $i<$count; $i++) {
            $data['items'][$i]['bookmarkCounter'] = $bookmarkCounter[$data['items'][$i]['entity_id']];
        }

        return $data;
    }

    /**
     * @return AbstractCollection
     */
    public function getCollection()
    {
        if ($this->collection === null) {
            $this->collection = $this->productCollectionFactory->create();
        }
        return $this->collection;
    }
}
