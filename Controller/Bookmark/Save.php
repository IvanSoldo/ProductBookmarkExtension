<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Controller\Bookmark;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkInterfaceFactory;
use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Store\Model\StoreManagerInterface;

class Save extends Bookmark
{

    private $bookmarkRepository;

    private $bookmarkModelFactory;

    private $storeManager;

    private $validator;

    private $searchCriteriaBuilder;

    private $bookmarkListRepository;

    /**
     * Save constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param BookmarkInterfaceFactory $bookmarkModelFactory
     * @param StoreManagerInterface $storeManager
     * @param Validator $validator
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param BookmarkListRepositoryInterface $bookmarkListRepository
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        BookmarkRepositoryInterface $bookmarkRepository,
        BookmarkInterfaceFactory $bookmarkModelFactory,
        StoreManagerInterface $storeManager,
        Validator $validator,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        BookmarkListRepositoryInterface $bookmarkListRepository
    ) {
        parent::__construct($context, $customerSession);
        $this->bookmarkRepository = $bookmarkRepository;
        $this->bookmarkModelFactory = $bookmarkModelFactory;
        $this->storeManager = $storeManager;
        $this->validator = $validator;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->bookmarkListRepository = $bookmarkListRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        if (!$this->validator->validate($this->getRequest())) {
            return $this->redirectToList();
        }

        $bookmarkListId = (int)$this->getRequest()->getParam('bookmarkList');
        $productId = (int)$this->getRequest()->getParam('product');
        $websiteId = (int)$this->storeManager->getStore()->getWebsiteId();

        try {
            $bookmarkList = $this->bookmarkListRepository->getById($bookmarkListId);
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Product could not be saved!'));
            return $this->redirectToList();
        }

        $bookmark = $this->bookmarkModelFactory->create();
        $bookmark->setBookmarkListId($bookmarkListId);
        $bookmark->setProductId($productId);
        $bookmark->setWebsiteId($websiteId);

        if (!$this->checkBookmark($bookmark)) {
            $this->messageManager->addErrorMessage(__('Product already bookmarked!'));
            return $this->redirectToList();
        }

        if (!$this->checkOwner((int)$bookmarkList->getCustomerId())) {
            $this->messageManager->addErrorMessage(__('Product could not be bookmarked!'));
            return $this->redirectToList();
        }

        try {
            $this->bookmarkRepository->save($bookmark);
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Product could not be bookmarked!'));
            return $this->redirectToList();
        }

        $this->messageManager->addSuccessMessage(__('Bookmark added!'));
        return $this->redirectToList();
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

        if (empty($this->bookmarkRepository->getList($searchCriteria)->getItems())) {
            return true;
        }
        return false;
    }
}
