<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Ui\Component\Listing;

use Inchoo\ProductBookmark\Model\ResourceModel\Bookmark\CollectionFactory as BookmarkCollectionFactory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var BookmarkCollectionFactory
     */
    private $bookmarkCollectionFactory;


    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param BookmarkCollectionFactory $bookmarkCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        BookmarkCollectionFactory $bookmarkCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->bookmarkCollectionFactory = $bookmarkCollectionFactory;
    }

    /**
     * @return array|void
     */
    public function getData()
    {
        return $this->getCollection()->getProducts()->toArray();
    }

    /**
     * @return AbstractCollection
     */
    public function getCollection()
    {
        if ($this->collection === null) {
            $this->collection = $this->bookmarkCollectionFactory->create();
        }
        return $this->collection;
    }
}
