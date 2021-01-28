<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Controller\Bookmark;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface;
use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;

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
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Delete constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param BookmarkListRepositoryInterface $bookmarkListRepository
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        BookmarkRepositoryInterface $bookmarkRepository,
        BookmarkListRepositoryInterface $bookmarkListRepository,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct($context, $customerSession);
        $this->bookmarkRepository = $bookmarkRepository;
        $this->bookmarkListRepository = $bookmarkListRepository;
        $this->logger = $logger;
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
            $this->messageManager->addErrorMessage(__('Something went wrong! Please contact customer support.'));
            return $this->redirectToList();
        }

        if (!$this->checkOwner((int)$bookmarkList->getCustomerId())) {
            $this->messageManager->addErrorMessage(__('Something went wrong! Please contact customer support.'));
            return $this->redirectToList();
        }

        try {
            $this->bookmarkRepository->delete($bookmark);
        } catch (LocalizedException $e) {
            $this->logger->critical('Error message', ['exception' => $e]);
            $this->messageManager->addErrorMessage(__('Something went wrong! Please contact customer support.'));
            return $this->redirectToList();

        }
        $this->messageManager->addSuccessMessage('Bookmark removed!');
        return $this->redirectToList();
    }
}
