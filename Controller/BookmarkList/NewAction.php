<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Controller\BookmarkList;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkListInterfaceFactory;
use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;

class NewAction extends Bookmark
{

    /**
     * @var BookmarkListInterfaceFactory
     */
    private $bookmarkListModelFactory;

    /**
     * @var BookmarkListRepositoryInterface
     */
    private $bookmarkListRepository;

    /**
     * NewAction constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param BookmarkListInterfaceFactory $bookmarkListModelFactory
     * @param BookmarkListRepositoryInterface $bookmarkListRepository
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        BookmarkListInterfaceFactory $bookmarkListModelFactory,
        BookmarkListRepositoryInterface $bookmarkListRepository
    ) {
        parent::__construct($context, $customerSession);
        $this->bookmarkListModelFactory = $bookmarkListModelFactory;
        $this->bookmarkListRepository = $bookmarkListRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $customerId = (int)$this->customerSession->getId();
            $title = $this->_request->getParam('title');

            if (!$title) {
                $this->messageManager->addErrorMessage('Title must not be empty!');
                return $this->redirectToList();
            }

            $bookmarkList = $this->bookmarkListModelFactory->create();
            $bookmarkList->setBookmarkListTitle($title);
            $bookmarkList->setCustomerId($customerId);
            $this->bookmarkListRepository->save($bookmarkList);

            $this->messageManager->addSuccessMessage(__('Bookmark List created!'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Bookmark List not saved!'));
        }
        return $this->redirectToList();
    }
}
