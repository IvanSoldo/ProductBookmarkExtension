<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\ViewModel;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class BookmarkListViewModel implements ArgumentInterface
{

    private $searchCriteriaBuilder;

    private $bookmarkListRepository;

    private $session;

    
    /**
     * BookmarkListViewModel constructor.
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param BookmarkListRepositoryInterface $bookmarkListRepository
     * @param Session $session
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        BookmarkListRepositoryInterface $bookmarkListRepository,
        Session $session
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->bookmarkListRepository = $bookmarkListRepository;
        $this->session = $session;
    }

    /**
     * @return mixed
     */
    public function getBookmarkLists()
    {
        $this->searchCriteriaBuilder
            ->addFilter(BookmarkListInterface::CUSTOMER_ID, $this->session->getCustomerId(), 'eq');
        $searchCriteria = $this->searchCriteriaBuilder->create();

        return $this->bookmarkListRepository->getList($searchCriteria)->getItems();
    }

    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        if ($this->session->getCustomerId()) {
            return true;
        }
        return false;
    }
}
