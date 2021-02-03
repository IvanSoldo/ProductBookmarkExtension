<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Controller\BookmarkList;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;

class Delete extends Bookmark
{
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
     * @param BookmarkListRepositoryInterface $bookmarkListRepository
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        BookmarkListRepositoryInterface $bookmarkListRepository,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct($context, $customerSession);
        $this->bookmarkListRepository = $bookmarkListRepository;
        $this->logger = $logger;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');

        if (!$id) {
            return $this->redirectToList();
        }

        try {
            $bookmarkList = $this->bookmarkListRepository->getById($id);
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong! Please contact customer support.'));
            return $this->redirectToList();
        }

        if (!$this->checkOwner((int)$bookmarkList->getCustomerId())) {
            $this->messageManager->addErrorMessage(__('Something went wrong! Please contact customer support.'));
            return $this->redirectToList();
        }

        try {
            $this->bookmarkListRepository->delete($bookmarkList);
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong! Please contact customer support.'));
            $this->logger->critical('Error message', ['exception' => $e]);
            return $this->redirectToList();
        }
        $this->messageManager->addSuccessMessage(__('Bookmark List deleted!'));

        return $this->redirectToList();
    }
}
