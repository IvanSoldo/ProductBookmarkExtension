<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Controller\Bookmark;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface;
use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

class Delete extends Bookmark
{
    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * @var BookmarkListRepositoryInterface
     */
    private $bookmarkListRepository;

    /**
     * Delete constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param BookmarkListRepositoryInterface $bookmarkListRepository
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        BookmarkRepositoryInterface $bookmarkRepository,
        BookmarkListRepositoryInterface $bookmarkListRepository
    ) {
        parent::__construct($context, $customerSession);
        $this->bookmarkRepository = $bookmarkRepository;
        $this->bookmarkListRepository = $bookmarkListRepository;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $bookmarkId = (int)$this->getRequest()->getParam('bookmarkId');

        if (!$bookmarkId) {
            return $this->redirectToList();
        }

        try {
            $bookmark = $this->bookmarkRepository->getById($bookmarkId);
            $bookmarkListId = (int)$bookmark->getBookmarkListId();
            $bookmarkList = $this->bookmarkListRepository->getById($bookmarkListId);
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong!'));
            return $this->redirectToList();
        }

        if (!$this->checkOwner((int)$bookmarkList->getCustomerId())) {
            $this->messageManager->addErrorMessage(__('Something went wrong!'));
            return $this->redirectToList();
        }

        $this->bookmarkRepository->delete($bookmark);
        $this->messageManager->addSuccessMessage('Bookmark removed!');
        return $this->redirectToList();
    }
}
