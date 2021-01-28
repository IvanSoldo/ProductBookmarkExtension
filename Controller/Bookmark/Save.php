<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Controller\Bookmark;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkInterfaceFactory;
use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkListInterfaceFactory;
use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Controller\ResultFactory;

class Save extends Bookmark
{
    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * @var BookmarkInterfaceFactory
     */
    private $bookmarkModelFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var BookmarkListRepositoryInterface
     */
    private $bookmarkListRepository;
    /**
     * @var BookmarkListInterfaceFactory
     */
    private $bookmarkListModelFactory;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Save constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param BookmarkInterfaceFactory $bookmarkModelFactory
     * @param StoreManagerInterface $storeManager
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param BookmarkListRepositoryInterface $bookmarkListRepository
     * @param BookmarkListInterfaceFactory $bookmarkListModelFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        BookmarkRepositoryInterface $bookmarkRepository,
        BookmarkInterfaceFactory $bookmarkModelFactory,
        StoreManagerInterface $storeManager,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        BookmarkListRepositoryInterface $bookmarkListRepository,
        BookmarkListInterfaceFactory $bookmarkListModelFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct($context, $customerSession);
        $this->bookmarkRepository = $bookmarkRepository;
        $this->bookmarkModelFactory = $bookmarkModelFactory;
        $this->storeManager = $storeManager;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->bookmarkListRepository = $bookmarkListRepository;
        $this->bookmarkListModelFactory = $bookmarkListModelFactory;
        $this->logger = $logger;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $bookmarkListId = (int)$this->getRequest()->getParam('bookmarkList');
        $productId = (int)$this->getRequest()->getParam('product');
        $websiteId = (int)$this->storeManager->getStore()->getWebsiteId();

        if (!$productId) {
            return $this->redirectToList();
        }

        if (!$bookmarkListId) {
            $bookmarkList = $this->createNewBookmarkList();
        } else {
            try {
                $bookmarkList = $this->bookmarkListRepository->getById($bookmarkListId);
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage(__('Product could not be saved! Please contact customer support.'));
                return $this->redirectToList();
            }
        }

        $bookmark = $this->bookmarkModelFactory->create();
        $bookmark->setBookmarkListId((int)$bookmarkList->getId());
        $bookmark->setProductId($productId);
        $bookmark->setWebsiteId($websiteId);

        if ($this->checkBookmark($bookmark)) {
            $this->messageManager->addErrorMessage(__('Product already bookmarked!'));
            return $this->redirectToList();
        }

        if (!$this->checkOwner((int)$bookmarkList->getCustomerId())) {
            $this->messageManager->addErrorMessage(__('Product could not be bookmarked! Please contact customer support.'));
            return $this->redirectToList();
        }

        try {
            $this->bookmarkRepository->save($bookmark);
        } catch (\Exception $exception) {
            $this->logger->critical('Error message', ['exception' => $exception]);
            $this->messageManager->addErrorMessage(__('Product could not be bookmarked!'));
            return $this->redirectToList();
        }

        $this->messageManager->addSuccessMessage(__('Bookmark added!'));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }

    /**
     * Checks if product is already bookmarked.
     *
     * @param BookmarkInterface $bookmark
     * @return bool
     */
    private function checkBookmark(BookmarkInterface $bookmark)
    {
        $this->searchCriteriaBuilder
            ->addFilter(BookmarkInterface::PRODUCT_ID, $bookmark->getProductId(), 'eq')
            ->addFilter(BookmarkInterface::WEBSITE_ID, $bookmark->getWebsiteId(), 'eq')
            ->addFilter(BookmarkInterface::BOOKMARK_LIST_ID, $bookmark->getBookmarkListId(), 'eq');
        $searchCriteria = $this->searchCriteriaBuilder->create();

        return (bool)$this->bookmarkRepository->getList($searchCriteria)->getTotalCount();
    }

    /**
     * If user doesnt have any bookmark lists, create a default one
     *
     * @return BookmarkListInterface
     */
    private function createNewBookmarkList()
    {
        $bookmarkList = $this->bookmarkListModelFactory->create();
        $bookmarkList->setBookmarkListTitle("Default");
        $bookmarkList->setCustomerId((int)$this->customerSession->getCustomerId());
        $this->bookmarkListRepository->save($bookmarkList);
        return $bookmarkList;
    }
}
