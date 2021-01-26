<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Block\BookmarkList;

use Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;

class Details extends Template
{

    private $bookmarkRepository;

    private $session;

    private $searchCriteriaBuilder;

    private $productRepository;

    /**
     * Details constructor.
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param Session $session
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ProductRepositoryInterface $productRepository
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        BookmarkRepositoryInterface $bookmarkRepository,
        Session $session,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductRepositoryInterface $productRepository,
        Template\Context $context,
        array $data = []
    ) {
        $this->bookmarkRepository = $bookmarkRepository;
        $this->session = $session;
        parent::__construct($context, $data);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->productRepository = $productRepository;
    }

    /**
     * @return array|mixed[]|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBookmarkedProducts()
    {
        $this->searchCriteriaBuilder
            ->addFilter(BookmarkInterface::BOOKMARK_LIST_ID, $this->getRequest()->getParam('id'), 'eq')
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
