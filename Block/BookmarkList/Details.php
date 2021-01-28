<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Block\BookmarkList;

use Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;

class Details extends Template
{

    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * Details constructor.
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ProductRepositoryInterface $productRepository
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        BookmarkRepositoryInterface $bookmarkRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductRepositoryInterface $productRepository,
        Template\Context $context,
        array $data = []
    ) {
        $this->bookmarkRepository = $bookmarkRepository;
        parent::__construct($context, $data);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->productRepository = $productRepository;
    }


    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBookmarkedProducts()
    {
        $this->searchCriteriaBuilder
            ->addFilter(BookmarkInterface::BOOKMARK_LIST_ID, (int)$this->getRequest()->getParam('id'), 'eq')
            ->addFilter(BookmarkInterface::WEBSITE_ID, $this->_storeManager->getStore()->getWebsiteId(), 'eq');
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $bookmarks = $this->bookmarkRepository->getList($searchCriteria)->getItems();
        $products = [];
        foreach ($bookmarks as $bookmark) {
            $products += [$bookmark->getId() => $this->productRepository->getById($bookmark->getProductId())];
        }
        return $products;
    }
}
