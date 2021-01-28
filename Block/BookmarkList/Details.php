<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Block\BookmarkList;

use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Inchoo\ProductBookmark\Model\ResourceModel\Bookmark\CollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\Element\Template;

class Details extends Template
{

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var CollectionFactory
     */
    private $bookmarkCollectionFactory;

    /**
     * Details constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param CollectionFactory $bookmarkCollectionFactory
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CollectionFactory $bookmarkCollectionFactory,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
        $this->bookmarkCollectionFactory = $bookmarkCollectionFactory;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBookmarkedProducts()
    {
        $products = $this->bookmarkCollectionFactory->create();
        $products
            ->addFieldToSelect('product_id')
            ->addFieldToSelect('bookmark_id')
            ->addFieldToFilter(
                'bookmark_list_id',
                ['eq' => (int)$this->getRequest()->getParam('id')]
            )->addFieldToFilter(
                BookmarkInterface::WEBSITE_ID,
                ['eq' => $this->_storeManager->getStore()->getWebsiteId()]
            )->getSelect()->join(
                ['product' => 'catalog_product_entity_varchar'],
                'main_table.product_id = product.entity_id',
                'product.value as productName'
            )->group('bookmark_id');
        return $products;
    }
}
