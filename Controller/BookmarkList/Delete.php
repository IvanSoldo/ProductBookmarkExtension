<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Controller\BookmarkList;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Bookmark
{

    private $bookmarkListRepository;

    /**
     * Delete constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param BookmarkListRepositoryInterface $bookmarkListRepository
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        BookmarkListRepositoryInterface $bookmarkListRepository
    ) {
        parent::__construct($context, $customerSession);
        $this->bookmarkListRepository = $bookmarkListRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $bookmarkList = $this->bookmarkListRepository->getById((int)$this->getRequest()->getParam('id'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong!'));
            return $this->redirectToList();
        }

        if (!$this->checkOwner((int)$bookmarkList->getCustomerId())) {
            $this->messageManager->addErrorMessage(__('Something went wrong!'));
            return $this->redirectToList();
        }

        if ($bookmarkList->getIsDeletable() == false) {
            $this->messageManager->addErrorMessage(__('Default list cannot be deleted!'));
            return $this->redirectToList();
        }

        $this->bookmarkListRepository->delete($bookmarkList);
        $this->messageManager->addSuccessMessage(__('Bookmark List deleted!'));

        return $this->redirectToList();
    }
}
