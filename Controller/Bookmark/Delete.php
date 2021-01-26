<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Controller\Bookmark;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface;
use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Data\Form\FormKey\Validator;

class Delete extends Bookmark
{
    private $bookmarkRepository;

    private $validator;

    private $bookmarkListRepository;

    /**
     * Delete constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param Validator $validator
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param BookmarkListRepositoryInterface $bookmarkListRepository
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        Validator $validator,
        BookmarkRepositoryInterface $bookmarkRepository,
        BookmarkListRepositoryInterface $bookmarkListRepository
    ) {
        parent::__construct($context, $customerSession);
        $this->bookmarkRepository = $bookmarkRepository;
        $this->validator = $validator;
        $this->bookmarkListRepository = $bookmarkListRepository;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->validator->validate($this->getRequest())) {
            return $this->redirectToList();
        }

        $bookmarkId = (int)$this->getRequest()->getParam('bookmarkId');

        try {
            $bookmark = $this->bookmarkRepository->getById($bookmarkId);
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong!'));
            return $this->redirectToList();
        }

        $bookmarkListId = (int)$bookmark->getBookmarkListId();

        try {
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
